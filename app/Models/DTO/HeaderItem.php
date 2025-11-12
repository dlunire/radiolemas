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
    }
}