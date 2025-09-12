<?php

declare(strict_types=1);

namespace DLUnire\Services\Utilities;

use DLRoute\Server\DLServer;
use DLUnire\Errors\CSVParserException;

/**
 * ParserCSV
 *
 * Analizador sintáctico para archivos con formato CSV, con soporte para comillas anidadas,
 * delimitadores personalizados y validación estructural por línea.
 * 
 * @package DLUnire\Services\Utilities
 * @version v0.1.0
 * @author David E Luna M
 * @license MIT
 * @copyright Copyright (c) 2025 David E Luna M
 *
 * @property-read string|null $separator Separador detectado en tiempo de construcción
 * @property string|null $content_separator Separador utilizado internamente durante el análisis
 * @property int $check_quantity_line_max Cantidad de líneas que serán analizadas para inferencia
 * @property string $content Contenido crudo del archivo
 * @property array $subquotes Subcomillas capturadas
 * @property array $quotes Comillas contenedoras capturadas
 */

class CSVParser {

    /** @var string SUBSTRING */
    private const SUBSTRING = "__SUBSTRING_";

    /** @var string STRING */
    private const STRING = "__STRING_";

    /** @var string NUMBER */
    private const NUMBER = "__NUMBER_";

    /** @var string BOOLEAN */
    private const BOOLEAN = "__BOOLEAN_";

    /** @var string DATE */
    private const DATE = "__DATE_";

    /** @var string HOUR */
    private const HOUR = "__HOUR_";

    /** @var string[] BOM */
    private const BOM = [
        "/\xFE\xFF/",           // UTF-16 BE
        "/\xFF\xFE/",           // UTF-16 LE
        "/\xEF\xBB\xBF/",       // UTF-8
        "/\x00\x00\xFE\xFF/",   // UTF-32 BE
        "/\xFF\xFE\x00\x00/",   // UTF-32 LE,
    ];

    /**
     * Saltosde línea a ser normalizados
     * 
     * @var string[] BREAK_LINES
     */
    private const BREAK_LINES = ["/\x0D\x0A/", "/\x0D/"];

    /**
     * Salto de línea normalizado
     * 
     * @var string BREAK
     */
    private const BREAK = "\x0A";

    /**
     * Separador binario
     * 
     * @var string BINARY_SEPARATOR
     */
    private const BINARY_SEPARATOR = "\x01\xff";

    /**
     * Separadores posibles.
     * 
     * @var array<int,string> POSSIBLE_SEPARATORS
     */
    private const POSSIBLE_SEPARATORS = [",", ";", "\x09", ":", "\x7c"];

    /**
     * Delimitadores posibles
     * 
     * @var array<int, string> POSSIBLE_DELIMITERS
     */
    private const POSSIBLE_DELIMITERS = ['"', "'", "`"];

    /** @var string BINARY_DELIMITER */
    private const BINARY_DELIMITER = "\xff";

    /**
     * Indica se se permite la eliminación de los BOMs
     *
     * @var boolean $delete_bom
     */
    private bool $delete_bom = true;

    /**
     * Lineas extraídas del archivo
     *
     * @var array<int, string> $lines
     */
    private array $lines = [];

    /**
     * Separador de campo o columnas
     *
     * @var string|null $separator
     */
    private ?string $separator = null;

    /**
     * Contenido crudo del archivo con formato CSV
     *
     * @var string
     */
    private readonly string $content;

    /**
     * Contenido tokenizado
     *
     * @var string|null $tokenized_content
     */
    private ?string $tokenized_content = null;

    /**
     * Delimitadores de subcadenas con `""`, `''` o (``) capturadas.
     *
     * @var array<string,string> $subquotes
     */
    private array $substrings = [];

    /** @var array<string, string> $hours */
    private array $hours = [];

    /**
     * Almacena los token de las fechas
     *
     * @var array<string, string> $dates
     */
    private array $dates = [];

    /**
     * Delimitador de subcadena
     *
     * @var string|null $subdelimiter
     */
    private ?string $subdelimiter = null;

    /**
     * Delimitadores de cadenas con `"`, `'` o (`) capturadas
     *
     * @var array $strings
     */
    private array $strings = [];

    /**
     * Delimitador actual
     *
     * @var string|null $delimiter
     */
    private ?string $delimiter = null;

    /**
     * Almacena los tokens de números encontrados en el contenido
     *
     * @var array<string,string> $numbers
     */
    private array $numbers = [];

