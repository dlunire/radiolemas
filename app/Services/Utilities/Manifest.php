<?php

declare(strict_types=1);

namespace DLUnire\Services\Utilities;

use DLRoute\Requests\DLOutput;
use DLStorage\Storage\SaveData;
use DLUnire\Models\DTO\ManifestData;
use Exception;
use RuntimeException;

final class Manifest extends SaveData {
    /** @var string $target Archivo de destino */
    private string $target = "/config/manifest";

    /**
     * Llave de entropía de cifrado. No requiere seguridad, debido a que no se guardan
     * datos sensibles.
     * 
     * @var string $entropy
     */
    private readonly string $entropy;

    public function __construct() {
        $this->entropy = hash('sha256', "manifiest-filename");
    }

    /**
     * Almacesa los datos de la aplicación en formato binario
     * 
     * @param array $manifest Manifiesto de la aplicación
     * @return boolean
     * 
     * @throws \InvalidArgumentException
     */
    public function save(array $manifest): bool {
        
        /**
         * Datos del manifiesto de la aplicación.
         * 
         * @var ManifestData $manifest_data
         */
        $manifest_data = new ManifestData($manifest);

        /**
         * Manifest de Progresive Web Application
         * 
         * @var array<string, string|array<int, array<string,string>> $manifest
         */
        $manifest = [
            'name' => $manifest_data->name,
            'short_name' => $manifest_data->short_name,
            'start_url' => $manifest_data->start_url,
            'display' => $manifest_data->display,
            'background_color' => $manifest_data->background_color,
            'theme_color' => $manifest_data->theme_color,
            'orientation' => $manifest_data->orientation,
            'icons' => $manifest_data->icons,
        ];

        /** @var string $data_string */
        $data_string = DLOutput::get_json($manifest, false);

        /** @var string $entropy */
        $hash = hash('sha256', $data_string);

        $this->save_data($this->target, $data_string, $this->entropy);

        /** @var string $content */
        $content = $this->read_storage_data($this->target, $this->entropy);

        return hash('sha256', $content) === $hash;
    }

    /**
     * Devuelve los datos del manifiesto previamente guardados, caso contrario,
     * devolverá un array vacío.
     * 
     * @return array
     */
    public function get(): array {
        /** @var array $manifest */
        $manifest = [];
        try {
            /** @var string $string_content */
            $string_content = $this->read_storage_data($this->target, $this->entropy);
            $manifest = json_decode($string_content, true);

            # Con esto se evalúa si el manifiesto está corrompido. En caso contrario, el 
            # método devolverá un array vacío
            new ManifestData($manifest);
        } catch (Exception | RuntimeException $error) {
            return [];
        }

        return $manifest;
    }

    /**
     * Devuelve el manifiesto en formato DTO
     * 
     * @return ManifestData|null
     */
    public function get_manifest(): ?ManifestData {
        /** @var ManifestData|null $manifest */
        $manifest = null;

        try {
            $manifest = new ManifestData($this->get());
        } catch (Exception | RuntimeException $error) {
            return null;
        }

        return $manifest;
    }
}