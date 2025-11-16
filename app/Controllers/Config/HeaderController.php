<?php

declare(strict_types=1);

namespace DLUnire\Controllers\Config;

use DLUnire\Models\DTO\HeaderData;
use DLUnire\Models\DTO\HeaderItem;
use DLUnire\Models\Tables\Filenames;
use DLUnire\Services\Utilities\Headers;
use Framework\Abstracts\BaseController;
use DLUnire\Errors\NotFoundException;
use function is_null;


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
    public function index(): ?HeaderData {
        return (new Headers())->get_info();
    }

    /**
     * Almacena los datos de la cabecera en formato binario
     *
     * @return void
     */
    public function store() {

        /** @var string $uuid Identificador Único Universal (UUIDv4) */
        $uuid = $this->generate_uuid();

        /** @var Headers $headers */
        $headers = new Headers();

        /** @var string $token_pc Token de imagen para PCs, laptos o tables */
        $token_pc = $this->get_uuid('token-pc');

        /** @var string $token_mobile Token de imagen para Smartphones */
        $token_mobile = $this->get_uuid('token-mobile');

        /** @var array $pc_image_data */
        $pc_image_data = $this->get_filedata($token_pc);
        $this->expected($pc_image_data, "No se encontró la imagen de la cabecera para PC. Por favor, suba primero la cabecera antes de continuar");

        /** @var array $mobile_image_data */
        $mobile_image_data = $this->get_filedata($token_mobile);
        $this->expected($mobile_image_data, "No se encontró la imagen de cabecera para dispositivos móbiles. Por favor, súbala antes de continuar");

        $current_item = [
            "uuid" => $uuid,
            "image_pc" => route("/file/public/{$pc_image_data['filenames_uuid']}"),
            "image_mobile" => route("/file/public/{$mobile_image_data['filenames_uuid']}"),
            "title" => $this->get_required("title"),
            "description" => $this->get_input('description'),
            "href" => $this->get_input('href')
        ];

        $data = [
            "headers" => $this->item_to_array($headers)
        ];

        $data['headers'][$uuid] = $current_item;
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
        
        /** @var \DLUnire\Models\DTO\HeaderData $info */
        $info = $header->get_info();

        if ($info === null) {
            return [];
        }
        foreach ($info->headers ?? [] as $key => $item) {
            if (!($item instanceof HeaderItem))
                continue;

            $items[$key] = [
                "uuid" => $key,
                "image_pc" => $item->image_pc,
                "image_mobile" => $item->image_mobile,
                "title" => $item->title,
                "description" => $item->description,
                "href" => $item->href
            ];
        }
        return $items;
    }

    /**
     * Lanza una excepción si la cabecera de la imagen no se encuentra durante la validación.
     *
     * @param array $data Datos a ser validados.
     * @param string $message Mensaje personalizado que permite describir la razón por la que se lanza la excepción.
     * @return void
     * 
     * @throws NotFoundException
     */
    private function expected(array $data, string $message = "Recursos no disponible"): void {

        if (empty($data)) {
            throw new NotFoundException($message, 404);
        }
    }

    /**
     * Devuelve los datos del archivo consultados por medio de su identificador
     *
     * @param string $token_uuid Identificación por token asociado al archivo o grupos de archivos.
     * @return array
     */
    private function get_filedata(string $token_uuid): array {
        return Filenames::where('filenames_token', $token_uuid)->first();
    }
}