    /**
     * Almacenan los tokens que representan valores booleanos.
     *
     * @var array<string,string> $booleans
     */
    private array $booleans = [];

    /**
     * Campos o columnas
     *
     * @var array<int,string> $fields
     */
    private array $fields = [];

    /**
     * Cantidad de columnas
     *
     * @var integer $field_quantity
     */
    private int $field_quantity = 0;

    /**
     * Datos del contenido en formato CSV en un array de array asociativo
     *
     * @var array<int,array<string,string> $data
     */
    private array $data = [];
    /**
     * Renderiza el contenido CSV a un array asociativo
     *
     * @param string $filename Archivo a ser leído.
     * @param boolean $delete_bom [Opcional] Permite decidir si eliminar BOMs o no. El valor por defectoes `true`
     * @return array<int,array<string,string>>
     */
    public function render_to_array(string $filename, bool $delete_bom = true): array {
        $this->delete_bom = $delete_bom;

        /** Carga el contenido base */
        $this->load_content($filename, $delete_bom);

        /** Establece los delimitadores de cadena contenedor */
        $this->set_delimiter(false);

        /** Establece los delimitadores de las subcadenas */
        $this->set_delimiter();

        /** Tokeniza el contenido para aislar el separador */
        $this->tokenizer();

        /**
         * Extrae las líneas del contenido para cargar el separador a partir de la cabecera
         */
        $this->load_lines();

        /** Se carga el separador original */
        $this->load_separator();

        /** Se reemplaza por uno con formato binario */
        $this->replace_separator();

        /** Restablece el contenido original conservando el separador binario */
        $this->reset_content();

        /**
         * Se llamada de nuevo para cargar el nuevo separador en todas las líneas.
         */
        $this->load_lines();

        /** Carga las columnas o campos */
        $this->load_columns();

        /** Carga los datos en un array de array asociativos */
        $this->load_data();
        return $this->data;
    }

    /**
     * Carga el contenido del archivo a la propiedad `$this->content`. 
     *
     * @param string $filename Ruta relativa al archivo con el contenido que será cargadoen `$this->content`
     * @param boolean $delete_bom [Opcional] Permite decidir si eliminar BOMs o no. El valor por defecto es `true`
     * @return void
     * 
     * @throws CSVParserException Lanza una excepción con el código de estado HTTP 404 si el archivo no existe.
     */
    private function load_content(string $filename, bool $delete_bom = true): void {
        $filename = preg_replace('/[\\/\\\\]+/', DIRECTORY_SEPARATOR, $filename);
        $filename = trim($filename, "\/");

        /** @var string $root */
        $root = DLServer::get_document_root();

        /** @var string $separator */
        $separator = DIRECTORY_SEPARATOR;

        /** @var string $file */
        $file = "{$root}{$separator}{$filename}";

        /** @var string $name_only */
        $name_only = basename($file);

        if (!file_exists($file)) {
            throw new CSVParserException("El archivo «{$name_only}» no existe. Verifique no haya sido eliminado o se haya cambiado de ubicación", 404);
        }

        if (!is_file($file) || !is_readable($file)) {
            throw new CSVParserException("El archivo «{$name_only}» no es válido o no se puede leer", 404);
        }

        /** @var string $content */
        $content = file_get_contents($file) ?? '';

        $this->remove_bom($content);
        $this->content = $content;
        $this->tokenized_content = trim($this->content);
        $this->normalize_line();
    }

    /**
     * Normaliza los saltos de líneas para evitar efectos colaterales
     *
     * @return void
     */
    private function normalize_line(): void {
        $this->tokenized_content = preg_replace(static::BREAK_LINES, static::BREAK, $this->tokenized_content);
    }

    /**
     * Elimina contenido BOM de la entrada
     *
     * @param string $input Entrada a ser analizada
     * @return void
     */
    private function remove_bom(string &$input): void {
        if ($this->delete_bom) {
            $input = preg_replace(static::BOM, '', $input);
        }
    }

    /**
     * Extrae las líneas del archivo a ser analizado y las carga en `$this->lines`.
     *
     * @return void
     */
    private function load_lines(): void {
        $this->lines = explode("\x0A", $this->tokenized_content ?? $this->content);
    }

