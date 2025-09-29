<?php

declare(strict_types=1);

namespace DLUnire;

use DLRoute\Server\DLServer;
use Framework\Abstracts\BaseController;

/**
 * Este es un controlador de pruebas
 * 
 * @package DLUnire
 * 
 * @version 0.0.1 (release)
 * @author Códigos del Futuro (@cdelfuturo)
 * @license MIT
 */
final class TestController extends BaseController {

    /**
     * Devuelve la dirección IP de un cliente HTTP
     * 
     * @return array<string,string>
     */
    public function ip(): array {

        return [
            "IP" => DLServer::get_ipaddress()
        ];
    }
}