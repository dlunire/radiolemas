<?php

declare(strict_types=1);

namespace DLUnire\Controllers;

use DLUnire\Services\Utilities\Manifest;
use Framework\Abstracts\BaseController;

/**
 * Configura la aplicación web progresiva (Progresive Web Application)
 * 
 * @package DLUnire\Controllers
 * @version v0.0.1
 * 
 * @author David E Luna M <dlunireframework@gmail.com>
 * @copyright 2025 - David E Luna M.
 * @license Comercial
 */
final class DataController extends BaseController {

    /**
     * Carga el manifest de la aplicación
     * 
     * @return array<string, string|array<int, array<string,string>>
     */
    public function manifest(): array {
        return (new Manifest())->get();
    }

    /**
     * Guarda los datos de la aplicación
     * 
     * @return array
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

        $config = [
            'name' => $name,
            'short_name' => $short_name,
            'start_url' => "",
            'display' => $display,
            'background_color' => $background,
            'theme_color' => $theme,
            'orientation' => $orientation,
            'icons' => [],
        ];

        $manifest->save($config);

        http_response_code(201);
        return  [
            "status" => true,
            "success" => "Aplicación Web Progresiva (PWA) configurada correctamente"
        ];
    }
}