    /**
     * Carga las columnas en un array asociativo
     *
     * @return void
     */
    private function load_columns(): void {
        /** @var string|null $line */
        $line = $this->lines[0] ?? null;

        if (!is_string($line) || empty(trim($line))) {
            throw new CSVParserException("El archivo no tiene contenido", 422);
        }

        /** @var array<int,string> $current_fields */
        $current_fields = explode(static::BINARY_SEPARATOR, $line);

        $this->fields = $current_fields;
        $this->field_quantity = count($current_fields);
    }

    /**
     * Carga los datos del archivo en un array de array asociativo
     *
     * @return void
     */
    private function load_data(): void {
        foreach ($this->lines as $index => $string_line) {
            if ($index < 1) continue;

            /** @var int $line */
            $line = $index + 1;

            /** @var array<string,mixed> $content */
            $content = [];

            /** @var array<int,string> $cells */
            $cells = explode(static::BINARY_SEPARATOR, $string_line);

            /** @var int $current_quantity */
            $current_quantity = count($cells);

            /** @var string $current_value */
            $current_value = $cells[$current_quantity - 1];

            $current_value = $this->delimiter
                ? str_replace($this->delimiter, '', $current_value)
                : $current_value;

            if ($current_quantity !== $this->field_quantity) {
                throw new CSVParserException("Error de formato CSV en la «línea {$line}»: la cantidad de celdas es inferior la cantidad de campos definidos: «{$current_value}».", 422);
            }

            foreach ($cells as $key => $value) {
                $value = trim($value);

                /** @var string|null $field */
                $field = $this->fields[$key] ?? null;

                if (is_null($field)) {
                    throw new CSVParserException("Error de formato CSV en la línea {$line}: cantidad de celdas excede la cantidad de campos definidos. Valor fuera de rango: «{$value}»'.", 422);
                }


                $field = $this->delimiter
                    ? str_replace($this->delimiter, '', $this->fields[$key])
                    : $this->fields[$key];

                $content_string = $this->delimiter
                    ? str_replace($this->delimiter, '', $value)
                    : $value;

                if (is_string($this->delimiter)) {
                    $value = str_replace(static::BINARY_DELIMITER, $this->delimiter, $content_string);
                }

                $value = trim($value);

                $content[$field] = $value;
            }
            $this->data[] = $content;
        }
    }

    /**
     * Carga el separador más utilizado en el archivo a analizar.
     *
     * Si no se encuentra ningún separador en la línea (es decir, si la línea representa
     * una sola columna sin delimitadores), carga `null`.
     *
     * Lanza una excepción si la línea está vacía o solo contiene espacios.
     *
     * @param boolean $content_separator [Opcional] Indicar si cargar el separador de contenido.
     * 
     * @return void
     *
     * @throws CSVParserException Si la línea está vacía
     */
    private function load_separator(bool $content_separator = false): void {
        $line = $this->lines[0] ?? '';

        if (empty(trim($line))) {
            throw new CSVParserException("El archivo no tiene cabecera ni separadores", 500);
        }

        /** @var array<string, int> $quantity_separators */
        $quantity_separators = [];

        /** @var string|null $current_separator */
        $current_separator = null;

        /** @var int $max_quantity */
        $max_quantity = 0;

        foreach (static::POSSIBLE_SEPARATORS as $separator) {
            $quantity_separators[$separator] = substr_count($line, $separator);
        }

        foreach ($quantity_separators as $separator => $quantity) {
            if ($quantity <= $max_quantity) continue;

            $max_quantity = $quantity;
            $current_separator = $separator;
        }

        if ($content_separator) {
            $this->content_separator = $current_separator;
        } else {
            $this->separator = $current_separator;
        }
    }

    /**
     * Establece el delimitador antes de procesar el archivo CSV.
     *
     * @param boolean $container Indica si el delimitador es contenedor o no.
     * @return void
     */
    private function set_delimiter(bool $container = true): void {
        /** @var string|null $delimiter */
        $delimiter = null;

        /** @var int $quantity */
        $quantity = 0;

        foreach (static::POSSIBLE_DELIMITERS as $current_delimiter) {
            /** @var string $scaped */
            $escaped = preg_quote($current_delimiter, "/");

            $pattern = $container
                ? "/{$escaped}{1}[\s\S]+?{$escaped}{1}/"
                : "/{$escaped}{2}[\s\S]+?{$escaped}{2}/";

            preg_match_all($pattern, $this->tokenized_content, $matches);
            $current_quantity = count($matches[0]);

            if ($current_quantity <= $quantity) continue;

            $delimiter = $current_delimiter;
            $quantity = $current_quantity;
        }

        if ($container) {
            $this->delimiter = $delimiter;
        } else {
            $this->subdelimiter = $delimiter;
        }
    }

