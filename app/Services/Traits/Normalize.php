<?php

namespace DLUnire\Services\Traits;

use DLRoute\Config\FileInfo;
use DLRoute\Server\DLServer;
use DLUnire\Errors\BadRequestException;
use DLUnire\Models\DTO\ManifestIcon;

trait Normalize {

    /**
     * Normaliza las rutas a las rutas del sistema operativo
     *
     * @param string $route Ruta a ser normalizada
     * @return string
     */
    protected function normalize_route(string $route): string {
        return preg_replace("/[\/\\\\]+/", DIRECTORY_SEPARATOR, $route);
    }

    /**
     * Devuelve el icono del manifiesto de la aplicación.
     *
     * @param array $file Datos preliminares de los archivos de la base de datos
     * @return ManifestIcon
     */
    protected function get_icon(array $file): ManifestIcon {

        /** @var string $root */
        $root = DLServer::get_document_root();

        /** @var string $separator */
        $separator = DIRECTORY_SEPARATOR;

        /** @var string $uuid */
        $uuid = \strval($file['filenames_uuid'] ?? '');

        /** @var string $type */
        $type = \strval($file['filenames_type'] ?? '');
        $type = trim($type);

        /** @var string $name */
        $name = \strval($file['filenames_name'] ?? '');
        $name = $this->normalize_route($name);

        if (!\preg_match("/^image\/png$/", $type)) {
            throw new BadRequestException("El formato de imagen no es un PNG válido. Por favor, intente de nuevo enviando archivos PNG");
        }

        /** @var string $filename */
        $filename = "{$root}{$separator}{$name}";

        /** @var object{width: int, height: int } $info */
        $info = FileInfo::get_dimensions($filename);

        /** @var string $sizes */
        $sizes = "{$info->width}x{$info->height}";

        /** @var array $icon */
        $icon = [
            "src" => route("/file/public/{$uuid}"),
            "sizes" => $sizes,
            "type" => $type
        ];

        return new ManifestIcon($icon);
    }
}