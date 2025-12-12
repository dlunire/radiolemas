<?php

declare(strict_types=1);

namespace DLUnire\Controllers\Config;

use DLUnire\Models\DTO\StationData;
use DLUnire\Services\Utilities\Station;
use Framework\Abstracts\BaseController;

/**
 * Opciones de configura de la estación de radio, donde podrá controlar el
 * nombre de la estación, su lema, e incluso, sus banners o cabeceras
 * animadas.
 * 
 * También podrá visualizar o configurar qué secciones son visibles y cuáles, no.
 * 
 * @package DLUnire\Controllers\Config
 * 
 * @author David E Luna M <dlunireframework@gmail.com>
 * @copyright (c) 2025 - David E Luna M
 * @license Comercial
 */
final class StationController extends BaseController {

    /**
     * Devuelve la configuración actual
     *
     * @return StationData
     */
    public function index(): StationData {

        /** @var Station $station */
        $station = new Station();

        return $station->get_info();
    }

    /**
     * Guarda la información de la estación de radio en un archivo binario.
     * 
     * @return array{status: boolean, success: string}
     */
    public function store(): array {
        /**
         * Instancia del manejador de la estación de Radio
         * 
         * @var Station $station
         */
        $station = new Station();

        $station->save(
            name: $this->get_required("name"),
            motto: $this->get_required("motto")
        );

        http_response_code(201);
        return [
            "status" => true,
            "success" => "Información de la emisora actualizada correctamente"
        ];
    }
}