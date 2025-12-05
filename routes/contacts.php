<?php

use DLRoute\Requests\DLRoute;
use DLUnire\Controllers\Contacts\ContactController;

/**
 * Recibe el contacto del formulario por parte del cliente HTTP. Por ahora estará sin 
 * reCAPTCHA, pero lo tendrá en cuanto esté madura el resto de la aplicación.
 */
DLRoute::post('/api/v1/contact', [ContactController::class, 'store']);