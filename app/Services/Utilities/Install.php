<?php

declare(strict_types=1);

namespace DLUnire\Services\Utilities;

use DLCore\Core\BaseController;

final class Install extends BaseController {

    /**
     * Carga la plantilla de instalación de usuarios
     *
     * @return string
     */
    public function index(): string|array {
        return view('install.install');
    }
}
