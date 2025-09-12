<?php

/**
 * Copyright (c) 2025 David E Luna M
 * Licensed under the MIT License. See LICENSE file for details.
 */

declare(strict_types=1);

namespace DLUnire\Services\Utilities;

use DLCore\Config\DLVarTypes;
use DLStorage\Storage\SaveData;
use DLUnire\Models\DTO\DBConection;
use DLUnire\Models\Users;

/**
 * Clase encargada de representar y gestionar credenciales dentro del sistema DLUnire.
 *
 * Esta clase extiende `SaveData`, lo cual le permite almacenar y recuperar información estructurada
 * relacionada con credenciales (por ejemplo, tokens, llaves de acceso, pares usuario/contraseña u otros
 * identificadores seguros). Al heredar de `SaveData`, se beneficia del sistema de persistencia definido
 * en la biblioteca DLStorage.
 *
 * Es una estructura clave dentro de los servicios utilitarios del framework y puede utilizarse para
 * almacenamiento seguro, serialización, encriptación u operaciones relacionadas a identidad de forma modular.
 *
 * @package DLUnire\Services\Utilities
 * @version v0.0.1
 * @license MIT
 * @author David E Luna M
 * @copyright 2025 David E Luna M
 */
final class Credentials extends SaveData {

    use DLVarTypes;

    /**
     * Guarda las credenciales de conexión a base de datos en un archivo local.
     *
     * Convierte el arreglo de configuración en una estructura fuertemente validada
     * mediante el DTO `DBConection`, que agrupa variables del entorno asociadas
     * al sistema de instalación (entorno, nombre de la base de datos, usuario, contraseña, etc.).
     *
     * El archivo puede ser protegido opcionalmente con una frase de entropía, 
     * lo que fortalece la confidencialidad al almacenarlo en formatos como `.dlstorage`.
     *
     * @param string $filename Nombre del archivo donde se guardarán los datos (por ejemplo, "credenciales.dlstorage").
     * @param array $credentials Arreglo asociativo con las claves requeridas por `DBConection`.
     * @param string|null $entropy Frase opcional de entropía para cifrado del archivo.
     * @return void
     */
    public function save_credentials(string $filename, array $credentials, ?string $entropy = NULL): void {
        $filename = "credentials" . DIRECTORY_SEPARATOR . $filename;

        /** @var DBConection $conection */
        $conection = new DBConection($credentials);
        $this->save_data($filename, json_encode($conection), $entropy);
    }


    /**
     * Devuelve el contenido del archivo
     *
     * @param string $filename Nombre de archivo de búsqueda
     * @param string|null $entropy Entropía utilizada previamente
     * @return DBConection
     */
    public function get_credentials(string $filename, ?string $entropy = NULL): DBConection {

        $filename = "credentials" . DIRECTORY_SEPARATOR . $filename;

        /** @var string $content */
        $content = $this->read_storage_data($filename, $entropy);

        /** @var array $data */
        $data = json_decode($content, true);

        return new DBConection($data);
    }

    /**
     * Genera un archivo `.env.type` a partir de las credenciales en `database.dlstorage` y una 
     * llave de entropía.
     *
     * @param string $entropy Llave de entropía con la que se recuperarán las credenciales en `database.dlstorage`.
     * @return void
     */
    public function generate_env(string $entropy): void {
        $conection = $this->get_credentials('database', $entropy);

        /** @var string[] $buffer */
        $buffer = [];

        $buffer[] = $this->get_environment_varname(conection: $conection, property: 'environment', type: 'boolean');
        $buffer[] = $this->get_environment_varname(conection: $conection, property: 'lifetime', type: 'integer');
        $buffer[] = $this->get_environment_varname(conection: $conection, property: 'database_name', type: 'string');
        $buffer[] = $this->get_environment_varname(conection: $conection, property: 'database_user', type: 'string');
        $buffer[] = $this->get_environment_varname(conection: $conection, property: 'database_password', type: 'string');
        $buffer[] = $this->get_environment_varname(conection: $conection, property: 'server', type: 'string');
        $buffer[] = $this->get_environment_varname(conection: $conection, property: 'port', type: 'integer');
        $buffer[] = $this->get_environment_varname(conection: $conection, property: 'charset', type: 'string');
        $buffer[] = $this->get_environment_varname(conection: $conection, property: 'collation', type: 'string');
        $buffer[] = $this->get_environment_varname(conection: $conection, property: 'drive', type: 'string');
        $buffer[] = $this->get_environment_varname(conection: $conection, property: 'prefix', type: 'string');

        /** @var string $content */
        $content = implode("\n", $buffer);

        /** @var string $root */
        $root = $this->get_document_root();

        /** @var string $separator */
        $separator = DIRECTORY_SEPARATOR;

        file_put_contents("{$root}{$separator}.env.type", $content);
    }

    /**
     * Construye una declaración tipada de una variable de entorno a partir de una conexión dada.
     *
     * Este método toma una propiedad de tipo {@see DBKey} dentro del objeto {@see DBConection},
     * y genera una representación en formato tipado como se usa en archivos `.env.type` a partir de `.dlstorage`,
     * aplicando conversión según el tipo de dato especificado.
     *
     * Ejemplo de salida:
     * - DL_DATABSE_NAME: string = "nombre_bd"
     * - DL_DATABASE_PORT: integer = 3306
     * - DL_PRDUCTION: boolean = true
     *
     * @param DBConection $conection Instancia de conexión que contiene las claves de entorno.
     * @param string $property Nombre de la propiedad dentro de la conexión (ej. 'server', 'port').
     * @param string $type Tipo de dato asociado a la variable de entorno. Puede ser: 'string', 'boolean', 'integer'.
     *
     * @return string Representación tipada de la variable de entorno en formato clave: tipo = valor.
     */
    private function get_environment_varname(DBConection $conection, string $property, string $type = "string"): string {
        /** @var string|int|bool $value */
        $value = $conection->{$property}->value;

        /** @var string $varname */
        $varname = $conection->{$property}->varname;

        if ($type === "string") {
            $value = "\"{$value}\"";
        }

        if ($type === "boolean") {
            $value = $value ? "true" : "false";
        }

        if ($type === "integer") {
            $value = intval($value);
        }

        return "{$varname}: {$type} = {$value}";
    }


    /**
     * Verifica si existe el archivo de credenciales
     *
     * @return boolean
     */
    public function exists(string $filename): bool {
        /** @var string $file */
        $file = $this->get_file_path("credentials" . DIRECTORY_SEPARATOR . $filename . ".dlstorage");
        return file_exists($file);
    }
}