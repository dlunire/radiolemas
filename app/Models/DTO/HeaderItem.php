<?php

declare(strict_types=1);

namespace DLUnire\Models\DTO;

use InvalidArgumentException;

/**
 * Datos de la cabecera procesado en una lista o item.
 * 
 * @package DLuNIRE\Models\DTO
 * 
 * @author David E Luna M <dlunireframework@gmail.com>
 * @copyright (c) 2025 David E Luna M
 * @license Comercial
 */
final class HeaderItem {

    /** @var string $uuid Identificador Único Universal (UUIDv4) */
    public readonly string $uuid;

    /** @var string $image_pc Cabecera para PC, tablet o laptos */
    public readonly string $image_pc;

    /** @var string  $image_mobile Cabecera para dispositivos móviles */
    public readonly string $image_mobile;

    /** @var string $title Título de la imagen de cabecera */
    public readonly string $title;

    /** @var string|null $description [Opcional] Descripción para la imagen de cabecera (ALT) */
    public readonly ?string $description;

    /** @var string|null $href [Opcional] Enlace de la cabecera */
    public readonly ?string $href;

    /**
     * Datos crudos de la cabecera
     *
     * @var array $data
     */
    private readonly array $data;

    /**
     * Carga los datos al momento de ser instanciada la clse
     *
     * @param array $data Datos a ser procesados y cargados.
     */
    public function __construct(array $data) {
        $this->data = $data;
        $this->load_data();
    }

    /**
     * Devuelve los datos crudo de la data
     *
     * @param string $field Campo a ser utilizar para extraer el valor
     * @return string|null
     */
    private function get_value(string $field): ?string {
        return $this->data[$field] ?? null;
    }

    /**
     * Carga y valida los datos
     *
     * @return void
     */
    private function load_data(): void {
        /** @var string|null $image_pc */
        $image_pc = $this->get_value('image_pc');

        /** @var string|null $image_mobile */
        $image_mobile = $this->get_value('image_mobile');

        /** @var string|null $title */
        $title = $this->get_value('title');

        /** @var string|null $description */
        $description = $this->get_value('description');

        /** @var string|null $href */
        $href = $this->get_value('href');

        /** @var string|null $uuid */
        $uuid = $this->get_value('uuid');

        if (!$this->is_uuid($uuid)) {
            throw new InvalidArgumentException("Se esperaba un Identificador Único Universal en el campo «uuid»", 400);
        }

        if (!is_string($image_pc)) {
            throw new InvalidArgumentException("La cabecera para PC, laptos o tables es requerida", 400);
        }

        if (!is_string($image_mobile)) {
            throw new InvalidArgumentException("La cabecera para dispositivos móbiles es requerida", 400);
        }

        if (!is_string($title)) {
            throw new InvalidArgumentException("El título de la imagen es requerido", 400);
        }

        $this->image_pc = $image_pc;
        $this->image_mobile = $image_mobile;
        $this->title = $title;
        $this->description = $description;
        $this->href = $href;
        $this->uuid = $uuid;
    }

    /**
     * Verifica si la entrada es un Identificador Único Universal (UUIDv4)
     *
     * @param mixed $input Entrada a ser analizada.
     * @return boolean
     */
    private function is_uuid(mixed $input): bool {
        if (!is_string($input)) return false;
        $input = trim($input);

        /** @var string $pattern */
        $pattern = "/^[a-f0-9]{8}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{12}$/i";

        return boolval(preg_match($pattern, $input));
    }
}