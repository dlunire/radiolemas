<?php

declare(strict_types=1);

namespace DLUnire\Models\Entities;

use DLCore\Database\Model;
use Exception;

final class UserData extends Model {
    protected static string $timezone = '-05:00';
    protected static ?string $table = "SELECT * FROM dl_users WHERE users_uuid = :uuid AND users_records_status = 1 LIMIT 1";

    /** @var string $uuid Identificador Único Universal del Usuario */
    public readonly string $uuid;

    /** @var string $username Nombre de usuario */
    public readonly string $username;

    /** @var string $password Contraseña encriptada del usuario. Utiliza el algoritmo Argon2id */
    public readonly string $password;

    /** @var string $name Nombres del usuario */
    public readonly string $name;

    /** @var string $lastname Apellidos del usuario */
    public readonly string $lastname;

    /** @var string $email Correo electrónico */
    public readonly string $email;

    /** @var string|null $token Token de autenticación */
    public readonly ?string $token;

    /** @var string $created_at Fecha de creación del usuario */
    public readonly string $created_at;

    /** @var string $updated_at Fecha de actualización del usuario */
    public readonly string $updated_at;

    /** @var string|null $address Dirección de habitación del usuario */
    public readonly ?string $address;

    /** @var string $record_status Indica si el usuario está marcado como grabado */
    public readonly bool $record_status;

    /** @var string photo Identificación de la foto del usuario */
    public readonly ?string $photo;

    /** @var string $recovery_code Código de recuperación */
    public readonly ?string $recovery_code;

    /** @var bool $blocked Indica si el usuario ha sido bloqueado por intentos fallidos */
    public readonly bool $blocked;

    /** @var int $attemps Intentos de autenticación del usuario */
    public readonly int $attemps;

    /** @var bool $activate Indica si el usuario se ha activado para su uso */
    public readonly bool $activate;

    /**
     * Código de activación del usuario
     *
     * @var string|null $activation_code
     */
    public readonly ?string $activation_code;

    /** @var string $alias Alias del usuario */
    public readonly string $alias;

    /**
     * Devuelve los datos del usuario en función 
     *
     * @return self
     */
    public function get_data(string $uuid): self {

        /** @var array<string, string|int> $userdata */
        $userdata = self::first([
            ":uuid" => $uuid
        ]);

        if (count($userdata) < 1) {
            throw new Exception("El usuario identificado con el identificador «{$uuid}» no existe", 404);
        }

        $this->uuid = $userdata['users_uuid'];
        $this->username = $userdata['users_username'];
        $this->password = $userdata['users_password'];
        $this->name = $userdata['users_name'];
        $this->lastname = $userdata['users_lastname'];
        $this->email = $userdata['users_email'];
        $this->token = $userdata['token'];
        $this->created_at = $userdata['users_created_at'];
        $this->updated_at = $userdata['users_updated_at'];
        $this->address = $userdata['users_address'];
        $this->record_status = $userdata['users_records_status'] == 1;
        $this->photo = $userdata['users_photo'];
        $this->recovery_code = $userdata['users_recovery_code'];
        $this->blocked = $userdata['users_blocked'] == 1;
        $this->attemps = intval($userdata['users_attempts']);
        $this->activate = intval($userdata['users_activate']) == 1;
        $this->activation_code = strval($userdata['users_code_active']);


        return $this;
    }
}
