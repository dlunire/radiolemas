<?php

use DLRoute\Requests\DLRoute;
use DLUnire\Controllers\Frontend\FrontendController;

DLRoute::get('/js', [FrontendController::class, 'js'], [], "text/ecmascript");
DLRoute::get('/style', [FrontendController::class, 'css'], [], "text/css");
DLRoute::get('/favicon', [FrontendController::class, 'favicon'], [], "image/svg+xml");
