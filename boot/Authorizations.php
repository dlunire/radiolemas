<?php

namespace Boot;

use DLRoute\Server\DLServer;
use DLCore\Config\Environment as Env;
use Framework\Errors\DLErrors;

class Authorizations implements AuthorizationsInterface {

    /**
     * Dominios registrados que serán permitidos
     *
     * @var array $domains
     */
    private static array $domains = [];

    public static function register_domain(array $domains): void {
        static::$domains = $domains;
    }

    public static function init(): void {

        /**
         * Devuelve el dominio de origen que hace la petición
         * 
         * @var string
         */
        $origin = self::get_origin();

        foreach (self::$domains as $domain) {
            if (!is_string($domain)) {
                continue;
            }

            $domain = trim($domain);

            if (empty($domain)) {
                continue;
            }

            $pattern = "/((http:\/{2}|https:\/{2}){$domain}\b)(:[0-9]{3,4})?/i";

            if (preg_match($pattern, $origin)) {
                self::allow_origin($origin);
                break;
            }
        }
    }

    /**
     * Permite autorizar el dominio origen
     *
     * @return void
     */
    private static function allow_origin(string $origin): void {
        # Previene que el navegador intente inferir el tipo MIME (protege contra ataques XSS)
        header('X-Content-Type-Options: nosniff');

        # Previene que la página sea cargada dentro de un iframe en dominios externos (protección clickjacking)
        header('X-Frame-Options: SAMEORIGIN');

        # Activa la protección XSS incorporada del navegador (aunque es obsoleta en navegadores modernos,
        # muchos escáneres la esperan)
        header('X-XSS-Protection: 1; mode=block');

        # Indica a los navegadores que deben usar HTTPS (útil solo si ya estás en HTTPS y sirve para
        # silenciar avisos de escáneres)
        header('Strict-Transport-Security: max-age=31536000; includeSubDomains; preload');

        #  Si quieres controlar el Referer enviado por el navegador (protección complementaria a CSRF)
        header('Referrer-Policy: no-referrer-when-downgrade');

        # Controla cómo se puede acceder a los recursos (más útil para evitar filtraciones de origen cruzado)
        header('Permissions-Policy: geolocation=(), microphone=(), camera=()');

        header("Access-Control-Allow-Origin: {$origin}");
        header("Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS");
        header("Access-Control-Allow-Headers: Content-Type, Authorization");
        header("Access-Control-Allow-Credentials: true");

        if (DLServer::get_method() === "OPTIONS") {
            http_response_code(200);
            exit;
        }

        self::validate_token($origin);
    }

    /**
     * Devuelve el dominio desde donde se hace petición
     *
     * @return string
     */
    private static function get_origin(): string {

        /**
         * Origen HTTP
         * 
         * @var string $origin
         */
        $origin = $_SERVER['HTTP_ORIGIN'] ?? null;

        return $origin ?? '';
    }

    /**
     * Devuelve el token de autorización
     *
     * @return string
     */
    private static function get_authorization_token(): string {
        $token = "";

        if (array_key_exists('HTTP_AUTHORIZATION', $_SERVER)) {
            $token = $_SERVER['HTTP_AUTHORIZATION'];
        }

        return trim($token);
    }


    /**
     * Valida el token de autorización para permitir o denegar el acceso basado en el origen de la solicitud.
     *
     * @param string $origin El origen de la solicitud HTTP.
     * @return void
     */
    private static function validate_token(string $origin): void {
        $origin = trim($origin);
        /**
         * Instancia del objeto Env para acceder a variables de entorno.
         * 
         * @var Env $env
         */
        $env = Env::get_instance();

        /**
         * Token de autorización en formato 'Bearer'.
         * 
         * @var string $token
         */
        $token = $env->get_env_value('DL_TOKEN');
        $token = trim($token);

        if (empty($token)) {
            return;
        }

        if (!empty($origin) && "Bearer {$token}" !== self::get_authorization_token()) {
            DLErrors::message("No tienes autorización para realizar esta petición", 403);
        }
    }
}
