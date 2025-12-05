<?php

declare(strict_types=1);

namespace DLUnire\Controllers;

use DLUnire\Errors\BadRequestException;
use DLUnire\Models\DTO\ManifestIcon;
use DLUnire\Models\Tables\Filenames;
use DLUnire\Services\Traits\Normalize;
use DLUnire\Services\Utilities\FileManager;
use DLUnire\Services\Utilities\Manifest;
use Framework\Abstracts\BaseController;

/**
 * Configura la aplicación web progresiva (Progresive Web Application). Es decir, permite almacenar
 * los datos de la configuración de la misma para facilitar la personalización.
 * 
 * @package DLUnire\Controllers
 * @version v0.0.1
 * 
 * @author David E Luna M <dlunireframework@gmail.com>
 * @copyright 2025 - David E Luna M.
 * @license Comercial
 */
final class DataController extends BaseController {
    use Normalize;

    /**
     * Carga el manifest de la aplicación
     * 
     * @return array<string, string|array<int, array<string,string>>
     */
    public function manifest(): array {
        return new Manifest()->get();
    }

    /**
     * Guarda los datos de la aplicación
     * 
     * @return array
     * 
     * @throws \DLUnire\Errors\BadRequestException
     */
    public function set_manifest(): array {

        /** @var Manifest() $manifest */
        $manifest = new Manifest();

        /** @var string $name */
        $name = $this->get_string("name");

        /** @var string $short_name */
        $short_name = $this->get_string("short-name");

        /** @var string $display */
        $display = $this->get_string("display");

        /** @var string $background */
        $background = $this->get_string("background");

        /** @var string $theme */
        $theme = $this->get_string("theme");

        /** @var string $orientation */
        $orientation = $this->get_string('orientation');

        /** @var FileManager $filemanager */
        $filemanager = new FileManager();

        /** @var string|null $toke_file */
        $token_file = $filemanager->get_token();

        if (!(\is_string($token_file))) {
            throw new BadRequestException("Debe subir primero los iconos en formato PNG para crear el manifiesto de aplicación", 400);
        }

        /** @var array $files */
        $files = Filenames::where('filenames_token', $filemanager->get_token())
            ->order_by('filenames_created_at')->desc()->get();

        /**
         * Imagen de iconos del archivo de manifiesto (manifest).
         * 
         * @var ManifestIcon[] $icons
         */
        $icons = [];

        foreach ($files as $file) {
            if (!\is_array($file))
                continue;


            /** @var ManifestIcon $icon Devuelve ManifestIcon con los datos previamenteee validados */
            $icon = $this->get_icon($file);

            /** Pero esto es lo que se asigna para serializar al transformarse en datos binarios */
            $icons[] = [
                "src" => $icon->src,
                "sizes" => $icon->sizes,
                "type" => $icon->type
            ];
        }

        $config = [
            'name' => $name,
            'short_name' => $short_name,
            'start_url' => "",
            'display' => $display,
            'background_color' => $background,
            'theme_color' => $theme,
            'orientation' => $orientation,
            'icons' => $icons,
        ];

        $manifest->save($config);
        $filemanager->clear_token();

        http_response_code(201);
        return [
            "status" => true,
            "success" => "Aplicación Web Progresiva (PWA) configurada correctamente"
        ];
    }
}