<?php

declare(strict_types=1);

namespace DLUnire\Controllers\Frontend;

use DLCore\Core\BaseController;
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
}
