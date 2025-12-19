<?php

declare(strict_types=1);

namespace DLUnire\Services\Utilities;

use DLStorage\Storage\SaveData;
use InvalidArgumentException;

/**
 * Interactúa con DLStorage para almacenar datos en formato binario de forma estructurada
 * de forma genérica.
 * 
 * **Importante:** En esta abstracción se evita lanzar excepciones durante la lectura.
 * Las excepciones solo se propagan durante la operación de guardado o validación deliberada.
 * 
 * Se utiliza `try { ... } catch (...) { ... }` para cambiar el comportamiento de la inexistencia del archivo,
 * durante su lectura para que devuelva un `null` en lugar de lanzar excepciones.
 * 
 * @package DLUnire\Services\Utilities
 * 
 * @version v0.0.1 (release)
 * @author David E Luna M <dlunireframework@gmail.com>
 * @copyright (c) 2025 David E Luna M
 * @license Comercial
 */
final class Data extends SaveData {

    /**
     * Llave o frase de entropía que se utilizará para cifrar los datos en formato binario.
     *
     * @var string|null $entropy
     */
    private ?string $entropy = null;

    /**
     * Devuelve los datos a partir del nombre de archivo sin extensión. Si el archivo
     * no existe o el valor devuelto no tiene el formato esperado, entonces, devolverá `NULL`.
     *
     * @param string $filename Nombre de archivo.
     * @return array|null
     */
    public function get(string $filename): ?array {
        /**
         * Contenido crudo (raw) devuelto por el archivo, sí este existe, de lo contrario,
         * el valor devuelto es `null`.
         * 
         * @var string|null $content
         */
        $content = $this->read_file(filename: $filename);

        /** @var array|null $data */
        $data = json_decode(json: $content ?? '', associative: true);

        return \is_array(value: $data) ? $data : null;
    }

    /**
     * Almacena los datos en formato binario. Los datos de entrada son un array.
     * 
     * ### Recomendaciones
     * 
     * Se recomienda pasar como argumento de entrada en el segundo parámetro un array asociativo
     * para que se almacenen en formato JSON en el contenedor binario los datos. Debe establecer
     * el parámetro `$eval` a `true` para que el formato de array sea validado.
     * 
     * El array que haya ingresado se transformará a formato JSON, que a su vez será transformado a
     * formato binario. 
     * 
     * @example location description
     * 
     * ```
     * <?php
     * $raw_data = [...];
     * $data = new Data();
     * $data->set_entropy('Tu llave de entropía aquí. También se permiten datos binarios crudos');
     * $data->save('filename', $raw_data);
     * ```
     * 
     * > **Importante:** Los datos no deben tener BOM, porque se almacenará un archivo binario sin
     * > carga útil (`payload`).
     * 
     * @param string $filename Nombre de archivo (sin extensión).
     * @param array $data Datos a ser almacenados.
     * @param bool $eval [Opcional] Permite de forma deliverada decidir si se desea evaluar si se trata
     *                   de un `array` asociativo. Si se decide evaluar y el array no es asociativo,
     *                   entonces, lanzará una excepción.
     * 
     *                   El valor por defecto es `false`.
     * @return void
     */
    public function save(string $filename, array $data, bool $eval = false): void {
        $this->validate_associative_array(array: $data, eval: $eval);

        $this->save_data(
            filename: $filename,
            data: json_encode($data),
            entropy: $this->get_phrase()
        );
    }

    /**
     * Establece la llave de entropía para almacenar datos binarios.
     *
     * @param string|null $entropy Llave de entropía.
     * @return void
     */
    public function set_entropy(?string $entropy = null): void {
        $this->entropy = hash('sha256', $entropy ?? '');
    }

    /**
     * Devuelve la frase de entropía
     *
     * @return string|null
     */
    public function get_phrase(): ?string {
        return $this->entropy;
    }

    /**
     * Lee el archivo previamente almacenado. Si éste no existe, simplemente devolverá un `null`
     *
     * @return string|null
     */
    private function read_file(string $filename): ?string {

        /**
         * Llave de entropía
         * 
         * @var string|null $entropy
         */
        $entropy = $this->get_phrase();

        /** @var string|null $content */
        $content = null;

        try {
            $content = $this->read_storage_data($filename, $entropy);
        } catch (\Exception $error) {
            return $content;
        }

        return $content;
    }

    /**
     * Lanza una excepción de tipo `InvalidArgumentException` cuando el array a evaluar no es un array
     * asociativo y el segundo parámetro tiene como argumento `true`.
     * 
     * ### Criterio a tomar en cuenta
     * 
     * Todas sus claves deben ser de tipo `string` para mantener la consistencia de objeto de tipo `clave: valor`
     * para un formato JSON de salida.
     * 
     * La clave del array asociativo debe tener, al menos, un carácter.
     * 
     * @param array $array Array a ser evaluado.
     * @param bool $eval Permite decidir de forma delivarada si desea evaluar un array o no. Cuando 
     *                   su valor es `true` evalúa si el array es asociativo o no. El valor por defecto
     *                   es `false`. 
     * @return void
     * 
     * @throws InvalidArgumentException
     */
    private function validate_associative_array(array $array, bool $eval = false): void {
        if (!$eval) return;

        foreach ($array as $key => $value) {
            $this->validate_key(key: $key);
        }
    }

    /**
     * Valida si la clave para array asociativo cumple con el criterio acordado:
     * 
     * - Debe tener al menos un carácter, por lo tanto, solo se permiten letras del alfabeto, 
     *   guiones o subguiones.
     * - Debe empezar por una letra del alfabeto como mínimo, sean minúsculas o mayúsculas.
     * 
     * Es fundamental que la clave se convierta en una cadena de texto vacía si es otro tipo de dato
     * para evaluar por expresión regular la consistencia de lo que se espera como clave de un array.
     *
     * @param string $key Clave a ser evaluada
     * @return void
     * 
     * @throws InvalidArgumentException
     */
    private function validate_key(mixed $key): void {

        if (!\is_string($key)) {
            $key = "";
        }

        /** @var string $pattern */
        $pattern = "/^[a-z][a-z-_]*$/i";

        /** @var string $message */
        $message = "Se esperaba un array asociativo";

        /** @var boolean $is_valid */
        $is_valid = \boolval(value: preg_match(pattern: $pattern, subject: trim(string: $key)));

        if (!$is_valid) {
            throw new InvalidArgumentException(message: $message);
        }
    }
}
