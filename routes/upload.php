<?php

use DLRoute\Requests\DLRoute;
use DLUnire\Controllers\Admin\Files\FileController;

/**
 * Permite almacenar en `/storage` el archivo o archivos enviados al servidor.
 * 
 * Enviar el archivo a la ruta:
 * ```bash
 * POST /file/upload
 * ```
 * 
 * > **Nota:** esta ruta está abierta temporalmente, pero será autenticada para que solo
 * > puedan enviar archivos usuarios autenticados. 
 */
DLRoute::post(uri: '/file/upload', controller: [FileController::class, 'store']);

/**
 * Devuelve el token actual del archivo mediante la siguiente ruta:
 * 
 * ```bash
 * GET /file/token
 * ```
 */
DLRoute::get("/file/token", [FileController::class, 'get_current_token']);