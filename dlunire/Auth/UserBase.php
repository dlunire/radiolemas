<?php

namespace Framework\Auth;

use DLRoute\Server\DLHost;
use DLRoute\Server\DLServer;
use DLCore\Auth\DLAuth;
use DLCore\Auth\DLAuthOptions;
use DLCore\Auth\DLCookie;
use DLCore\Auth\DLUser;
use Error;

abstract class UserBase extends DLUser {

    /**
     * Nombre del campo usuario del formulario
     *
     * @var string|null
     */
    protected static ?string $username_field = 'username';

    /**
     * Nombre del campo de contraseña del formulario
     *
     * @var string|null
     */
    protected static ?string $password_field = 'password';

    /**
     * Columna de usuario de la tabla usuarios
     *
     * @var string|null
     */
    protected static ?string $username_column = 'users_username';

    /**
     * Nombre de la columna de contraseñas de la tabla de usuarios
     *
     * @var string|null
     */
    protected static ?string $password_column = 'users_password';

    /**
     * Nombre de la columna tokens de la tabla de usuarios. Se recomienda usarla para 
     * facilitar el cierre de sesión en múltiples dispositivos.
     *
     * @var string|null
     */
    protected static ?string $token_column = null;

    /**
     * Captura del cliente HTTP las credenciales del usuario
     *
     * @return bool
     * 
     * @throws Error
     */
    public function capture_credentials(): bool {
        /**
         * Autenticación del usuario
         * 
         * @var DLAuth
         */
        $auth = DLAuth::get_instance();

        /**
         * Nombre de usuario
         * 
         * @var string
         */
        $username = $this->get_required(
            self::$username_field ?? 'username'
        );

        if (mb_strlen($username) < 4) {
            throw new Error("El nombre de usuario debe contar, con al menos, 4 caracteres");
        }

        $this->set_username(
            $username
        );

        /**
         * Contraseña captura del formulario del cliente HTTP.
         * 
         * @var string
         */
        $password = $this->get_password_valid(
            self::$password_field ?? 'password'
        );

        $this->set_password(
            $password
        );

        /** @var DLCookie $cookie */
        $cookie = new DLCookie();
        $cookie->set_domain(DLServer::get_hostname());
        $cookie->set_http_only(true);
        $cookie->set_secure(DLHost::is_https());

        $auth_options = new DLAuthOptions();
        $auth_options->set_username_field('users_username');
        $auth_options->set_password_field('users_password');
        $auth_options->set_token_field('token');

        /**
         * Indica si se ha loggeado el usuario
         * 
         * @var boolean $logged
         */
        $logged = $auth->auth($this, $auth_options, $cookie);

        return $logged;
    }
}
