<?php

/**
 * Genera secuencias hexadecimales aleeatorias para evitar la ejecución de scripts no autorizados.
 * 
 * @version v1.0.0
 * @author David E Luna M <dlunireframework@gmail.com>
 * @copyright 2025 - David E Luna M
 * @license Comercial
 */
final class Key {
    /** @var string $separator */
    private static string $separator = DIRECTORY_SEPARATOR;

    /**
     * Genera bytes aleatorios y los devuelve en formato hexadecimal
     * 
     * @return string
     */
    public static function generate(): string {
        /** @var string $bytes */
        $bytes = random_bytes(100);

        return bin2hex($bytes);
    }

    /**
     * Devuelve el hash correspondiente al contenido JavaScript
     * 
     * @return string
     */
    public static function get_js_hash(): string {
        /** @var string $file */
        $file = self::get_file("script.js");

        /** @var string $hash */
        $hash = hash_file('sha256', $file);
        return $hash;
    }

    /**
     * Devuelve el hash correspondiente alcontenido CSS
     * 
     * @return string
     */
    public static function get_css_hash(): string {
        /** @var string $file */
        $file = self::get_file("style.css");

        /** @var string $hash */
        $hash = hash_file('sha256', $file);
        return $hash;
    }

    /**
     * Devuelve la ruta relativa al archivo
     * 
     * @param string $filename [Opcional] Permite establecer el nombre del archivo a consultar
     * @return string
     * 
     * @throws Exception
     */
    private static function get_file(string $filename) {
        /** @var string $root */
        $root = self::get_document_root();

        /** @var string $file */
        $file = self::get_path("/public/{$filename}");
        $file = "{$root}{$file}";

        /** @var string $namne */
        $name = basename($file);

        if (!file_exists($file)) {
            http_response_code(404);
            throw new Exception("El archivo «{$name}» no existe", 404);
        }
        return $file;
    }

    /**
     * Devuelve una ruta normalizada en función del sistema operativo
     * 
     * @return string
     */
    private static function get_path(string $path): string {
        /** @var string $path */
        $path = preg_replace("/[\\\\\/]+/", DIRECTORY_SEPARATOR, $path);
        $path = trim($path, "\/");
        $path = DIRECTORY_SEPARATOR . $path;

        /** @var string $root */
        $root = self::get_document_root() . DIRECTORY_SEPARATOR . $path;

        return $path;
    }

    /**
     * Devuelve el directorio raíz de la aplicación 
     * 
     * @return string
     */
    private static function get_document_root(): string {
        /** @var string $document_root */
        $document_root = "";

        if (defined('DOCUMENT_ROOT')) {
            return constant('DOCUMENT_ROOT');
        }

        /**
         * Directorio raíz de la aplicación
         * 
         * @var string
         */
        $dir = getcwd();
        $dir = dirname($dir);
        $dir = realpath($dir);

        return trim($dir);
    }

    /**
     * Devuelve el icono de reproducción
     * 
     * @return string
     */
    public static function get_play(): string {
        return '<svg viewBox="-1 0 12 12" aria-label="Reproducir" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <title>play [#1000]</title> <desc>Created with Sketch.</desc> <defs> </defs> <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"> <g id="Dribbble-Light-Preview" transform="translate(-65.000000, -3803.000000)" fill="#000000"> <g id="icons" transform="translate(56.000000, 160.000000)"> <path d="M18.074,3650.7335 L12.308,3654.6315 C10.903,3655.5815 9,3654.5835 9,3652.8985 L9,3645.1015 C9,3643.4155 10.903,3642.4185 12.308,3643.3685 L18.074,3647.2665 C19.306,3648.0995 19.306,3649.9005 18.074,3650.7335" id="play-[#1000]"> </path> </g> </g> </g> </g></svg>';
    }

    /**
     * Devuelve el icono de pausa para el botón pausar.
     * 
     * @return string
     */
    public static function get_pause(): string {
        return '<svg fill="#000000" aria-label="Pausar" viewBox="0 0 32 32" version="1.1" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <title>pause</title> <path d="M5.92 24.096q0 0.832 0.576 1.408t1.44 0.608h4.032q0.832 0 1.44-0.608t0.576-1.408v-16.16q0-0.832-0.576-1.44t-1.44-0.576h-4.032q-0.832 0-1.44 0.576t-0.576 1.44v16.16zM18.016 24.096q0 0.832 0.608 1.408t1.408 0.608h4.032q0.832 0 1.44-0.608t0.576-1.408v-16.16q0-0.832-0.576-1.44t-1.44-0.576h-4.032q-0.832 0-1.408 0.576t-0.608 1.44v16.16z"></path> </g></svg>';
    }
}
