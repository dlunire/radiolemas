<?php

declare(strict_types=1);

namespace DLUnire\Models\Views;

use DLCore\Database\Model;
use DLUnire\Models\Entities\UserData;
use Exception;

final class UserEntity extends Model {
    protected static string $timezone = '-05:00';
    protected static ?string $table = "SELECT * FROM dl_users WHERE users_username = :username AND users_records_status = :record LIMIT 1";

    /**
     * Valida si el usuario existe
     *
     * @param string $username Nombre de usuario a ser analizado
     * @return void
     */
    public static function validate_user(string $username): void {
        $username = trim($username);

        /** @var array<string,string|int|null> $data */
        $data = self::first([
            ":username" => $username,
            ":record" => 1
        ]);

        if (count($data) < 1) {
            throw new Exception("El usuario «{$username}» no existe", 404);
        }
    }

    /**
     * Devuelve los datos del usuario seleccionado por su identificador
     *
     * @param string $uuid Identificador Único Universal del usuario
     * @return UserData
     */
    public static function get_userdata(string $uuid): UserData {
        return (new UserData())->get_data($uuid);
    }
}
