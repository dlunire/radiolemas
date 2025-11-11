<?php

declare(strict_types=1);

namespace DLUnire\Controllers\Admin\Files;

use DLUnire\Models\DTO\FastArray;
use DLUnire\Models\DTO\FilenameData;
use DLUnire\Models\Entities\Filename;
use DLUnire\Models\Tables\Filenames;
use DLUnire\Services\Utilities\CSVParser;
use DLUnire\Services\Utilities\File;
use DLUnire\Services\Utilities\FileManager;
use Exception;
use Framework\Abstracts\BaseController;

/**
 * Copyright (c) 2025 David E Luna M
 * Todos los derechos reservados. Uso restringido bajo licencia comercial.
 *
 * Este controlador gestiona la recepción de archivos enviados desde el cliente
 * en el entorno administrativo. Puede extenderse para validar, almacenar o
 * procesar los archivos recibidos.
 *
 * @version v0.0.1
 * @package DLUnire\Controllers\Admin\Files
 * @author David E Luna M
 * @license Licencia Comercial – Prohibida su distribución no autorizada
 */
final class FileController extends BaseController {
    /**
     * Recibe uno o varios archivos enviados desde el cliente HTTP.
     * 
     * Establece el código de respuesta HTTP 201 (Created) y retorna un arreglo
     * indicando el éxito de la operación. No realiza procesamiento adicional en esta versión.
     *
     * @return array{
     *     status: bool,
     *     success: string
     * }
     */
    public function upload(): array {
        /** @var Filename[] $filenames */
        $filenames = File::upload($this, 'file', 'text/*', '/storage/uploads/file');

        /** @var Filename|null $filename */
        $filename = $filenames[0] ?? null;

        if (!($filename instanceof Filename)) {
            throw new Exception("Se produjo un error al obtener los datos del archivo de la base de datos", 500);
        }

        /** @var array $file */
        $file = Filenames::where('filenames_uuid', $filename->uuid)->first();

        /** @var FilenameData $filedata */
        $filedata = new FilenameData($file);

        /** @var CSVParser $csv */
        $csv = new CSVParser();

        /** @var array<int,array<string,string>> */
        $records = $csv->render_to_array($filedata->name);

        $array = new FastArray($records);
        $tests = [];

        foreach ($array as $record) {
            $tests[] = $record;
        }

        /** @var string $name_only */
        $name_only = basename($filedata->name);


        http_response_code(201);
        return [
            "status" => true,
            "success" => "Archivo recibido correctamente",
            "details" => $tests
        ];
    }

    /**
     * Permite recuperar el archivo enviado al servidor
     * 
     * @return array{
     *      status: boolean,
     *      success: string,
     *      token: string
     * }
     */
    public function store(): array {
        /** @var FileManager $filemanager */
        $filemanager = new FileManager();

        /** @var string $mimetype */
        $mimetype = $this->get_string("mimetype");

        /** @var string $token */
        $token = $filemanager->upload($this, 'file', $mimetype);

        /** @var array $files */
        $files = Filenames::where('filenames_token', $token)
            ->order_by('filenames_created_at')->desc()->get();

        /** @var int $quantity */
        $quantity = count($files);

        /** @var string $label */
        $label = $quantity !== 1
            ? "Se han recibido correctamente los archivos"
            : "Archivo recibido correctamente";

        
        http_response_code(201);
        return [
            "status" => true,
            "success" => $label,
            "token" => $token
        ];
    }
}