    /**
     * Tokeniza el contenido CSV. Es decir, los delimitadores se traducen a tokens
     * mucho más predecibles.
     *
     * @return void
     */
    private function tokenizer(): void {
        $this->tokenizer_substring();
        $this->tokenizer_string();
        $this->tokenizer_date();
        $this->tokenizer_hour();
        $this->tokenizer_number();
        $this->tokenizer_boolean();
    }

    /**
     * Tokeniza el contenido en general en función de la preferencia seleccionada
     *
     * @param string $token_name [Opcional] Nombre de token
     * @return void
     * 
     * @throws CSVParserException
     */
    private function tokenizer_content(string $token_name = self::SUBSTRING): void {

        if ($token_name !== static::SUBSTRING && $token_name !== static::STRING) {
            throw new CSVParserException("Solo se permiten los valores «self::SUBSTRING» y «self::STRING»", 500);
        }

        if (is_null($this->delimiter) || (is_null($this->subdelimiter) && $token_name === static::SUBSTRING)) {
            return;
        }

        /** @var string $delimiter */
        $delimiter = preg_quote($this->delimiter, "/");

        /** @var int $repeat */
        $repeat = $token_name === static::SUBSTRING ? 2 : 1;

        /** @var string $pattern */
        $pattern = "/{$delimiter}{{$repeat}}[\s\S]*?{$delimiter}{{$repeat}}/";

        /** @var int $index */
        $index = 0;

        $content = preg_replace_callback($pattern, function (array $value) use (&$index, $token_name) {
            /** @var string $subcontent */
            $subcontent = $value[0] ?? '';

            /** @var string $token */
            $token = $this->get_token($token_name, $index);

            switch (true) {
                case $token_name === static::SUBSTRING:
                    $this->clean_substring($subcontent);
                    $this->substrings[$token] = $subcontent;
                    break;
                case $token_name === static::STRING:
                    $this->clean_content($subcontent, true);
                    $this->strings[$token] = $subcontent;
                    break;
                default:
                    $this->clean_substring($subcontent);
                    $this->substrings[$token] = $subcontent;
                    break;
            }

            return $token;
        }, $this->tokenized_content);

        $this->tokenized_content = $content;
    }

    /**
     * Devuelve el token a partirdel tipo e índice
     *
     * @param string $type Tipo de token
     * @param integer $index Índice de token
     * @return string
     */
    private function get_token(string $type, int &$index): string {
        return $type . ++$index . "_";
    }

    /**
     * Limpia el contenido mal formateado
     *
     * @param string|null $content Contenido a ser analizado
     * @param boolean $is_string Indica si se trata de una cadena de texto
     * @return void
     */
    private function clean_content(?string &$content, bool $is_string = false): void {
        if (is_null($content)) return;

        if (is_string($this->delimiter)) {
            $content = trim($content, $this->delimiter);
        }

        $content = trim($content);

        if ($is_string && is_string($this->delimiter)) {
            $content = "{$this->delimiter}{$content}{$this->delimiter}";
        }
    }

    /**
     * Limpia el contenido de la subcadena
     *
     * @param string|null $content
     * @return void
     */
    private function clean_substring(?string &$content): void {
        if (is_null($content)) return;

        if (is_string($this->delimiter)) {
            $content = trim($content, $this->delimiter);
        }

        $content = trim($content);

        if (is_string($this->delimiter)) {
            $content = "{$this->delimiter}{$this->delimiter}{$content}{$this->delimiter}{$this->delimiter}";
        }
    }

    /**
     * Transforma a tokens todas las subcadenas existentes en el contenido del archivo
     *
     * @return void
     */
    private function tokenizer_substring(): void {
        $this->tokenizer_content();
    }

    /**
     * Transforma a tokens todas las cadenas del contenido
     *
     * @return void
     */
    private function tokenizer_string(): void {
        $this->tokenizer_content(static::STRING);
    }

