<?php

declare(strict_types=1);

use DLRoute\Requests\DLRoute;
use DLUnire\Auth\Auth;
use DLUnire\Controllers\Admin\Dashboard\DashboardController;
use DLUnire\Controllers\Admin\Files\FileController;
use DLUnire\Controllers\Admin\Settings\SettingsController;
use DLUnire\Controllers\Auth\AuthController;
use DLUnire\Controllers\HomeController;
use DLUnire\Models\Users;
use DLUnire\Services\Utilities\CSVParser;

/** @var Auth $auth */
$auth = Auth::get_instance();

DLRoute::get('/', [HomeController::class, 'index']);

## AUTENTICACIÓN CON RUTAS INEXISTENTES O NO REGISTRADAS PARA FACILITAR REDIRECCIÓN
$auth->authenticated(function () {

    # Panel principal
    DLRoute::get('/dashboard', [DashboardController::class, 'index']);

    ## Certificados
    DLRoute::get('/dashboard/certificate', [DashboardController::class, 'certificate']);

    ## Historial
    DLRoute::get('/dashboard/history', [DashboardController::class, 'history']);

    ## Consultar registros:
    DLRoute::get('/dashboard/register', [DashboardController::class, 'register']);

    ## Zona de de configuración:
    DLRoute::get('/dashboard/settings', [DashboardController::class, 'settings']);

    ## Zona de de configuración:
    DLRoute::get('/dashboard/profile', [DashboardController::class, 'profile']);
});

## RUTAS QUE DEBEN SER REDIRIGIDA O DEBEN APLICAR UN REDIRECT
$auth->authenticated(function () {
    DLRoute::get('/login', function () {
        redirect("/dashboard");
    });
});

## AUTENTICACIÓN CON MENSAJE EXPLÍCITO
$auth->logged(function () {
    ## CERRAR SESIÓN
    DLRoute::delete('/logout', [AuthController::class, 'logout']);

    DLRoute::get('/test', function () {
        return Users::paginate(1, 10);
    });

    ## Devuelve la configuración actual del sistema
    DLRoute::get('/dashboard/current/settings', [SettingsController::class, 'index']);

    ## Actualiza la configuración del sistema:
    DLRoute::post('/dashboard/settings', [SettingsController::class, 'store']);
});
## Certificados al servidor:
DLRoute::post('/dashboard/upload', [FileController::class, 'upload']);

## PROBAR COMPILADOR
DLRoute::get('/compiler', function () {

    /** @var CSVParser */
    $reader = new CSVParser();

    /** @var string $file */
    // $file = "/storage/customers-10000.csv";
    // $file = "/storage/test-customer.csv";
    $file = "/storage/test.csv";

    return $reader->render_to_array($file);
});

## Realizar una prueba con el sistema de rutas
DLRoute::get('/test', function () {
    return "Alguna salida";
});