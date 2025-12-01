<?php

declare(strict_types=1);

namespace DLUnire\Errors;

/**
 * Excepción específica para errores de validación de cabeceras.
 *
 * Se lanza cuando un elemento o lista de cabeceras no cumple con los
 * requisitos estructurales o de tipo esperados por el sistema DTO.
 *
 * @package DLUnire\Exceptions
 * @version v0.0.1
 * 
 * @author David E Luna M <dlunireframework@gmail.com>
 * @copyright (c) 2025 David E Luna M
 * @license Comercial
 */
final class HeaderValidationException extends BadRequestException {
    /**
     * Constructor de la excepción de validación de cabeceras.
     *
     * @param string $message Mensaje descriptivo del error.
     * @param int $code Código de estado HTTP (por defecto 400).
     * @param \Throwable|null $previous Excepción previa, si existe.
     */
    public function __construct(
        string $message = 'Error al validar los datos de la cabecera.',
        int $code = 400,
        ?\Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}
