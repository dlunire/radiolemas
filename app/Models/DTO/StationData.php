<?php

declare(strict_types=1);

namespace DLUnire\Models\DTO;

use InvalidArgumentException;

/**
 * Información de la estación de radio, donde deja su nombre legal y consigna o lema.
 * 
 * @package DLUnire\Models\DTO;
 * 
 * @author  David E Luna M <dlunireframework@gmail.com>
 * @copyright (c) David E Luna M
 * @license Comercial
 */
final class StationData {
    
    /**
     * Nombre legal de la estación de radio
     *
     * @var string $name
     */
    public readonly string $name;

    /**
     * Lema o consigna de la estación de radio.
     *
     * @var string $motto
     */
    public readonly string $motto;

    /**
     * Carga los datos de la estación
     *
     * @param string $name Nombre legal de la estación de radio.
     * @param string $motto Consigna o lema
     */
    public function __construct(string $name, string $motto) {
        /** @var non-empty-string $name */
        $name = trim($name);

        /** @var non-empty-string $motto */
        $motto = trim($motto);

        if (empty($name)) {
            throw new InvalidArgumentException("El campo «name» es requerido", 400);
        }

        if (strlen($name) < 2) {
            throw new InvalidArgumentException("El nombre de la estación debe contar, al menos, con 2 caracteres", 400);
        }

        $this->name = $name;

        if (empty($motto)) {
            throw new InvalidArgumentException("Debe asignar un lema a su estación de radio", 400);
        }

        if (strlen($motto) < 5) {
            throw new InvalidArgumentException("El lema debe contar, al menos, 5 caracters", 400);
        }

        $this->motto = $motto;
    }

    /**
     * Devuelve el nombre legal de la emisora
     *
     * @return string
     */
    public function get_name(): string {
        return $this->name;
    }
    
    /**
     * Devuelve el lema asignado de la emisora
     *
     * @return string
     */
    public function get_motto(): string {
        return $this->motto;
    }
}