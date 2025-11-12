<?php

use DLRoute\Requests\DLRoute;
use DLUnire\Controllers\DataController;

/**
 * Debe cargar el manifiesto actualmente existente en el servidor. Si el manifiesto
 * no existe, entonces, devolverá un JSON vacío.
 */
DLRoute::get('/manifest', [DataController::class, 'manifest']);

/**
 * Esta ruta será autenticada en el futuro.
 * 
 * Observación:
 * Solo se creará el manifiesto y cada creación es la actualización del anterior.
 * 
 * En esta versión no se considerará almacenar cada versión de cada manifiesto con fines 
 * de optimización. No requiere auditoría en este contexto, porque con ello, se busca personalizar
 * cómo se verá tu aplicación en tu teléfono.
 * 
 * Temporalmente, sin autenticar.
 */
DLRoute::post('/manifest/create', [DataController::class, 'set_manifest']);