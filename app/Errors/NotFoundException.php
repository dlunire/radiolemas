<?php

declare(strict_types=1);

namespace DLUnire\Errors;

use Exception;

/**
 * Excepción lanzada cuando un recurso solicitado no se encuentra disponible.
 *
 * @package DLUnire\Exceptions
 * @version v0.0.1
 * 
 * @author David E Luna M <dlunireframework@gmail.com>
 * @copyright (c) 2025 David E Luna M
 * @license MIT
 */
final class NotFoundException extends Exception {
    /**
     * Constructor de la excepción NotFoundException.
     *
     * @param string $message Mensaje descriptivo de la excepción. Por defecto 'No encontrado.'
     * @param int $code Código de estado HTTP asociado a la excepción. Por defecto 404.
     * @param \Throwable|null $previous Excepción previa para encadenamiento, si existe.
     */
    public function __construct(
        string $message = 'No encontrado.',
        int $code = 404,
        ?\Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}
