<?php

declare(strict_types=1);

namespace DLUnire\Controllers;

use DLUnire\Services\Traits\FrontendTrait;
use Framework\Abstracts\BaseController;

final class HomeController extends BaseController {
    use FrontendTrait;

    /**
     * Carga la Landing Page de la emisora de radio
     * 
     * @return string
     */
    public function index(): string {
        return $this->get_frontend_content("Bienvenido a RadioLemas", "Bienvenidos a Radios Lemas");
    }
}