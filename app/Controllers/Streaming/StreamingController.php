<?php

namespace DLUnire\Controllers\Streaming;

use DLUnire\Services\Utilities\ConfigStorage;
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
     * Ruta del contenedor binario del streaming
     *
     * @var string $filename
     */
    private string $filename = '/streaming/station';

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

        /**
         * Identificador Único Universal (UUID)
         * 
         * @var string $uuid
         */
        $uuid = $this->generate_uuid();

        /**
         * Instancia de la configuración.
         * 
         * @var ConfigStorage $config
         */
        $config = new ConfigStorage();

        $config->save(filename: $this->filename, data: [
            "streaming" => [
                "uuid" => $uuid,
                "name" => trim($name),
                "url" => trim($url)
            ]
        ], eval: true);
    }

    /**
     * Devuelve el streaming de la emisora.
     *
     * @return array
     */
    public function index(): ?array {
        /** @var ConfigStorage $config */
        $config = new ConfigStorage();

        return $config->get(filename: $this->filename);
    }
}

