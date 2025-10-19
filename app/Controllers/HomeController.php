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

    /**
     * Carga la página En Vivo (/online)
     * 
     * @return string
     */
    public function online(): string {
        return $this->get_frontend_content("En Vivo", "Escuche su noticia en vivo");
    }
    
    /**
     * Carga la página Noticias (/news)
     * 
     * @return string
     */
    public function news(): string {
        return $this->get_frontend_content("Noticias", "Lea las noticias que más le guste");
    }
}