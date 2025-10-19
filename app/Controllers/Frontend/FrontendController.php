<?php

declare(strict_types=1);

namespace DLUnire\Controllers\Frontend;

use DLCore\Core\BaseController;
use DLRoute\Server\DLServer;
use DLUnire\Services\Install\Install;

/**
 * Permite cargar el contenido del frontend en una ruta amigable
 */
final class FrontendController extends BaseController {

    /**
     * Devuelve el código fuente de JavaScript
     *
     * @return string
     */
    public function js(): string {

        /** @var Install $install */
        $install = new Install();

        /** @var string $js */
        $js = $install->get_javascript();
        script();
        return $js;
    }

    /**
     * Devuelve el contenido o código fuente de la hoja de estilos
     *
     * @return string
     */
    public function css(): string {

        /** @var Instsall $install */
        $install = new Install();

        /** @var string $style */
        $style = $install->get_style();

        return $style;
    }

    /**
     * Devuelve el favicon de la aplicación
     * 
     * @return string
     */
    public function favicon(): string {
        /** @var string $root */
        $root = DLServer::get_document_root();

        /** @var string $separator */
        $separator = DIRECTORY_SEPARATOR;

        /** @var string $filename */
        $filename = "{$root}{$separator}public{$separator}favicon.svg";

        if (!file_exists($filename)) return "";

        return file_get_contents($filename) ?? '';
    }

    /**
     * Carga el archivo manifest de la Aplicación Web Progresiva
     * 
     * @return array
     */
    public function manifest(): array {

        return [];
    }
}
