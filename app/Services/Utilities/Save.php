<?php

declare(strict_types=1);

namespace DLUnire\Services\Utilities;

use DLStorage\Storage\SaveData;

/**
 * Interactúa con DLStorage para almacenar datos en formato binario de forma estructurada
 * de forma genérica.
 * 
 * @package DLUnire\Services\Utilities
 * 
 * @version v0.0.1 (release)
 * @author David E Luna M <dlunireframework@gmail.com>
 * @copyright (c) 2025 David E Luna M
 * @license Comercial
 */
final class Save extends SaveData {

    /**
     * Llave o frase de entropía que se utilizará para cifrar los datos en formato binario.
     *
     * @var string|null $entropy
     */
    private ?string $entropy = null;

    /**
     * Devuelve los datos del archivo
     *
     * @param string $filename Nombre de archivo.
     * @return string|null
     */
    public function get_file(string $filename): ?string {

        /**
         * Contenido crudo devuelto por el archivo.
         * 
         * @var string $content
         */
        $content = $this->read_file($filename);

        return $content;
    }

    public function save_file(): void {

    }

    /**
     * Establece la llave de entropía para almacenar datos binarios.
     *
     * @param string|null $entropy Llave de entropía.
     * @return void
     */
    public function set_entropy(?string $entropy = null): void {
        $this->entropy = hash('sha256', $entropy ?? '');
    }

    /**
     * Devuelve la frase de entropía
     *
     * @return string|null
     */
    public function get_phrase(): ?string {
        return $this->entropy;
    }

    /**
     * Lee el archivo previamente almacenado.
     *
     * @return string|null
     */
    public function read_file(string $filename): ?string {

        /**
         * Llave de entropía
         * 
         * @var string|null $entropy
         */
        $entropy = $this->get_phrase();

        /** @var string|null $content */
        $content = null;

        try {
            $content = $this->read_storage_data($filename, $entropy);
        }
        catch (\Exception $error) {
            return $content;
        }

        return $content;
    }
}