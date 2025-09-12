<?php

declare(strict_types=1);

namespace DLUnire\Controllers\Install;

use DLUnire\Models\DTO\Frontend;
use DLUnire\Models\Users;
use Exception;
use Framework\Abstracts\BaseController;

/**
 * Copyright (c) 2025 David E Luna M
 * Licensed under the Comercial. See LICENSE file for details.
 *
 * Controlador responsable de gestionar el formulario y la creación del usuario
 * administrador del sistema durante el proceso de instalación inicial.
 *
 * @package DLUnire\Controllers\Install
 * @author David E Luna M <dlunire@protonmail.com>
 * @copyright 2025 David E Luna M
 * @license Comercial
 * @version v0.0.1
 */
final class UserController extends BaseController {

    /**
     * Muestra el formulario de creación de usuario administrador.
     *
     * @return string HTML renderizado del formulario.
     */
    public function user_form(): string {
        $frontend = new Frontend();
        $frontend->set_title('Crear usuario del sistema');
        $frontend->set_description("Llene el formulario para crear su usuario");
        $frontend->set_csrf($this->get_csrf());
        $frontend->set_token($this->get_random_token());

        return $this->get_frontend($frontend);
    }

    /**
     * Procesa y almacena los datos del usuario administrador.
     *
     * @return array{
     *     status: bool,
     *     message: string
     * }
     */
    public function store(): array {
        /** @var string $name */
        $name = $this->get_required('user-name');

        /** @var string $lastname */
        $lastname = $this->get_required('user-lastname');

        /** @var string $email */
        $email = $this->get_email('user-email');

        /** @var string $username */
        $username = $this->get_required('user-username');

        /** @var string $password */
        $password = $this->get_password('user-password');

        /** @var int $quantity */
        $quantity = Users::count();

        if ($quantity > 0) {
            throw new Exception("No puedes utilizar este formulario para crear un usuario, porque el usuario del sistema ya existe en la base de datos. ", 403);
        }

        /** @var boolean $created */
        $created = Users::create([
            "users_uuid" => $this->generate_uuid(),
            "users_username" => $username,
            "users_password" => $password,
            "users_email" => $email,
            "users_name" => $name,
            "users_lastname" => $lastname,
            "token" => $this->get_random_token()
        ]);

        if (!$created) {
            throw new Exception("Error al crear el usuario", 500);
        }

        http_response_code(201);
        return [
            "status" => true,
            "message" => "Usuario creado correctamente"
        ];
    }
}