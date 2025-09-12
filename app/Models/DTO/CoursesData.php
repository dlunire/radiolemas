<?php

declare(strict_types=1);

namespace DLUnire\Models\DTO;

use DLCore\Config\DLVarTypes;
use TypeError;

/**
 * Copyright (c) 2025 David E Luna M
 * Licensed under the MIT License. See LICENSE file for details.
 *
 * Objeto de Transferencia de Datos (DTO) que representa la estructura de salida
 * asociada a un curso. Esta clase está diseñada para desacoplar la lógica de
 * presentación o transporte de la capa de modelo (ORM).
 *
 * @version v0.0.1
 * @package DLUnire\Models\DTO
 * @license MIT
 * @author David E Luna M
 * @copyright Copyright (c) 2025
 */
final class CoursesData {
    use DLVarTypes;

    public readonly string $uuid;
    public readonly string $name;
    public readonly ?string $description;
    public readonly string $created_at;
    public readonly string $updated_at;

    public function __construct(array $data) {
        $this->load_data($data);
    }

    /**
     * Carga y valida los datos
     *
     * @param array $data Datos a ser analizados y validados
     * @return void
     * 
     * @throws TypeErrors
     */
    private function load_data(array $data): void {
        /** @var string | null $uuid */
        $uuid = $data['courses_uuid'] ?? null;

        /** @var string | null $name */
        $name = $data['courses_name'] ?? null;

        /** @var string|null $description */
        $description = $data['courses_description'] ?? null;

        /** @var string|null $created_at */
        $created_at = $data['courses_created_at'] ?? null;

        /** @var string|null $updated_at */
        $updated_at = $data['courses_updated_at'] ?? null;

        if ($this->is_uuid($uuid)) {
            throw new TypeError("Se esperaba un identificador «UUIDv4» válido en el campo «courses_uuid»", 500);
        }

        if (!$this->is_string_valid($name)) {
            throw new TypeError("Se esperaba una cadena válida en el campo «courses_name»", 500);
        }

        if (!$this->is_string_valid($created_at)) {
            throw new TypeError("se esperaba una cadena válida en el campo «courses_created_at»", 500);
        }

        if (!$this->is_string_valid($updated_at)) {
            throw new TypeError("Se esperaba una cadena de texto en «courses_updated_at»", 500);
        }
    }

    /**
     * Valida si la entra es una cadena de texto y no se encuentra vacía.
     *
     * @param mixed $input
     * @return boolean
     */
    private function is_string_valid(mixed $input): bool {
        return is_string($input) && !empty(trim($input));
    }
}