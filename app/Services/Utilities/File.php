<?php

namespace DLUnire\Services\Utilities;

use DLCore\Core\BaseController;
use DLRoute\Requests\Filename as RequestsFilename;
use DLRoute\Server\DLServer;
use DLStorage\Errors\StorageException;
use DLUnire\Models\Entities\Filename;
use DLUnire\Models\Tables\Filenames;

final class File {

    /**
     * Copia al servidor los archivos y devuelve una lista de ellos.
     *
     * Esta función se encarga de procesar archivos provenientes de un formulario HTML.
     * Valida el tipo MIME si es necesario, guarda los archivos en el directorio especificado
     * y retorna un arreglo con la información resultante. Puede manejar almacenamiento
     * en modo privado o público según el parámetro `$private`.
     *
     * @param BaseController $controller Controlador desde donde se ejecuta.
     * @param string $field Campo de formulario a procesar. El valor por defecto es `file`.
     * @param string $mimetype Tipo de archivo aceptado. Por defecto es (todos).
     * @param string $basedir Directorio base donde se guardarán los archivos. Por defecto `'/storage/file'`.
     * @param bool $private Opcional. Indica si el archivo debe estar almacenado en modo privado. Por defecto es `true`.
     * @return array<Filename> Lista de archivos subidos con su información asociada.
     */
    public static function upload(BaseController $controller, string $field = 'file', string $mimetype = '*/*', string $basedir = "/storage/file", bool $private = true): array {
        $controller->set_basedir($basedir);

        /** @var string $token */
        $token = $controller->generate_uuid();

        $_SESSION['token-file'] = $token;

        /** @var array $files */
        $files = $controller->upload_file($field, $mimetype);

        /** @var array $datafiles */
        $datafiles = [];

        /** @var Filename[] $filenames */
        $filenames = [];

        foreach ($files as $file) {
            if (!($file instanceof RequestsFilename))
                continue;

            /** @var string $uuid */
            $uuid = $controller->generate_uuid();

            $datafile = [
                'filenames_uuid' => $uuid,
                'filenames_name' => $file->target_file,
                'filenames_basedir' => $file->relative_path,
                'filenames_token' => $token,
                'filenames_private' => $private ? 1 : 0,
                'filenames_size' => $file->size,
                'filenames_readable_size' => $file->readable_size,
                'filenames_type' => $file->type,
                'filenames_format' => $file->file_format,
                'filenames_timezone' => Filenames::get_timezone()
            ];

            // self::escape_file($file->target_file, $file->type);

            $datafiles[] = $datafile;
            $filenames[] = new Filename($datafile);
        }

        if (\count($datafiles) < 1) {
            throw new StorageException("Tipo MIME inesperado: se esperaba «{$mimetype}».", 400);
        }

        // throw new Error(DLOutput::get_json($filenames, true), 200);
        Filenames::create($datafiles);

        return $filenames;
    }

    /**
     * Escapa el contenido del archivo enviadoal servidor.
     *
     * @param string $target_file Archivo de destino
     * @param string $type Tipo de archivo
     * @return void
     */
    public static function escape_file(string $target_file, string $type): void {

        /** @var string $root */
        $root = DLServer::get_document_root();

        /** @var string $separator */
        $separator = DIRECTORY_SEPARATOR;

        /** @var string $filename */
        $filename = "{$root}{$separator}{$target_file}";

        if (!file_exists($filename))
            return;
        if (!self::sensitive_file($type))
            return;

        /** @var string $content */
        $content = file_get_contents($filename);
        $content = htmlentities($content);

        file_put_contents($filename, $content);
    }

    /**
     * Evalúa si el archivo es sensible
     *
     * @param string $type Tipo a analizar
     * @return boolean
     */
    public static function sensitive_file(string $type): bool {
        $type = trim($type);

        /** @var string $pattern */
        $pattern = '/^(.*?)\/+(.*?)(php|phar|html?)(.*?)$/i';

        return boolval(preg_match($pattern, $type));
    }
}