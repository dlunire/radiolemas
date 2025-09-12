<?php

declare(strict_types=1);

namespace DLUnire\Services\Install;

use DLRoute\Server\DLServer;
use DLStorage\Storage\SaveData;
use DLUnire\Services\Utilities\Redirect;
use Exception;

final class Install extends SaveData {

    /**
     * Inicia el proceso de instalación del sistema
     *
     * @return void
     */
    public function run(): void {
        Redirect::set_excludes([
            "/file",
            "/js",
            "/style",
            "/favicon"
        ]);
        
        $this->get_frontend_path('index.js');
        $this->get_frontend_path('index.css');

        $this->check_credentials();
    }

    /**
     * Devuelve el código fuente de JavaScript.
     *
     * @return string
     */
    public function get_javascript(): string {
        return $this->get_frontend_content('index.js');
    }

    /**
     * Devuevle elc código fuente de la hoja de estilo
     *
     * @return string
     */
    public function get_style(): string {
        return $this->get_frontend_content('index.css');
    }

    /**
     * Devuelve el hash del archivo JavaScript
     *
     * @return string
     */
    public function get_javascript_hash(): string {
        return hash_file('md5', $this->get_frontend_path('index.js'));
    }

    /**
     * Devuelve el hash del archivo de estilos.
     *
     * @return string
     */
    public function get_style_hash(): string {
        return hash('md5', $this->get_frontend_path('index.css'));
    }

    /**
     * Devuelve el contenido crudo del archivo seleccionado.
     *
     * @param string $filename Archivo a ser leído para devolver su contenido
     * @return string
     */
    private function get_frontend_content(string $filename): string {
        /** @var string $file */
        $file = $this->get_frontend_path($filename);
        return file_get_contents($file);
    }

    /**
     * Revisa si las credenciales existen, de lo contrario, redirige al formulario de 
     * creación de credenciales
     *
     * @return void
     */
    private function check_credentials(): void {
        if ($this->file_exists('database')) return;
        $this->redirect('/install/credentials');
    }

    /**
     * Permite identificar si se realiza la petición por medio de un método HTTP POST
     *
     * @return boolean
     */
    private function is_post(): bool {
        return DLServer::is_post();
    }

    /**
     * Verifica si el archivo de credenciales existe. NO se coloca la extención `.dlstorage`, 
     * porque la asigna automáticamente.
     *
     * @param string $filename Archivo a ser verificado
     * @return boolean
     */
    private function file_exists(string $filename): bool {
        /** @var string $file */
        $file = $this->get_file_path("credentials/{$filename}.dlstorage");
        return file_exists($file);
    }

    /**
     * Redirige a la ruta indicada.
     * 
     * @param string $route Ruta elegida para la redirección
     * @param int $code [Opcional] Código de redirección
     * @return void
     */
    private function redirect(string $route, int $code = 302): void {
        Redirect::route($route, $code);
    }

    /**
     * Devuelve la ruta completa del archivo ubicado en el directorio `dist` previa 
     * comprobación de la existencia del archivo.
     *
     * @param string $file Archivo a ser analizado
     * @return string
     * 
     * @throws Exception
     */
    private function get_frontend_path(string $file): string {

        /** @var string $separator */
        $separator = DIRECTORY_SEPARATOR;

        /** @var string $root */
        $root = DLServer::get_document_root();

        /** @var string $filename */
        $filename = "{$root}{$separator}frontend{$separator}dist{$separator}{$file}";

        if (!file_exists($filename)) {
            throw new Exception("Ingrese al directorio`/frontend` y ejecute el comando `npm install` y luego `npm run build` para general el archivo «{$file}»", 404);
        }

        return $filename;
    }
}
