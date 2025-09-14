<?php

declare(strict_types=1);

namespace DLUnire\Services\Utilities;

use DLRoute\Routes\RouteDebugger;
use DLRoute\Server\DLServer;
use Framework\Errors\DLErrors;
use League\Csv\InvalidArgument;

final class Redirect {
    /**
     * Rutas excluidas para la redirección
     * 
     * @var string[] $excludes
     */
    private static array $excludes = [];

    /**
     * Redirecciona a la ruta seleccionada
     * 
     * @param string $uri Ruta hacia donde se redirigirá, por ejemplo, `/ruta/al/servidor`
     * @param int $code [Opcional] Código de redirección. El valor por defecto es `302`.
     * @return void
     */
    public static function route(string $uri, int $code = 302): void {

        if ($code < 300 || $code > 308) {
            DLErrors::redirect_error();
        }

        $uri = RouteDebugger::trim_slash($uri);
        $uri = RouteDebugger::dot_to_slash($uri);
        $uri = RouteDebugger::clear_route($uri);

        /**
         * Ruta HTTP base.
         * 
         * @var string $http_host
         */
        $http_host = DLServer::get_http_host();
        $http_host = rtrim($http_host, "\/");

        /**
         * URL completa
         * 
         * @var string $url
         */
        $url = "{$http_host}/{$uri}";
        $url = RouteDebugger::url_encode($url);

        if (!DLServer::is_get()) {
            return;
        }

        /** @var string $current_route */
        $current_route = DLServer::get_route();

        if ($current_route == "/{$uri}") {
            return;
        }

        foreach (static::$excludes as $route) {
            /** @var string $pattern; */
            $pattern = "/^\\{$route}\b/i";

            /** @var boolean $found */
            $found = boolval(preg_match($pattern, $current_route));
            if ($found) return;
        }

        header("Location: {$url}", true, $code);
        exit;
    }

    /**
     * Establece las rutas que serán excluidas
     * 
     * @param string[] $excludes Rutas excluidas
     */
    public static function set_excludes(array $excludes = []): void {
        foreach ($excludes as $route) {
            static::validate_route($route);
        }

        static::$excludes = $excludes;
    }

    /**
     * Valida si las rutas son válidas.
     * 
     * @param string $route Ruta a validar
     * @return void
     * 
     * @throws InvalidArgument
     */
    private static function validate_route(string $route): void {
        $route = trim($route);
        $route = preg_replace("/^\/+/", '', $route);
        $route = "/{$route}";

        if (empty($route)) {
            throw new InvalidArgument("La ruta no puede estar vacía", 500);
        }

        /** @var string $pattern */
        $pattern = "/^\/(.*)$/";

        /** @var boolean $found */
        $found = boolval(preg_match($pattern, $route));

        if (!$found) {
            throw new InvalidArgument("El formato de la ruta es inválido", 500);
        }
    }
}
