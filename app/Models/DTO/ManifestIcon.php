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
    public readonly string $src;
    public readonly string $sizes;
    public readonly string $type;

    /**
     * Datos a ser cargados
     * 
     * @var array{
     *  src: string,
     *  sizes: string,
     *  type: string
     * }
     * 
     * throws InvalidArgumentException
     */
    public function __construct(array $data) {

        /** @var string|null $src */
        $src = $data['src'] ?? null;

        /** @var string|null $sizes */
        $sizes = $data['sizes'] ?? null;

        /** @var string|null $type */
        $type = $data['type'] ?? null;

        if (!is_string($src)) {
            throw new InvalidArgumentException("__construct: Se esperaba una cadena en el campo «src»", 500);
        }

        if (!is_string($sizes)) {
            throw new InvalidArgumentException("__construct: Se esperaba una cadena en el campo «sizes»", 500);
        }

        if (!is_string($type)) {
            throw new InvalidArgumentException("__construct: Se esperaba una cadena en el campo «type»", 500);
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
