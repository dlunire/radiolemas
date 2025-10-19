<?php

declare(strict_types=1);

namespace DLUnire\Controllers;

use DLCore\Core\Errors\ForbiddenException;
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

    /**
     * Se realiza una prueba con el marco flotante
     * 
     * @return string
     */
    public function iframe(): string {
        if (!$this->is_iframe()) {
            throw new ForbiddenException("Acceso denegado");
        }
        return $this->get_frontend_content("Test", "Una prueba del marco flotante");
    }

    /**
     * Devuelve información de la cabecera
     * 
     * @param string $key Clave de búsqueda
     * @return string|null
     */
    private function get_value_key(string $key): ?string {
        return $_SERVER[$key] ?? null;
    }

    /**
     * Comprueba si se visualiza desde un marco flotante
     * 
     * @return bool
     */
    private function is_iframe(): bool {
        return boolval($this->get_value_key('HTTP_SEC_FETCH_DEST')) && $this->get_value_key('HTTP_SEC_FETCH_DEST') == "iframe";
    }
}
