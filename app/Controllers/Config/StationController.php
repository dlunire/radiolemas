<?php

declare(strict_types=1);

namespace DLUnire\Controllers\Config;

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
     * @return array
     */
    public function index(): array {

        return [];
    }
}