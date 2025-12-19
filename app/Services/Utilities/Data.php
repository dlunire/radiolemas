<?php

declare(strict_types=1);

namespace DLUnire\Services\Utilities;

use DLStorage\Storage\SaveData;
use InvalidArgumentException;

/**
 * Interactúa con DLStorage para almacenar datos en formato binario de forma estructurada
 * y genérica.
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
     * La llave de entropía puede ser texto o directamente bytes crudos.
     *
     * @var string|null $entropy
     */
    private ?string $entropy = null;

    /**
     * Devuelve el contenido previamente almacenado partir de un nombre de archivo. No debes colocar
     * extensión, porque el sistema se encarga de agregarlo automáticamente.
     * 
     * **Importante:**
     * Si el archivo no existe o el formato no es el esperado, entonces, el valor devuelto será `NULL`. Esta
     * es una acción deliberada que busca indicar si hay contenido válido o no.
     * 
     * El objetivo de devolver un valor nulo es indicar que no hay nada allí, aunque exista.
     *
     * @param string $filename Nombre de archivo. No debe escribir su extensión.
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
     * Almacena los datos en formato binario. Los datos de entrada son un _array_. Puede ser cualquier
     * tipo de _array_, pero se recomienda que sea asociativo, es decir, de tipo `"clave" => "valor"`.
     * 
     * ### Recomendaciones
     * 
     * Es preferible pasar como argumento en el parámetro `$data` un array asociativo sobre cualquier tipo
     * de array, porque la primera mantiene una estructura mucho más predecible.
     * 
     * Sin embargo, se recomienda pasar el argumento `true` en el parámetro `$eval` para que valide que sea 
     * un array asociativo. La validación es opcional, porque por razones prácticas el desarrollador debe
     * decidir si debe validarlo o no.
     * 
     * ### Formato del array asociativo
     * 
     * Un array asociativo debe cumplicar con las siguientes características:
     * - Debe tener, al menos, un carácter. Significa que debe ser de tipo `string`.
     * - El carácter por el que debe comenzar debe ser una letra del alfabeto.
     * - No distingue minúscula de mayúsculas.
     * - Los caracteres admitidos son:
     *      - Letras del alfabeto ([a-zA-Z])
     *      - Guion (-)
     *      - Subguión (_)
     * 
     * @example location Ejemplo básico
     * 
     * ```
     * <?php
     * $raw_data = [
     *      "clave" => "valor"
     *      "otra_clave" => 30,
     *      "clave-con-guiones" => "Valor de la clave con guiones",
     *      "con_subguion" => "Clave con subguión"
     * ];
     * $data = new Data();
     * $data->set_entropy('Tu llave de entropía aquí. También se permiten datos binarios crudos');
     * $data->save('filename', $raw_data);
     * ```
     * 
     * > **Importante:**
     * > Los datos no deben tener BOM, porque se almacenará un archivo binario sin
     * > carga útil (`payload`). Esto no se da en todos los contextos, sino en contextos específicos, donde
     * > por ejemplo, un parser podría transformar un archivo CSV con BOM a formato _array_.
     * 
     * El método `Data::save` utiliza otros métodos para cumplir con el objetivo descrito en esta documentación.
     * 
     * @param string $filename Nombre de archivo (sin extensión).
     * @param array $data Datos a ser almacenados.
     * @param bool $eval [Opcional] Permite de forma deliverada decidir si se desea evaluar si el argumento en el
     *                   el parámetro `$data` es un _array_ asociativo o no.
     * @return void
     * 
     * @throws InvalidArgumentException
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
     * Establece la llave de entropía para almacenar datos binarios. La llave o frase de entropía
     * está ligada directamente al resultado final de transformación de bytes.
     * 
     * La llave de entropía puede ser texto o directamente bytes crudos. Debe ser la misma para recuperar
     * el contenido previamente almacenado.
     * 
     * La llave de entropía se almacena como un hash de tipo `sha256`.
     *
     * @param string|null $entropy Llave de entropía.
     * @return void
     */
    public function set_entropy(?string $entropy = null): void {
        $this->entropy = hash('sha256', $entropy ?? '');
    }

    /**
     * Devuelve la frase o llave de entropía tal y como se almacenó previamente.
     *
     * @return string|null
     */
    public function get_phrase(): ?string {
        return $this->entropy;
    }

    /**
     * Lee el archivo previamente almacenado. Si éste no existe, simplemente devolverá un `null`. Se
     * busca de forma deliverada convertir una excepción en un valor nulo que será devuelto si el archivo
     * no existe o no es el formato esperado.
     *
     * @param string $filename Archivo a ser leído. No debe colocar extensión.
     * @return string|null
     */
    private function read_file(string $filename): ?string {

        /**
         * Llave de entropía previamente establecida.
         * 
         * @var string|null $entropy
         */
        $entropy = $this->get_phrase();

        /** @var string|null $content Contenido que será devuelto, sea nulo o no. */
        $content = null;

        try {
            $content = $this->read_storage_data($filename, $entropy);
        } catch (\Exception $error) {
            return $content;
        }

        return $content;
    }

    /**
     * Lanza una excepción de tipo `InvalidArgumentException` cuando el array a evaluar no es
     * asociativo. El parámetro `$eval` debe tener el argumento `true` para que se active la validación.
     * 
     * Esto es una acción deliverada con el objeto de permitir al programador evaluar si se trata o no de un 
     * _array_ asociativo. Esta acción deliverada tiene el propósito de ser utilizado por el método
     * `$this->save(...)` de la forma en la que se hizo para facilitar el objetivo planteado.
     * 
     * ### Criterio a tomar en cuenta
     * 
     * Todas sus claves deben ser de tipo `string` para mantener la consistencia de objeto de tipo `clave: valor`
     * para un formato JSON de salida.
     * 
     * La clave del array asociativo debe tener, al menos, un carácter.
     * 
     * @param array $array Array a ser evaluado opcionalmente en función del argumento del segundo parámetro.
     * @param bool $eval Permite decidir de forma delivarada si desea evaluar un _array_ o no. Cuando 
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
