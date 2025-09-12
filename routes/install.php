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