<?php

namespace DLUnire\Controllers\Install;

use DLUnire\Models\DTO\Frontend;
use DLUnire\Models\Entities\Filename;
use DLUnire\Services\Utilities\Credentials;
use DLUnire\Services\Utilities\File;
use Framework\Abstracts\BaseController;

final class InstallController extends BaseController {
    private string $entropy = "Base de datos";

    public function credentials(): string {
        /** @var Frontend $frontend */
        $frontend = new Frontend();

        $frontend->set_title("Programa de instación");
        $frontend->set_description("Rellene el formulario para conectar con el servidor de base de datos");
        $frontend->set_csrf($this->get_csrf());
        $frontend->set_token($this->get_random_token());
        return $this->get_frontend($frontend);
    }

    /**
     * Almacena las credenciales en un formato binario
     *
     * @return array
     */
    public function store(): array {
        /** @var Credentials $credentials */
        $credentials = new Credentials();
        
        $credentials->save_credentials('database', [
            "environment" => [
                "varname" => "DL_PRODUCTION",
                "value" => $this->get_boolean('environment')
            ],

            "lifetime" => [
                "varname" => "DL_LIFETIME",
                "value" => $this->get_integer('lifetime')
            ],

            "database_name" => [
                "varname" => "DL_DATABASE_NAME",
                "value" => $this->get_required('database-name')
            ],

            "database_user" => [
                "varname" => "DL_DATABASE_USER",
                "value" => $this->get_required('database-user')
            ],

            "database_password" => [
                "varname" => "DL_DATABASE_PASSWORD",
                "value" => $this->get_required('database-password')
            ],

            "server" => [
                "varname" => "DL_DATABASE_HOST",
                "value" => $this->get_required('hostname')
            ],

            "port" => [
                "varname" => "DL_DATABASE_PORT",
                "value" => $this->get_integer('number-port')
            ],

            "charset" => [
                "varname" => "DL_DATABASE_CHARSET",
                "value" => $this->get_string('database-charset')
            ],

            "collation" => [
                "varname" => "DL_DATABASE_COLLATION",
                "value" => $this->get_string('database-collation')
            ],

            "drive" => [
                "varname" => "DL_DATABASE_DRIVE",
                "value" => $this->get_string('database-drive')
            ],

            "prefix" => [
                "varname" => "DL_PREFIX",
                "value" => $this->get_string('database-prefix')
            ],
        ], $this->entropy);

        $credentials->generate_env($this->entropy);
        http_response_code(201);

        return [
            "status" => true,
            "message" => "Instalación de credenciales completada",
            "details" => $this->get_values()
        ];
    }

    /**
     * Permite la subida de archivos
     *
     * @return array
     */
    public function upload(): array {
        /** @var Filename[] $files */
        $files = File::upload(controller: $this, field: 'file', mimetype: "text/csv");

        http_response_code(201);
        return [
            "status" => true,
            "success" => "Archivo subido correctamente",
            "details" => $files
        ];
    }

    public function check_view(): string {
        /** @var Frontend $frontend */
        $frontend = new Frontend();

        $frontend->set_title('Comprobar credenciales');
        $frontend->set_description('Presiona el botón Verificar credenciales para comprobar la conexión con la base de datos. Si los datos ingresados son válidos, continuarás con la creación del usuario administrador. En caso contrario, podrás corregir las credenciales antes de seguir con la instalación.');
        $frontend->set_token($this->get_random_token());
        $frontend->set_csrf($this->get_csrf());

        return $this->get_frontend($frontend);
    }

    /**
     * Verifica que las credenciales de acceso a la base de datos sean correctas.
     *
     * @return array
     */
    public function check(): array {
        $this->check_conection();
        return [
            "status" => true,
            "success" => "Las credenciales ingresadas fueron instaladas con éxito"
        ];
    }
}