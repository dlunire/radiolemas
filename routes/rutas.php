<?php

use DLRoute\Requests\DLRoute;

DLRoute::get('/ciencia/{id}', function(object $params) {
    return [
        "status" => true,
        "content" => "Contenido de prueba",
        "id" => $params->id
    ];
})->filter_by_type([
    "id" => "float"
]);