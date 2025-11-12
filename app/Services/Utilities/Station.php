<?php

declare(strict_types=1);

namespace DLUnire\Services\Utilities;

use DLStorage\Storage\SaveData;
use DLUnire\Models\DTO\StationData;
use Exception;

/**
 * Opciones de configuración de la estación de radio. Permite almacenar
 * u obtener información previamente almacenada.
 * 
 * En el caso de que la información no exista, entonces, devolverá información genérica.
 */
final class Station extends SaveData {

    /**
     * Llave de entropía. No requiere seguridad en lo absoluto.
     *
     * @var string $entropy
     */
    private string $entropy;

    /**
     * Archivo de destino de información de la emisora
     *
     * @var string $target
     */
    private string $target = "/config/station";

    public function __construct() {
        $this->entropy = hash('sha256', 'Una frase de entropía');
    }

    /**
     * Guarda los datos en formato binario e indica si se produjetos cambios devolviendo `true`
     * o `false` según sea el caso.
     * 
     * El valor `false` no indica error, simplemente: sin cambios
     *
     * @param string $name Nombre legal de la estación de radio.
     * @param string $motto Lema o consigna de la estación
     * @return boolean
     */
    public function save(string $name, string $motto): bool {
        /** Observación: permite validar la data antes de almacenar */
        new StationData($name, $motto);

        /** @var non-empty-string $content */
        $content = json_encode([
            "name" => $name,
            "motto" => $motto
        ]);

        /** @var non-empty-string $hash */
        $hash = hash('sha256', $content);

        $this->save_data($this->target, $content, $this->entropy);

        $saved_hash = hash('sha256', $this->get_raw_data());

        return $hash === $saved_hash;
    }

    /**
     * Devuelve información de la estación de radio
     *
     * @return StationData
     */
    public function get_info(): StationData {
        /** @var array{name: string, motto: string} */
        $data = $this->get_data();

        /** @var non-empty-string $name */
        $name = $data['name'];

        /** @var non-empty-string $motto */
        $motto = $data['motto'];

        return new StationData($name, $motto);
    }

    /**
     * Devuelve los datos en formato crudo
     *
     * @return string
     */
    private function get_raw_data(): string {
        /** @var string $content Contenido sin procesar */
        $content = "";

        try {
            $content = $this->read_storage_data($this->target, $this->entropy);
        } catch (Exception $error ) {
            $content = json_encode([
                "name" => "DLUnire Framework",
                "motto" => "DLUnire: Tu código, más rápido, más seguro, más claro."
            ]);
        }

        return $content;
    }

    /**
     * Devuelve los datos procesados
     *
     * @return array{name: string, motto: string}
     */
    private function get_data(): array {
        /** @var non-empty-string $content */
        $content = $this->get_raw_data();

        return json_decode($content, true);
    }
}