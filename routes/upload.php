<?php

use DLRoute\Requests\DLRoute;
use DLUnire\Controllers\Admin\Files\FileController;

DLRoute::post('/file/upload', [FileController::class, 'store']);