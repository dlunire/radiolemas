<?php

use DLRoute\Requests\DLRoute;
use DLUnire\Auth\Auth;
use DLUnire\TestController;

/** @var Auth $auth */
$auth = Auth::get_instance();

$auth->authenticated(function () {
    # Permite comprobar si el usuario ha sido autenticado para una petición por 
    # medio de una API.
    DLRoute::get('/logged', function () {
    });
});


// Visualizar dirección IP
DLRoute::get('/ip', [TestController::class, 'ip']);