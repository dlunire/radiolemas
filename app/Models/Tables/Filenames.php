<?php

declare(strict_types=1);

namespace DLUnire\Models\Tables;

use DLCore\Database\Model;

/**
 * Representa la tabla de archivos donde se consultarán los datos de los archivos
 */
final class Filenames extends Model {
    protected static string $timezone = "-05:00";

    public static function get_timezone(): string {
        return static::$timezone;
    }
}