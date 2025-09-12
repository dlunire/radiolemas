<?php

declare(strict_types=1);

namespace DLUnire\Models\DTO;

use DLCore\Config\DLVarTypes;
use Exception;

/**
 * Copyright (c) 2025 David E Luna M
 * Todos los derechos reservados.
 *
 * Este archivo forma parte del software comercial protegido del autor.
 * Su uso, copia, modificación o distribución requiere una licencia válida
 * otorgada explícitamente por David E Luna M.
 *
 * No está autorizado su uso sin licencia, ni siquiera con fines académicos
 * o no comerciales. Para más información sobre licencias, visite el repositorio
 * oficial o contacte directamente con el autor.
 *
 * @version v0.0.1
 * @package DLUnire\Models\DTO
 * @license Licencia Comercial – Todos los derechos reservados
 * @author David E Luna M
 * @copyright 2025 David E Luna M
 *
 * @property string      $uuid           Identificador único del archivo (UUID v4).
 * @property string|null $name           Nombre original del archivo.
 * @property string|null $basedir        Directorio base donde se almacena el archivo.
 * @property string      $created_at     Fecha y hora de creación del registro (UTC).
 * @property string      $updated_at     Fecha y hora de la última actualización (UTC).
 * @property string      $timezone       Zona horaria del sistema que registró el archivo.
 * @property string|null $token          Token opcional asociado al archivo (por ejemplo, para descargas temporales).
 * @property bool        $record_status  Estado lógico del registro (1 = activo, 0 = inactivo).
 * @property bool        $private        Indica si el archivo es privado (true) o público (false).
 * @property int         $size           Tamaño en bytes del archivo.
 * @property string      $readable_size  Tamaño legible del archivo (por ejemplo: "2.4 MB").
 * @property string|null $type           Tipo MIME detectado (por ejemplo: "image/jpeg").
 * @property string|null $format         Formato declarado o inferido (por ejemplo: "JPEG", "PDF").
 */
final class FilenameData {
    use DLVarTypes;

    public readonly string $uuid;
    public readonly ?string $name;
    public readonly ?string $basedir;
    public readonly string $created_at;
    public readonly string $updated_at;
    public readonly string $timezone;
    public readonly ?string $token;
    public readonly bool $record_status;
    public readonly bool $private;
    public readonly int $size;
    public readonly string $readable_size;
    public readonly ?string $type;
    public readonly ?string $format;

    public function __construct(array $data) {
        $this->load_data($data);
    }

    /**
     * Carga los datos del registro en las propiedades de `FilenamesData`
     *
     * @param array $data Datos a ser leídos y cargados en `FilenamesData`.
     * @return void
     */
    private function load_data(array $data): void {

        /** @var string $uuid */
        $uuid = strval($data['filenames_uuid'] ??  null);

        if (!$this->is_uuid($uuid)) {
            throw new Exception("El identificador UUIDv4 en el campo «filenames_uuid» tiene un formato inválido", 500);
        }

        $this->uuid = $uuid;

        /** @var string|null $name */
        $name = $data['filenames_name'] ??  null;
        $this->debug_input($name);

        $this->name = $name;

        /** @var string|null $basedir */
        $basedir = $data['filenames_basedir'] ??  null;
        $this->debug_input($basedir);
        $this->basedir = $basedir;

        /** @var string $created_at */
        $created_at = strval($data['filenames_created_at'] ??  null);
        $this->validate_string($created_at, 'created_at');
        $this->created_at = $created_at;

        /** @var string $updated_at */
        $updated_at = strval($data['filenames_updated_at'] ??  null);
        $this->validate_string($updated_at, 'updated_at');
        $this->updated_at = $updated_at;

        /** @var string $timezone */
        $timezone = strval($data['filenames_timezone'] ??  null);
        $this->validate_string($timezone, 'timezone');
        $this->timezone = $timezone;

        /** @var string|null $token */
        $token = $data['filenames_token'] ??  null;
        $this->debug_input($token);
        $this->token = $token;

        /** @var int $record_status */
        $record_status = intval($data['filenames_record_status'] ??  null);
        $this->record_status = $record_status === 1;

        /** @var int $private */
        $private = intval($data['filenames_private'] ??  0);
        $this->private = $private === 1;

        /** @var int $size */
        $size = intval($data['filenames_size'] ??  null);
        $this->size = $size;

        /** @var string|null $readable_size */
        $readable_size = $data['filenames_readable_size'] ??  null;
        $this->debug_input($readable_size, true);
        $this->readable_size = $readable_size;

        /** @var string|null $type */
        $type = $data['filenames_type'] ??  null;
        $this->debug_input($type);
        $this->type = $type;

        /** @var string|null $format */
        $format = $data['filenames_format'] ??  null;
        $this->debug_input($format);
        $this->format = $format;
    }

    /**
     * Valida si la cadena de texto es válida
     *
     * @param string $input Entrada a ser analizada
     * @param string $field. Campo 
     * @param string $message [Opcinal] Permite personalizar el mensaje de error.
     * @return void
     * 
     * @throws Exception
     */
    private function validate_string(string $input, string $field, string $message = "El campo {field} es requerido"): void {
        $input = trim($input);

        /** @var string $pattern */
        $pattern = "/\{field\}/i";

        $message = preg_replace($pattern, trim($field), $message);

        if (empty($input)) {
            throw new Exception($message, 500);
        }
    }

    /**
     * Depura la entrada a un formato nulo o `0 B` si la entrada no es una cadena o está vacía. Si
     * se establece `padding_readable_size` a `true`, entonces, el valor asignado a la entrada será
     * `0 B` en el caso de que esté vacía o nula la cadena o sea un `string` inválido.
     *
     * @param mixed $input Entrada a ser analizada
     * @param bool $padding_readable_size [Opcional] Indica si la entrada tendrá como relleno `0 B` o no.
     * @return void
     */
    private function debug_input(mixed &$input, bool $padding_readable_size = false): void {
        if (is_string($input)) {
            $input = trim($input);
        }

        if (!is_string($input) || empty($input)) {
            $input = $padding_readable_size
                ? '0 B'
                : null;
        }
    }
}