<?php

declare(strict_types=1);

namespace DLUnire\Services\Traits;

use DLRoute\Requests\DLOutput;
use DLUnire\Models\Views\TestConection;
use PDOException;

/**
 * Copyright (c) 2025 Códigos del Futuro
 * Licensed under the MIT License. See LICENSE file for details.
 *
 * Trait CheckConectionTrait
 *
 * Proporciona una verificación rápida de conectividad con la base de datos.
 * Utiliza el modelo `TestConection` para ejecutar una consulta simple que 
 * determine si la conexión PDO está activa.
 *
 * @package DLUnire\Services\Traits
 * @version v0.0.1
 * @author Códigos del Futuro (cdelfuturo)
 * @license MIT
 * @copyright 2025 Códigos del Futuro
 *
 * @method bool connected_database() Verifica si existe una conexión activa con la base de datos.
 */
trait CheckConectionTrait {
    /**
     * Verifica si la conexión con la base de datos es válida y funcional.
     *
     * Intenta ejecutar una consulta de prueba usando el modelo `TestConection`.
     * Si la operación falla con una excepción PDO, se asume que la conexión no es válida.
     *
     * @return bool `true` si la base de datos responde correctamente, `false` si ocurre una excepción.
     */
    public function connected_database(): bool {
        try {
            TestConection::first();
            return true;
        } catch (PDOException $error) {
            return false;
        }
    }

    /**
     * Verifica la conexión con el servidor de base de datos lanzando una Exceptión si
     * la conexión falla.
     *
     * @return void
     * 
     * @throws PDOException
     */
    public function check_conection(): void {
        try {
            TestConection::first();
        } catch (PDOException $error) {
            http_response_code(401);
            $data = [
                "status" => false,
                "error" => $error->getMessage(),
                "details" => $error
            ];

            echo DLOutput::get_json($data, true);
            exit;
        }
    }
}