<?php

declare(strict_types=1);

namespace DLUnire\Services\Utilities;

use DLStorage\Storage\SaveData;
use DLUnire\Models\DTO\HeaderData;
use Exception;

/**
 * Permite manipular las cabeceras de la página, tanto para visualizarse en PCs, laptos
 * o tables, como también para smartphones.
 * 
 * @package DLUnire\Services\Utilities
 * 
 * @author David E Luna M <dlunireframework@gmail.com>
 * @copyright (c) 2025 David E Luna M
 * @license Comercial
 */
final class Headers extends SaveData {

    private string $entropy;
    private string $target = "/config/headers";

    /**
     * Carga la llave o frase de entropía al momento de instanciarse esta clase
     */
    public function __construct() {
        $this->entropy = hash('sha256', 'Una frase de almacenamiento');
    }

    /**
     * Almacena los datos de la cabecera en un archivo binario
     *
     * @param array $data Datos a ser almacenado
     * @return void
     */
    public function save(array $data) : void {
        /** @var string|bool $raw_data */
        $raw_data = json_encode($data);

        $this->save_data($this->target, $raw_data, $this->entropy);
    }

    /**
     * Devuelve directamente los datos crudos, sin procesar, directamente del archivo
     * binario almacenados previamente.
     * 
     * Si el archivo no existe, entonces, devolverá un valor nulo
     *
     * @return string|null
     */
    private function get_raw_data(): ?string {
        /** @var string $raw_data */
        $raw_data = "";

        try {
            $raw_data = $this->read_storage_data($this->target, $this->entropy);
        } catch (Exception $error) {
            return null;
        }

        return $raw_data;
    }

    /**
     * Devuelve un array o un valor nulo (`null`)
     *
     * @return array|null
     */
    private function get_data(): ?array {
        /** @var string|null $raw_data Datos crudos sin procesar */
        $raw_data = $this->get_raw_data();

        if (!is_string($raw_data)) {
            return null;
        }

        /** @var array $data */
        $data = json_decode($raw_data, true);

        return $data;
    }

    /**
     * Devuelve información de la cabecera
     *
     * @return HeaderData|null
     */
    public function get_info(): ?HeaderData {
        /** @var array|null $data */
        $data = $this->get_data();

        if (!is_array($data)) {
            return null;
        }

        
        return new HeaderData($data);
    }
}