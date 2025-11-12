<?php

declare(strict_types=1);

namespace DLUnire\Models\DTO;

/**
 * Información de la estación de radio, donde deja su nombre legal y consigna o lema.
 * 
 * @package DLUnire\Models\DTO;
 * 
 * @author  David E Luna M <dlunireframework@gmail.com>
 * @copyright (c) David E Luna M
 * @license Comercial
 */
final class Station {

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
}