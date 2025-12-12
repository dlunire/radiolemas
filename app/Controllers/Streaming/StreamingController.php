<?php

namespace DLUnire\Controllers\Streaming;

use Framework\Abstracts\BaseController;

/**
 * Permite almacenar la configuración del streaming
 * 
 * @package DLUnire\Controllers\Streaming;
 * @version 0.0.1 (release)
 * @author David E Luna M <dlunireframework@gmail.com>
 * @copyright (c) 2025 David E Luna M
 * @license Comercial
 */
final class StreamingController extends BaseController {

    /**
     * Almacena los datos del streaming a petición del usuario
     *
     * @return void
     */
    public function store(): void {
        
        /**
         * Nombre del servidor streaming de la emisora
         * 
         * @var string $name
         */
        $name = $this->get_string("name");

        /**
         * URL del servidor streaming
         * 
         * @var string $url
         */
        $url = $this->get_string("url");

        // Esta es una prueba que estoy realizando con esto.
    }

    /**
     * Devuelve el streaming de la emisora.
     *
     * @return array
     */
    public function index(): array {

        return [];
    }
}

