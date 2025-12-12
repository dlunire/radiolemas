<?php

use DLRoute\Requests\DLRoute;
use DLUnire\Controllers\Config\HeaderController;
use DLUnire\Controllers\Config\StationController;
use DLUnire\Controllers\DataController;
use DLUnire\Controllers\Streaming\StreamingController;

/**
 * Debe cargar el manifiesto actualmente existente en el servidor. Si el manifiesto
 * no existe, entonces, devolverá un JSON vacío.
 */
DLRoute::get('/api/v1/manifest', [DataController::class, 'manifest']);

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
DLRoute::post('/api/v1/manifest/create', [DataController::class, 'set_manifest']);

/**
 * Esta ruta no requiere ser autenticada.
 * 
 * Se obtiene el nombre y lema de su aplicación Web. Un lema que se encuentra guardado en un archivo binario. Si
 * el lema y nombre no existe, entonces, se visualizarán nombres genéricos en la plataforma.
 */
DLRoute::get('/api/v1/station', [StationController::class, 'index']);

/**
 * Esta ruta requiere ser autenticada.
 * 
 * Esta ruta permite guardar el nombre legal y lema o consigna de la estación de radio
 * en formato binario.
 * 
 * Cada vez que guarde información se sobreescribirá la información previa que haya sido guardada.
 */
DLRoute::post('/api/v1/station', [StationController::class, 'store']);

/**
 * No require autenticación
 * 
 * Lee las cabeceras existentes. Máximo, se permitirán entre 5 a 10 cabeceras aproximadamente
 */
DLRoute::get('/api/v1/headers', [HeaderController::class, 'index']);

/**
 * Requiere convertirse en una ruta autenticada
 * 
 * Permite guardar los datos de la cabecera para ser consultadas más tarde.
 */
DLRoute::post('/api/v1/headers', [HeaderController::class,'store']);

/**
 * Require autenticación.
 * 
 * Permite almacenar la ruta de Streming de la emisora de radio en un archivo binario.
 */
DLRoute::post('/api/v1/streaming/create', [StreamingController::class, 'store']);

/**
 * No requiere autenticación.
 * 
 * Devuelve la ruta previamente almacenada en un formato binario.
 */
DLroute::get('/api/v1/streaming', [StreamingController::class, 'index']);

