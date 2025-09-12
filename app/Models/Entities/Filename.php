<?php

declare(strict_types=1);

namespace DLUnire\Models\Entities;

use DLStorage\Errors\StorageException;
use DLUnire\Services\Install\Route;

final class Filename {

    /**
     * URL del archivo que se construirá sobre la marcha
     *
     * @var string $url
     */
    public readonly string $url;

    /**
     * Vista previa del archivo
     *
     * @var string|null $preview
     */
    public readonly ?string $preview;

    /**
     * Tipo de archivos
     *
     * @var string|null $type
     */
    public readonly ?string $type;

    /**
     * Cantidad total de bytes del archivo
     *
     * @var integer|float $bytes;
     */
    public readonly int|float $bytes;

    /**
     * Formato de archivo
     *
     * @var string|null $format
     */
    public readonly ?string $format;

    /**
     * Tamaño del archivo enviado
     *
     * @var string $size
     */
    public readonly string $size;

    /**
     * Indica si el archivo ha sido marcado como privado para mostrarse
     * solamente en modo de autenticación
     *
     * @var boolean $private
     */
    public readonly bool $private;

    /**
     * Identificador del archivo
     *
     * @var string $uuid
     */
    public readonly string $uuid;

    /**
     * Token que identifica a un grupo de archivos
     *
     * @var string|null $token
     */
    public readonly ?string $token;

    public function __construct(array $datafile) {
        $this->load_file($datafile);
    }

    /**
     * Carga la información del archivo
     *
     * @return void
     */
    public function load_file(array $datafile = []): void {

        /** @var string|null $uuid */
        $uuid = $datafile['filenames_uuid'] ?? null;

        if (!is_string($uuid)) {
            throw new StorageException("El identificador es requerido", 400);
        }

        /** @var string|null $file */
        $file = $datafile['filenames_name'] ?? null;

        if (!is_string($file)) {
            throw new StorageException("El archivo es requerido", 400);
        }

        /** @var string|null $basedir */
        $basedir = $datafile['filenames_basedir'] ?? null;

        if (!is_string($basedir)) {
            throw new StorageException("El directorio base es requerido", 400);
        }

        /** @var string|null $token */
        $token = $datafile['filenames_token'] ?? null;

        if (!is_string($token)) {
            throw new StorageException("El token asociado al archivo es requerido", 400);
        }

        /** @var int $bytes */
        $bytes = $datafile['filenames_size'] ?? 0;

        if (!is_integer($bytes)) {
            throw new StorageException("Los bytes son requeridos", 400);
        }

        /** @var string|null $size */
        $size = $datafile['filenames_readable_size'] ?? null;

        if (!is_string($size)) {
            throw new StorageException("El tamaño es requerido", 400);
        }

        $this->uuid = $datafile['filenames_uuid'];
        $this->token = $datafile['filenames_token'] ?? null;

        /** @var string|null $type */
        $type = $datafile['filenames_type'] ?? null;

        /** @var string|null $format */
        $format = $datafile['filenames_format'] ?? null;

        /** @var bool $private */
        $private = ($datafile['filenames_private'] ?? null) == 1;

        /** @var string $url */
        $url = $private
            ? Route::request("/file/private/{$uuid}")
            : Route::request('/file/public/{$uuid}');

        $this->url = $url;
        $this->preview = "{$url}?preview";
        $this->type = $type;
        $this->bytes = $bytes;
        $this->size = $size;
        $this->format = $format;
        $this->private = $private;
    }
}
