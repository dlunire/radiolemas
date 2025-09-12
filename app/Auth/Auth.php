<?php

/**
 * Copyright (c) 2025 David E Luna M
 * Licensed under the MIT License. See LICENSE file for details.
 */

namespace DLUnire\Auth;

use DLRoute\Server\DLServer;
use Framework\Auth\AuthBase;
use DLUnire\Models\Entities\UserData;
use DLUnire\Models\Users;
use DLUnire\Models\Views\TestConection;
use DLUnire\Services\Utilities\Credentials;
use DLUnire\Services\Utilities\Redirect;
use PDOException;

/**
 * Clase encargada de la autenticación de usuarios en el entorno de DLUnire.
 *
 * Esta clase extiende las funcionalidades base definidas en `AuthBase`, permitiendo personalizar o ampliar
 * los mecanismos de autenticación utilizados por el framework. Al estar ubicada en el espacio de nombres 
 * `DLUnire\Auth`, forma parte del sistema de autenticación modular del framework.
 *
 * Puede incluir funciones como validación de credenciales, manejo de sesiones, protección de rutas, etc.
 *
 * @package DLUnire\Auth
 * @version v0.0.1
 * @license Comercial
 * @author David E Luna M
 * @copyright 2025 David E Luna M
 */
class Auth extends AuthBase {

    /**
     * Instancia de clase
     *
     * @var self|null
     */
    private static ?self $instance = null;

    private function __construct() {
    }

    /**
     * Permite rutas autenticadas, caso contrario, redirige al formulario de inicio de sesión.
     *
     * @param callable $callback Función pasada como argumento que será ejecutada para registrar rutas autenticadas
     * @param int $code [Opcional] Código de redirección HTTP
     * @return void
     */
    public function authenticated(callable $callback, int $code = 302): void {
        if (!self::connected_database()) {
            return;
        }

        /** @var Credentials $credentials */
        $credentials = new Credentials();

        if (!$credentials->exists('database')) {
            return;
        }

        /**
         * Indica si el usuario está autenticado.
         * 
         * @var boolean $logged
         */
        $logged = $this->is_logged();

        $this->check_user_table($code);

        if ($logged) {
            $callback();
        }

    }

    /**
     * Indica si el usuario se encuentra autenticado, pero en lugar de redirigir a una ruta
     * envía el código HTTP 401
     *
     * @param callable $callback Función anónima a ejecutar en caso de que esté autenticado
     * @return void
     */
    public function dashboard(callable $callback): void {
        $this->authenticated($callback, 401);
    }

    /**
     * Permite rutas en sistemas no autenticados, caso contrario, redirige al dashboard
     */

    public function not_authenticated(callable $callback): void {
        if (!self::connected_database()) {
            return;
        }

        /**
         * Indicador de autenticación del usuario de la aplicación
         * 
         * @var boolean $logged
         */
        $logged = $this->is_logged();

        if (!$logged) {
            $callback();
        }
    }

    /**
     * Devuelve una instancia de clase
     *
     * @return self
     */
    public static function get_instance(): self {
        if (!(self::$instance instanceof self)) {
            self::$instance = new self;
        }

        return self::$instance;
    }

    /**
     * Devuelve un dato específico del usuario, como por ejemplo, nombres, apellidos, correos, entre otros.
     *
     * @param string $key
     * @return string
     */
    public function get_userdata(string $key): string {

        /**
         * Valor capturado de los datos del usuario
         * 
         * @var string $value
         */
        $value = "";

        /**
         * Datos del usuario
         * 
         * @var array $userdata
         */
        $userdata = $this->get_auth();

        if (array_key_exists($key, $userdata)) {
            $value = $userdata[$key];
        }

        return trim($value);
    }

    /**
     * Devuelve los datos del usuario autenticado
     *
     * @return object
     */
    public static function get_current_user(): object {

        /**
         * Autenticador de usuarios
         * 
         * @var self $auth
         */
        $auth = self::get_instance();

        /**
         * Identificador único universal del usuario
         * 
         * @var string $uuid
         */
        $uuid = $auth->get_userdata('users_uuid');

        return (object) Users::where('users_uuid', $uuid)->first();
    }

    /**
     * Devuelve el identificador actual del usuario
     *
     * @return string
     */
    public static function get_current_user_uuid(): string {

        /**
         * Datos de la sesión del usuario
         * 
         * @var self $auth
         */
        $auth = self::get_instance();

        /**
         * @var string $uuid
         */
        $uuid = $auth->get_userdata('users_uuid');

        return $uuid;
    }

    /**
     * Devuelve los datos del usuario
     *
     * @return UserData
     */
    public static function get_user(): UserData {

        /**
         * Datos de autenticación del usuario
         * 
         * @var object $auth
         */
        $auth = self::get_instance();

        /**
         * Identificador del usuario
         * 
         * @var string $uuid
         */
        $uuid = $auth->get_userdata('users_uuid');

        return new UserData($uuid);
    }

    /**
     * Verifica si la conexión con el motor de base de datos es correcta
     *
     * @return bool
     */
    public static function connected_database(): bool {

        try {
            TestConection::first();
            return true;
        } catch (PDOException $error) {
            return false;
        }
    }

    /**
     * Verifica si existe un usuario administrador en el sistema.
     * Si no existe, redirige a la ruta de creación de usuario.
     * 
     * @param int $code [Opcional] Código de redirección
     * @return void
     */
    private function check(int $code = 302): void {
        /**
         * Cuanta la cantidad de usuarios existentes
         * 
         * @var integer $quantity
         */
        $quantity = Users::count();

        /** @var string $route */
        $route = DLServer::get_route();

        if ($quantity < 1 && $route !== "/create/user") {
            $this->clear_auth();
            Redirect::route('/create/user', $code);
        }
    }

    /**
     * Verifica si la tabla de usuarios existe en la base de datos.
     * Si no existe, significa que no se ha escrito aún la base de datos.
     * 
     * @param int $code [Opcional] Código de redirección
     * @return void
     */
    private function check_user_table(int $code = 302): void {
        try {
            $this->check($code);
        } catch (PDOException $error) {
            $this->clear_auth();
        }
    }
}