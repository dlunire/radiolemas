<?php

declare(strict_types=1);

namespace DLUnire\Controllers\Config;

use DLUnire\Models\DTO\HeaderData;
use DLUnire\Models\DTO\HeaderItem;
use DLUnire\Services\Utilities\FileManager;
use DLUnire\Services\Utilities\Headers;
use Framework\Abstracts\BaseController;

/**
 * Controla la creación, lectura y eliminación de cabeceras de la aplicación
 * 
 * @package DLUnire\Controllers\Config
 * 
 * @author David E Luna M <dlunireframework@gmail.com>
 * @copyright (c) 2025 - David E Luna M
 * @license Comercial
 */
final class HeaderController extends BaseController {

    /**
     * Devuelve una lista de cabeceras
     *
     * @return Headers|null
     */
    public function index(): ?Headers {
        return (new Headers())->get_info();
    }

    /**
     * Almacena los datos de la cabecera en formato binario
     *
     * @return void
     */
    public function store() {

        /** @var Headers $headers */
        $headers = new Headers();

        /**
         * Administrador de archivos
         * 
         * @var FileManager $file
         */
        $file = new FileManager();

        $file->upload($this, 'file-pc', "image/*", false);
        $file->upload($this, 'file-mobile', "image/*", false);

        $current_item = [
            "image_pc" => "",
            "image_mobild" => "",
            "title" => $this->get_required("title"),
            "description" => $this->get_input('description'),
            "href" => $this->get_input('href')
        ];

        $data = [
            "headers" => $this->item_to_array($headers)
        ];


        $data['headers'][] = $current_item;
        $headers->save($data);
    }

    /**
     * Convierte cada item en un array. Si no se encuentra un acabecera o items, entonces
     * devolverá un array vacío.
     *
     * @param Headers $header Datos de cabecera
     * @return array{
     *      image_pc: string,
     *      image_mobile: string,
     *      title: string,
     *      description: string|null,
     *      href: string|null
     * }
     */
    private function item_to_array(Headers $header): array {

        if (!($header instanceof Headers)) {
            return [];
        }

        /** @var array $items */
        $items = [];

        foreach ($header->get_info() ?? [] as $item) {
            if (!($item instanceof HeaderItem))
                continue;

            $items[] = [
                "image_pc" => $item->image_pc,
                "image_mobile" => $item->image_mobile,
                "title" => $item->title,
                "description" => $item->description,
                "href" => $item->href
            ];
        }

        return $items;
    }
}