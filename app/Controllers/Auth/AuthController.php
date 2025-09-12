<?php

declare(strict_types=1);

namespace DLUnire\Controllers\Auth;

use DLUnire\Auth\Auth;
use DLUnire\Models\Users;
use DLUnire\Models\Views\UserEntity;
use DLUnire\Services\Traits\FrontendTrait;
use Error;
use Framework\Abstracts\BaseController;

final class AuthController extends BaseController {

    use FrontendTrait;

    /**
     * Inicia la sesión de usuario
     *
     * @return array
     */
    public function login(): array {

        /** @var string $username */
        $username = $this->get_required('username');
        UserEntity::validate_user($username);

        /** @var Users $users */
        $users = new Users();

        $logged = $users->capture_credentials();

        if (!$logged) {
            throw new Error("La combinación de usuario y contraseña es incorrecta", 403);
        }

        http_response_code(201);
        return [
            "status" => true,
            "message" => "Autenticado correctamente"
        ];
    }

    /**
     * Cierra la sesión del usuario liberarando los datos de la sesión
     *
     * @return array
     */
    public function logout(): array {
        $auth = Auth::get_instance();
        $auth->clear_auth();
        return [
            "status" => true,
            "success" => "Se ha cerrado la sesión del usuario"
        ];
    }

    /**
     * Muestra el formulario de inicio de sesión
     *
     * @return string
     */
    public function index(): string {
        /** @var int $quantity */
        $quantity = Users::count();

        if ($quantity < 1) {
            redirect("/create/user");
        }

        return $this->get_frontend_content("Inicio de sesión", "Formulario de inicio de sesión");
    }
}