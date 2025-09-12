<?php

declare(strict_types=1);

namespace DLUnire\Models\DTO;

use IteratorAggregate;

/**
 * Copyright (c) 2025 David E Luna M
 * Licensed under the MIT License. See LICENSE file for details.
 * 
 * @package DLUnire\Models\DTO
 * @version v0.0.1
 * @license MIT
 * @author David E Luna M
 * 
 * @note Esta clase utiliza snake_case para los nombres de métodos y propiedades. Sin embargo, en el contexto de 
 *       IteratorAggregate, se hizo una excepción.
 */
final class FastArray implements IteratorAggregate {
    /**
     * Array crudo que contiene los datos.
     *
     * @version v0.0.2
     * @var array $data
     */
    private array $data;

    /**
     * Longitud del array.
     *
     * @var integer $length
     */
    private int $length;

    /**
     * Constructor que inicializa el array y su longitud.
     *
     * @param array $data
     */
    public function __construct(array $data = []) {
        $this->clear();
        $this->add($data);
    }

    /**
     * Agrega elementos al array
     *
     * @param mixed $value Valor a ser agregado al array.
     * @return void
     */
    public function push(mixed $value): void {
        $this->data[] = $value;
        ++$this->length;
    }

    /**
     * Vacía el array y resetea su longitud.
     *
     * @return void
     */
    public function clear(): void {
        $this->data = [];
        $this->length = 0;
    }

    /**
     * Devuelve el array crudo.
     *
     * @return array<int,mixed> Crudo array de datos.
     */
    public function get(): array {
        return $this->data;
    }

    /**
     * Devuelve la longitud del array.
     *
     * @return integer
     */
    public function length(): int {
        return $this->length;
    }

    /**
     * Agrega un conjunto de datos al array.
     *
     * @param array<mixed> $data Datos a ser agregados al array.
     * @return void
     */
    public function add(array $data): void {
        if (empty($data)) {
            return;
        }
        $this->data = array_merge($this->data, $data);
        $this->length += count($data);
    }

    /**
     * Devuelve un elemento específico del array.
     *
     * @param integer $index Índice del elemento a ser devuelto.
     * @throws \OutOfBoundsException Si el índice está fuera de los límites del array
     * @return mixed
     */
    public function item(int $index): mixed {
        if ($index < 0 || $index >= $this->length) {
            throw new \OutOfBoundsException("Índice fuera de los límites del array", 400);
        }
        return $this->data[$index];
    }

    /**
     * Devuelve el primer elemento del array.
     *
     * @return mixed
     * @throws \OutOfBoundsException Si el array está vacío
     */
    public function first(): mixed {
        if ($this->length === 0) {
            throw new \OutOfBoundsException("El array está vacío", 400);
        }
        return $this->data[0];
    }

    /**
     * Devuelve el último elemento del array.
     *
     * @return mixed
     * @throws \OutOfBoundsException Si el array está vacío
     */
    public function last(): mixed {
        if ($this->length === 0) {
            throw new \OutOfBoundsException("El array está vacío", 400);
        }
        return $this->data[$this->length - 1];
    }

    /**
     * Devuelve y elimina el último elemento del array.
     *
     * @return mixed
     * @throws \OutOfBoundsException Si el array está vacío
     */
    public function pop(): mixed {
        if ($this->length === 0) {
            throw new \OutOfBoundsException("El array está vacío", 400);
        }
        $value = array_pop($this->data);
        $this->length--;
        return $value;
    }

    /**
     * Devuelve y elimina el primer elemento del array.
     *
     * @return mixed
     * @throws \OutOfBoundsException Si el array está vacío
     */
    public function shift(): mixed {
        if ($this->length === 0) {
            throw new \OutOfBoundsException("El array está vacío", 400);
        }
        $value = array_shift($this->data);
        $this->length--;
        return $value;
    }

    /**
     * Devuelve un iterador para recorrer el array.
     *
     * @return \Traversable
     */
    public function get_iterator(): \Traversable {
        return new \ArrayIterator($this->data);
    }

    /**
     * Devuelve un iterador para recorrer el array. Este método es parte de la interfaz IteratorAggregate, por
     * lo que está utilizando `camelCase` en lugar de `snake_case`.
     *
     * @return \Traversable
     */
    public function getIterator(): \Traversable {
        return $this->get_iterator();
    }
}
