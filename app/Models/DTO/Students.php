<?php

declare(strict_types=1);

namespace DLUnire\Models\DTO;

use DLCore\Config\DLValues;

/**
 * Objeto de transferencia de datos (DTO) para representar a un estudiante.
 * 
 * @package DLUnire\Models\DTO
 * @version v0.0.1
 * @license Comercial
 * @author David E Luna M
 * 
 * @property-read string $uuid Identificador único del estudiante.
 * @property-read string $name Nombre del estudiante.
 * @property-read string $lastname Apellido del estudiante.
 * @property-read int $document_number Número de documento del estudiante.
 * @property-read string $document_type Tipo de documento del estudiante.
 * @property-read bool $active Indica si el estudiante está activo.
 */
final class Students {
    use DLValues;

    /**
     * Identificador único del estudiante.
     *
     * @var string $uuid
     */
    public readonly string $uuid;

    /**
     * Nombre del estudiante.
     *
     * @var string $name
     */
    public readonly string $name;

    /**
     * Apellido del estudiante.
     *
     * @var string $lastname
     */
    public readonly string $lastname;

    /**
     * Número de documento del estudiante.
     *
     * @var int $document_number
     */
    public readonly int $document_number;

    /**
     * Tipo de documento del estudiante.
     *
     * @var string $document_type
     */
    public readonly string $document_type;

    /**
     * Indica si el estudiante está activo.
     *
     * @var boolean $active
     */
    public readonly bool $active;

    public function __construct(array $data) {
        /** @var string $uuid */
        $uuid = $data['students_uuid'] ?? '';

        if ($this->is_uuid($uuid)) {
            throw new \InvalidArgumentException("El UUID del estudiante no puede estar vacío.");
        }

        /** @var string $name */
        $name = $data['students_name'] ?? '';

        if (empty($name)) {
            throw new \InvalidArgumentException("El nombre del estudiante no puede estar vacío.");
        }

        /** @var string $lastname */
        $lastname = $data['students_lastname'] ?? '';

        if (empty($lastname)) {
            throw new \InvalidArgumentException("El apellido del estudiante no puede estar vacío.");
        }

        /** @var int $document_number */
        $document_number = (int)($data['students_document_number'] ?? 0);

        if ($document_number <= 0) {
            throw new \InvalidArgumentException("El número de documento del estudiante debe ser un número positivo.");
        }

        /** @var string $document_type */
        $document_type = $data['students_document_type'] ?? '';

        if (empty($document_type)) {
            throw new \InvalidArgumentException("El tipo de documento del estudiante no puede estar vacío.");
        }

        /** @var bool $active */
        $active = (bool)($data['active'] ?? false);

        $this->uuid = $uuid;
        $this->name = $name;
        $this->lastname = $lastname;
        $this->document_number = $document_number;
        $this->document_type = $document_type;
        $this->active = $active;
    }
}
