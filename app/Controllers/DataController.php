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
        return [];
    }

    /**
     * Guarda los datos de la aplicación
     * 
     * @return void
     */
    public function set_manifest(): void {
        
        /** @var Manifest() $manifest */
        $manifest = new Manifest();

        $name = $this->get_string("name");
        $short_name = $this->get_string("short-name");
        $display = $this->get_string("display");
        $backgrund = $this->get_string("background");
        $theme = $this->get_string("theme");
        

        $manifest->save($this);
    }
}
