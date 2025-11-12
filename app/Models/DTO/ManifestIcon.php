<?php

declare(strict_types=1);

namespace DLUnire\Models\DTO;

use InvalidArgumentException;
use IteratorAggregate;
use Traversable;

/**
 * Icono del Manifiesto de la aplicación PWA. 
 * 
 * La estructura general es snake_case, pero se tuvo que hacer una excepción con el método
 * `toArray()` para hacer que esta clase también se comporte como un `array`.
 * 
 * @package DLUnire\Models\DTO
 * 
 * @author David E Luna M <dlunireframework@gmail.com>
 * @copyright (c) 2025 - David E Luna M
 * @license Comercial
 */
final class ManifestIcon implements IteratorAggregate {
    /** @var string $src Ruta del archivo de imagen */
    public readonly string $src;

    /** @var string $sizes Tamaño o tamaños de la imagen */
    public readonly string $sizes;

    /** @var string $type Formato de la imagen */
    public readonly string $type;

    /**
     * Procesa y valida los iconos que serán cargados
     * 
     * @param array{src: string, sizes: string, type: string } $icon Icono a ser procesado
     * 
     * throws InvalidArgumentException
     */
    public function __construct(array $icon) {

        /** @var string|null $src */
        $src = $icon['src'] ?? null;

        /** @var string|null $sizes */
        $sizes = $icon['sizes'] ?? null;
        
        /** @var string|null $type */
        $type = $icon['type'] ?? null;
        
        if (!is_string($src)) {
            throw new InvalidArgumentException("__construct: Se esperaba una cadena en el campo «src»", 400);
        }

        if (!is_string($sizes)) {
            throw new InvalidArgumentException("__construct: Se esperaba una cadena en el campo «sizes»", 400);
        }

        if (!is_string($type)) {
            throw new InvalidArgumentException("__construct: Se esperaba una cadena en el campo «type»", 400);
        }

        if ($type !== "image/png") {
            throw new InvalidArgumentException("El formato esperado es «image/png», pero se obtuvo «{$type}»", 400);
        }

        $this->src = $src;
        $this->sizes = $sizes;
        $this->type = $type;
    }

    /**
     * Devuelve un array asociativo con los valores previamente cargados
     * 
     * @return array{
     *      src: string,
     *      sizes: string,
     *      type: string
     * }
     */
    public function to_array(): array {
        return [
            "src" => $this->src,
            "sizes" => $this->sizes,
            "type" => $this->type
        ];
    }

    /**
     * Alias de `to_array()` para para permitir el uso de esta clase como
     * un array.
     * 
     * @return array{
     *      src: string,
     *      sizes: string,
     *      type: string
     * }
     */
    public function toArray(): array {
        return $this->to_array();
    }

    /**
     * Devuelve un iterador
     * 
     * @return Traversable
     */
    public function getIterator(): Traversable {
        yield from $this->toArray();
    }
}
