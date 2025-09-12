<?php

/**
 * Copyright (c) 2025 David E Luna M
 * Licensed under the MIT License. See LICENSE file for details.
 */

namespace DLUnire\Models\DTO;

use DLCore\Database\DB;

/**
 * Representa la configuración completa de una conexión a base de datos
 * en forma de objeto de transferencia de datos (DTO), basada en variables
 * de entorno estructuradas mediante la clase `DBKey`.
 *
 * Esta clase permite encapsular todas las claves requeridas para establecer
 * una conexión con el motor de base de datos del sistema, y se utiliza
 * generalmente durante el proceso de instalación, configuración dinámica o carga
 * de credenciales desde archivos como `.dlstorage`.
 *
 * Cada propiedad corresponde a una clave validada y normalizada mediante `DBKey`,
 * lo cual garantiza consistencia en los nombres y tipos de valores esperados.
 *
 * @version v0.0.1
 * @package DLUnire\Models\DTO
 * @license MIT
 * @author David E Luna M
 * @copyright 2025 David E Luna M
 *
 * @property-read DBKey $environment         Entorno de ejecución (por ejemplo, `production`, `local`, `testing`, etc.).
 * @property-read DBKey $lifetime            Tiempo de vida de la sesión o token (en segundos).
 * @property-read DBKey $database_name       Nombre de la base de datos.
 * @property-read DBKey $database_user       Usuario de conexión a la base de datos.
 * @property-read DBKey $database_password   Contraseña asociada al usuario de la base de datos.
 * @property-read DBKey $server              Host o dirección del servidor de base de datos.
 * @property-read DBKey $port                Puerto de conexión al servidor.
 * @property-read DBKey $charset             Conjunto de caracteres (charset) utilizado por la conexión.
 * @property-read DBKey $collation           Colación (reglas de ordenamiento y comparación textual).
 * @property-read DBKey $drive               Driver o motor de base de datos (`mysql`, `mariadb`, `sqlite`, `postgresql`, etc.).
 * @property-read DBKey $prefix              Prefijo para las tablas utilizadas por el sistema.
 */
final class DBConection {
    public readonly DBKey $environment;
    public readonly DBKey $lifetime;
    public readonly DBKey $database_name;
    public readonly DBKey $database_user;
    public readonly DBKey $database_password;
    public readonly DBKey $server;
    public readonly DBKey $port;
    public readonly DBKey $charset;
    public readonly DBKey $collation;
    public readonly DBKey $drive;
    public readonly DBKey $prefix;

    /**
     * Inicializa todas las claves de conexión esperadas a partir de un arreglo
     * asociativo, donde cada entrada contiene la definición de un `DBKey`.
     *
     * Las claves deben estar normalizadas bajo los nombres:
     * `environment`, `lifetime`, `database_name`, `database_user`, `database_password`,
     * `server`, `port`, `charset`, `collation`, `drive`, `prefix`.
     *
     * @param array $database Arreglo con las claves de conexión cargadas desde entorno o almacenamiento.
     */
    public function __construct(array $database) {
        $this->environment = new DBKey($database['environment'] ?? ['environment']);
        $this->lifetime = new DBKey($database['lifetime'] ?? ['lifetime']);
        $this->database_name = new DBKey($database['database_name'] ?? ['database_name']);
        $this->database_user = new DBKey($database['database_user'] ?? ['database_user']);
        $this->database_password = new DBKey($database['database_password'] ?? ['database_password']);
        $this->server = new DBKey($database['server'] ?? ['server']);
        $this->port = new DBKey($database['port'] ?? ['port']);
        $this->charset = new DBKey($database['charset'] ?? ['charset']);
        $this->collation = new DBKey($database['collation'] ?? ['collation']);
        $this->drive = new DBKey($database['drive'] ?? ['drive']);
        $this->prefix = new DBKey($database['prefix'] ?? ['prefix']);
    }
}
