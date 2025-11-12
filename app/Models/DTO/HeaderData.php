<?php

declare(strict_types=1);

namespace DLUnire\Models\DTO;

use DLUnire\Exceptions\HeaderValidationException;

/**
 * Contienen los datos globales de la cabecera
 * 
 * @package DLUnire\Models\DTO
 * 
 * @author David E Luna M <dlunireframework@gmail.com>
 * @copyright (c) 2025 David E Luna M
 * @license Comercial
 */
final class HeaderData {
    /**
     * Lista de cabeceras
     *
     * @var array<int, HeaderItem>
     */
    public readonly array $headers;

    /**
     * Datos sin procesar a ser analizado
     *
     * @var array $data
     */
    private array $data;
    public function __construct(array $data) {
        $this->data = $data;
        $this->process_headers();
    }

    /**
     * Procesa y valida la cabecera
     *
     * @return void
     * 
     * @throws HeaderValidationException
     */
    private function process_headers(): void {

        /** @var HeaderItem[] $headers */
        $headers = [];

        foreach ($this->data as $item) {
            if (!is_array($item)) {
                throw new HeaderValidationException();
            }

            $headers[] = new HeaderItem($item);
        }

        $this->headers = $headers;
    }
}
