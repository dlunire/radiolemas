<?php 

declare(strict_types=1);

namespace DLUnire\Services\Utilities;

use DLCore\Core\Errors\ForbiddenException;

/**
 * Permite validar qué archivos están permitidos y cuáles, no
 */
final class FileManager {
    public const ALLOWED_FORMATS = [
        "image/*",
        "image/png",
        "image/svg",
        "image/jpeg",
        "image/jpg",
        "application/pdf",
        "application/json",
        ""
    ];

    /**
     * Valida si el formato solicitado está permitido
     * 
     * @param string $mimetype Formato seleccionado
     * @return void
     * 
     * @throws ForbiddenException
     */
    public function validate_format(string $mimetype): void {

        if (!in_array($mimetype, self::ALLOWED_FORMATS)) {
            throw new ForbiddenException("FileManager: El formato «{$mimetype}» no está permitido");
        }
    }


}