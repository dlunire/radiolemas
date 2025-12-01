<?php

namespace DLUnire\Errors;

/**
 * Copyright (c) 2025 David E Luna M
 * Licensed under the MIT License. See LICENSE file for details.
 */

use Exception;

/**
 * BadRequestException
 * 
 * Se puede lanzar cuando los datos de la petición no cumplen con los requisitos
 * esperados.
 * 
 * @version  v0.0.1 (release)
 * @package  App\Exceptions
 * @license  MIT
 * @author   David E Luna M
 * @copyright  Copyright (c) 2025 David E Luna M
 */
class BadRequestException extends Exception {
    /**
     * Código HTTP asociado a la excepción.
     *
     * @var int
     */
    protected int $http_code = 400;

    /**
     * Constructor de la excepción.
     *
     * @param string $message Mensaje de error personalizado.
     * @param int $code Código de error interno (opcional).
     * @param Exception|null $previous Excepción previa (opcional).
     */
    public function __construct(string $message = "Bad Request", int $code = 0, ?Exception $previous = null) {
        parent::__construct($message, $code, $previous);
    }

    /**
     * Obtiene el código HTTP de la excepción.
     *
     * @return int
     */
    public function get_http_code(): int {
        return $this->http_code;
    }
}
