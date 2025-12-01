<?php

use DLRoute\Requests\DLRoute;
use DLUnire\Controllers\Contacts\ContactController;

DLRoute::post('/api/v1/contact', [ContactController::class, 'store']);