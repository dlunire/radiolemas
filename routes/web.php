<?php

declare(strict_types=1);

use DLRoute\Requests\DLRoute;
use DLUnire\Controllers\HomeController;

## PÁGINAS - ESTACIÓN DE RADIO

# En Vivo
DLRoute::get('/online', [HomeController::class, 'online']);

# Noticias
DLRoute::get('/news', [HomeController::class, 'news']);

# Test - Iframe
// DLRoute::get('/iframe', [HomeController::class, 'iframe']);