    /**
     * Convierte a token cada fecha encontrada en el contenido
     *
     * @return void
     */
    private function tokenizer_date(): void {
        /** @var string $pattern */
        $pattern = "/(([0-9]{1,}(\/|-)[0-9]{2}(\/|-)[0-9]{1,}))/";

        /** @var int $index */
        $index = 0;

        /** @var string $content */
        $content = preg_replace_callback($pattern, function (array $value) use (&$index) {
            /** @var string $subcontent */
            $subcontent = $value[0] ?? '';
            $this->clean_content($subcontent);

            /** @var string $token */
            $token = $this->get_token(static::DATE, $index);

            $this->dates[$token] = $subcontent;
            return $token;
        }, $this->tokenized_content);

        $this->tokenized_content = $content;
    }

    /**
     * Tokeniza todas las horas encontradas en el archivo CSV
     *
     * @return void
     */
    private function tokenizer_hour(): void {
        /** @var string $pattern */
        $pattern = "/[0-9]{2}:[0-9]{2}:[0-9]{2}/";

        /** @var int $index */
        $index = 0;

        $content = preg_replace_callback($pattern, function (array $value) use (&$index) {
            /** @var string $subcontent */
            $subcontent = $value[0] ?? '';
            $this->clean_content($subcontent);

            /** @var string $token */
            $token = $this->get_token(static::HOUR, $index);

            $this->hours[$token] = $subcontent;
            return $token;
        }, $this->tokenized_content);
        $this->tokenized_content = $content;
    }

    /**
     * Tokeniza los números en formato inglés marcadores
     *
     * @return void
     */
    private function tokenizer_number(): void {
        /** @var string $pattern */
        $pattern = "/\b\d+(\.\d+)?/";

        /** @var int $index */
        $index = 0;

        /** @var string $content */
        $content = preg_replace_callback($pattern, function (array $value) use (&$index) {
            /** @var string $subcontent */
            $subcontent = $value[0] ?? '';
            $this->clean_content($subcontent);

            /** @var string $token */
            $token = $this->get_token(static::NUMBER, $index);

            $this->numbers[$token] = $subcontent;
            return $token;
        }, $this->tokenized_content);

        $this->tokenized_content = $content;
    }

    /**
     * Tokeniza los valores booleanos del contenido
     *
     * @return void
     */
    private function tokenizer_boolean(): void {
        /** @var string $pattern */
        $pattern = "/\btrue|false/i";

        /** @var int $index */
        $index = 0;

        $content = preg_replace_callback($pattern, function (array $value) use (&$index) {
            /** @var string $subcontent */
            $subcontent = $value[0] ?? '';
            $this->clean_content($subcontent);

            /** @var string $token */
            $token = $this->get_token(static::BOOLEAN, $index);

            $this->booleans[$token] = $subcontent;
            return $token;
        }, $this->tokenized_content);

        $this->tokenized_content = $content;
    }

    /**
     * Reemplaza el separador actual por uno binario
     *
     * @return void
     */
    private function replace_separator(): void {
        if (!is_string($this->separator) || empty($this->separator)) return;

        /** @var string $content */
        $content = preg_replace("/{$this->separator}/i", static::BINARY_SEPARATOR, $this->tokenized_content);

        $this->tokenized_content = $content;
    }

    /**
     * Revierte el contenido previamente convertido a token al formato original, pero manteniendo
     * el separador binario.
     *
     * @return void
     */
    private function reset_content(): void {
        /** @var string $content */
        $content = $this->tokenized_content;
        if (!is_string($content)) return;

        /** @var string|null $delimiter */
        $delimiter = $this->delimiter;

        foreach ($this->strings as $token => $value) {
            if (!is_string($value)) continue;
            $content = preg_replace("/$token/i", $value, $content);
        }

        foreach ($this->substrings as $token => $value) {
            if (!is_string($value)) continue;

            if (is_string($delimiter)) {
                $value = str_replace("{$delimiter}{$delimiter}", static::BINARY_DELIMITER, $value);
            }

            $content = preg_replace("/$token/i", $value, $content);
        }

        foreach ($this->dates as $token => $date) {
            if (!is_string($date)) continue;
            $content = preg_replace("/$token/i", $date, $content);
        }

        foreach ($this->hours as $token => $hour) {
            if (!is_string($hour)) continue;
            $content = preg_replace("/$token/i", $hour, $content);
        }

        foreach ($this->booleans as $token => $boolean) {
            if (!is_string($boolean)) continue;
            $content = preg_replace("/$token/i", $boolean, $content);
        }

        foreach ($this->numbers as $token => $number) {
            if (!is_string($number)) continue;

            $content = preg_replace("/$token/i", $number, $content);
        }

        $this->tokenized_content = $content;
    }
}
