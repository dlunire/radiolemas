<?php

/**
 * Copyright (c) 2025 David E Luna M
 * Licensed under the MIT License. See LICENSE file for details.
 */

namespace DLUnire\Models\DTO;

use DLStorage\Errors\StorageException;

/**
 * Clase de transferencia de datos (DTO) que representa una variable de entorno
 * utilizada como parte de las credenciales del sistema, como parámetros de conexión
 * a la base de datos u otras configuraciones sensibles.
 *
 * Esta clase encapsula dos propiedades:
 * - `varname`: Nombre de la variable, que debe respetar el prefijo `DL_` y estar en mayúsculas.
 * - `value`: Valor asignado, que puede ser texto, numérico o booleano, pero siempre convertible a cadena.
 *
 * El objetivo es establecer una representación robusta, validada y consistente para
 * las variables definidas en archivos como `.dlstorage`, `.env` o `.env.type`, y utilizadas
 * por el sistema en su fase de instalación o ejecución.
 *
 * @version v0.0.1
 * @package DLUnire\Models\DTO
 * @license MIT
 * @author David E Luna M
 * @copyright 2025 David E Luna M
 *
 * @property-read string $varname Nombre de la variable de entorno. Debe iniciar con «DL_» y estar en mayúsculas.
 * @property-read string|int|bool $value Valor asociado a la variable, aceptando tipo cadena, número o booleano.
 */
final class DBKey {
    public readonly string $varname;
    public readonly string|int|bool $value;

    /**
     * Inicializa la clave de entorno a partir de un array asociativo con validaciones estrictas
     * sobre el formato del nombre y el tipo del valor.
     *
     * @param array $dbkey Array asociativo con claves 'varname' y 'value'.
     * @throws StorageException Si el nombre no cumple con el formato esperado
     *                          o si el valor no es convertible a texto.
     */
    public function __construct(array $dbkey) {
        /** @var string|null $varname */
        $varname = $dbkey['varname'] ?? null;

        /** @var string|numeric|bool|null $value */
        $value = $dbkey['value'] ?? null;

        if (is_string($value)) {
            $value = trim($value);
        }

        if (!is_string($varname)) {
            throw new StorageException(
                "Se esperaba una cadena de texto válida en la clave «varname» del arreglo recibido en «{$dbkey[0]}».",
                500
            );
        }
        $varname = trim($varname);

        /** @var string $pattern */
        $pattern = "/^DL_[A-Z_]+$/";

        if (!preg_match($pattern, $varname)) {
            throw new StorageException(
                "Nombre de variable de entorno inválido: «{$varname}». Las variables del sistema deben estar en mayúsculas y comenzar con el prefijo «DL_».",
                500
            );
        }

        if (!is_string($value) && !is_numeric($value) && !is_bool($value)) {
            throw new StorageException(
                "El campo «value» es obligatorio y debe ser convertible a texto.",
                500
            );
        }

        $this->varname = $varname;
        $this->value = $value;
    }
}
