<?php

declare(strict_types=1);

namespace DLUnire\Services\Utilities;

use DLCore\Core\Errors\ForbiddenException;
use DLUnire\Models\Entities\Filename;
use Framework\Abstracts\BaseController;
use function in_array;

/**
 * Herramienta de administración de archivos
 * 
 * @package DLUnire\Services\Utilities
 * 
 * @version v0.0.1 (release)
 * @author David E Luna M <dlunireframework@gmail.com>
 * @copyright (c) 2025 David E Luna M
 * @license Comercial
 */
final class FileManager {

    /**
     * Summary of ALLOWED_FORMATS
     * 
     * @var array<int, string>
     */
    public const ALLOWED_FORMATS = [
        // Imágenes
        "image/*",
        "image/png",
        "image/svg",
        "image/jpeg",
        "image/jpg",
        "image/bmp",

        // Documentos
        "application/pdf",
        "application/json",

        // Microsoft Office
        "application/msword",                              // .doc
        "application/vnd.openxmlformats-officedocument.wordprocessingml.document", // .docx
        "application/vnd.ms-excel",                        // .xls
        "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",       // .xlsx
        "application/vnd.ms-powerpoint",                   // .ppt
        "application/vnd.openxmlformats-officedocument.presentationml.presentation", // .pptx

        // Textos y hojas de cálculo abiertos (OpenDocument)
        "application/vnd.oasis.opendocument.text",         // .odt
        "application/vnd.oasis.opendocument.spreadsheet",  // .ods
        "application/vnd.oasis.opendocument.presentation", // .odp
    ];

    /**
     * Permite la subida del archivo con la validación de formato. Si la subida se ejecutó con éxito,
     * devolverá el token del archivo o grupo de archivos.
     * 
     * @param \Framework\Abstracts\BaseController $controller
     * @param string $field
     * @param string $mimetype
     * @return string
     * 
     * @throws \DLCore\Core\Errors\ForbiddenException
     */
    public function upload(BaseController $controller, string $field, string $mimetype): string {
        $this->validate_format($controller, $mimetype);
        File::upload($controller, $field, $mimetype, '/storage/uploads/file');

        return $this->get_token();
    }

    /**
     * Valida si el formato solicitado está permitido
     * 
     * @param string $mimetype Formato seleccionado
     * @return void
     * 
     * @throws ForbiddenException
     */
    public function validate_format(BaseController $controller, string $mimetype): void {
        if (!in_array($mimetype, self::ALLOWED_FORMATS)) {
            throw new ForbiddenException("FileManager: El formato «{$mimetype}» no está permitido");
        }
    }

    /**
     * Devuelve el token de validación del archivo
     * 
     * @return string|null
     */
    public function get_token(): ?string {
        // Esta es una preuba

        /**
         * @var string $token
         */
        $token = $_SESSION['token-file'] ?? null;

        if (!is_string($token)) {
            return null;
        }

        return trim($token);
    }
}