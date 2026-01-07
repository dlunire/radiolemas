<?php

declare(strict_types=1);

use DLRoute\Requests\DLRoute;
use DLStorage\Storage\SaveData;
use DLUnire\Controllers\FileController;
use DLUnire\Controllers\Install\InstallController;
use DLUnire\Controllers\Install\UserController;
use DLUnire\Services\Install\Install;


/** @var Install $install */
$install = new Install();
$install->run();

## INSTALACIÓN DE CREDENCIALES DEL SISTEMA
DLRoute::get('/install/credentials', [InstallController::class, 'credentials']);

## INSTALACIÓN DE LAS CREDENCIALES
DLRoute::post('/install/credentials', [InstallController::class, 'store']);

## VERIFICAR LAS CREDENCIALES
DLRoute::get('/credentials/check', [InstallController::class, 'check_view']);
DLRoute::post('/credentials/check', [InstallController::class, 'check']);

## CREACIÓN DE USUARIOS DEL SISTEMA
DLRoute::get('/create/user', [UserController::class, 'user_form']);
DLRoute::post('/create/user', [UserController::class, 'store']);

## RUTA PRINCIPAL DE INSTALACIÓN
DLRoute::get('/install', [Install::class, 'index']);

# Ruta temporal para probar la subida de archivos | Requiere autenticación
DLRoute::post('/upload/csv', [InstallController::class, 'upload']);

# URL del archivo enviado al servidor. Una ruta que no requiere autenticación
DLRoute::get('/file/public/{uuid}', [FileController::class, 'public_file'])->filter_by_type([
    "uuid" => "uuid"
]);

# URL del archivo enviado al servidor. Una ruta que requiere autenticación
DLRoute::get('/file/private/{uuid}', [FileController::class, 'private_file'])->filter_by_type([
    "uuid" => "uuid"
]);

final class Content extends SaveData {
    private readonly string $entropy;
    private readonly string $encoded;

    /**
     * Instancia la clase con el contenido cifrado junto a la
     * llave de entropía
     *
     * @param string $content Contenido cifrado
     * @param string|null $entropy Llave de entropía
     */
    public function __construct(string $encoded, ?string $entropy) {
        $this->encoded = $encoded;
        $this->entropy = $entropy;
    }

    /**
     * Devuelve el contenido decodificado
     *
     * @return string
     */
    public function get(): string {
        /** @var string $current_content */
        $current_content = $this->get_decode($this->encoded, $this->entropy);
        return hex2bin($current_content);
    }    
}

DLRoute::get('/decodificado', function() {
    $key = "c19134876581185056e93fa8d2d849653e5f03f018d860b58afb5c0c54909c63";
    $content = "0182775018282801827ac01827cc0182791018277401827ff01827dd01827600182783018282101827e3018277001827980182825018280401827c501827520182769018280c01827aa01827620182767018280f01827ee01827720182777018282301827f201827c301827a7018277a0182809018283501827e5018278401827d001827e601827b90182746018282c01828ffff01827d70182756018277a018280701827ed01827ab018278b01827d201827e901827c9018279c018282301827f801827d50182758018274b018281601827d701827af018278f018281501827b20182784018274a018282601827f701827da01827ac0182775018281501827980182796018278b018282b01827fa01827be0182791018277101827b801827cd018279d018277a018281401827df01827b601827e1018286b01827f8018277c0182763018272001827fe01827d1018275e018277a018281f01827e801827b7018278f01827e601827b8";

    $decoded = new Content($content, $key);

    return [$decoded->get()];
});
