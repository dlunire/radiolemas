<?php

namespace DLUnire\Services\Install;

use DLRoute\Routes\RouteDebugger;
use DLRoute\Server\DLServer;

final class Route {
    /**
     * Devuelve la URL completa a partir de la ruta
     *
     * @param string $route Ruta definida por el usuario
     * @return string
     */
    public static function request(string $route, bool $extension = false): string {
        if (!$extension) {
            $route = RouteDebugger::dot_to_slash($route);
        }

        $uri = trim($route);
        $uri = ltrim($uri, "\/");

        /**
         * URL Base de la aplicación
         * 
         * @var string $url
         */
        $url = DLServer::get_base_url();

        $url = rtrim($url, "\/");
        $url = "{$url}/{$uri}";

        return trim($url);
    }
}
