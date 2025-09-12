<?php

declare(strict_types=1);

namespace DLUnire\Models\Views;

use DLCore\Database\Model;
use DLStorage\Errors\StorageException;
use DLUnire\Models\DTO\FilenameData;


/**
 * Copyright (c) 2025 David E Luna M
 * Licensed under the MIT License. See LICENSE file for details.
 *
 * Vista lógica para la gestión y recuperación de archivos desde la base de datos `dl_filenames`.
 * Permite acceder a archivos públicos o privados, usando su UUIDv4 como identificador.
 * 
 * Este es un proyecto de David E Luna M, DLUnire Framework y Códigos del Futuro (@cdelfuturo).
 *
 * @package DLUnire\Models\Views
 * @version v1.0.0
 * @author David E Luna M
 * @license Propietaria
 *
 * @property-read string $uuid UUIDv4 del archivo
 * @property-read bool $private Indicador de privacidad del archivo
 * @property-read string $type Tipo MIME del archivo
 * @property-read int $bytes Tamaño del archivo en bytes
 * @property-read string $format Descripción técnica del formato del archivo
 * @property-read string $url URL directa de acceso al archivo
 * @property-read string $preview URL de vista previa
 * @property-read string $token Token de acceso (para archivos privados)
 */
final class FilenameView extends Model {
    protected static ?string $table = "SELECT * FROM dl_filenames WHERE filenames_private = :private";

    /**
     * Devuelve el archivo seleccionado por su Identificador Único Universal (UUIDv4).
     *
     * Este método permite recuperar un archivo previamente cargado en el sistema,
     * ya sea desde el almacenamiento público o privado, dependiendo del valor del parámetro `$private`.
     * Si el archivo no existe, lanza una excepción del tipo `StorageException`.
     *
     * @param string $uuid Identificador UUIDv4 del archivo a recuperar.
     * @param boolean $private Opcional. Indica si se debe buscar en almacenamiento privado (`true`) o público (`false`). Por defecto es `true`.
     * @return FilenameData Objeto que representa el archivo encontrado.
     *
     * @throws StorageException Si no se encuentra ningún archivo asociado al UUID dado.
     */
    public static function get_file(string $uuid, bool $private = true): FilenameData {
        /** @var array $datafile */
        $datafile = self::where('filenames_uuid', $uuid)->first([
            ":private" => $private ? 1 : 0
        ]);

        if (count($datafile) < 1) {
            throw new StorageException("El archivo identificado por «{$uuid}» no existe", 404);
        }

        return new FilenameData($datafile);
    }
}