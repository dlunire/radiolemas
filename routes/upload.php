<?php

use DLRoute\Requests\DLRoute;
use DLUnire\Controllers\Admin\Files\FileController;

DLRoute::post(uri: '/file/upload', controller: [FileController::class, 'store']);