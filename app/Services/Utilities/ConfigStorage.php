<?php

declare(strict_types=1);

namespace DLUnire\Services\Utilities;

use InvalidArgumentException;

/**
 * Ayuda a almacenar la configuración de la aplicación en un contenedor binario por medio
 * de `DLUnire\Services\Utilities\Data`.
 * 
 * @package DLUnire\Services\Utilities
 * 
 * @version v0.0.1 (release)
 * @author David E Luna M <dlunireframework@gmail.com>
 * @copyright (c) 2025 David E Luna M
 * @license Comercial
 */
class ConfigStorage {

    private string $entropy = "22fcb758-ddeb-11f0-a4f2-0023ae88eef0";
    
    /**
     * El objeto `$data` proporciona los métodos necesarios para almacenar o recuperar datos.
     *
     * @var Data
     */
    public readonly Data $data;

    public function __construct() {
        $this->data = new Data();
    }

    /**
     * Almacena los datos en un contenedor binario utilizando llave o frase de entropía. Debe pasar
     * un array como argumento en el parámetro `$data`.
     * 
     * ### Recomendaciones
     * 
     * Se recomienda pasar un array asociativo y validarlo pasando `true` como argumento en el
     * parámetro `$eval` para activar la validación. Esto es fundamental para la integridad de los datos.
     * 
     * Sin embargo, no estás obligado hacerlo de la forma recomendada si el propósito es diferente.
     * 
     * @param string $filename Nombre de archivo del contenedor binario (sin extensión). El método
     *                         `$this->data->save(...)` se encarga de agregarlo automáticamente.
     * 
     * @param array $data Datos lógicos cuyo destino final es un contenedor binario, independientemente
     *                    de su representación intermedia.
     * 
     * @param boolean $eval Permite validar que la estructura final de datos a persistir, resultante de
     *                      la fusión entre los datos existentes y los nuevos, sea un array asociativo
     *                      cuyas claves cumplan el criterio acordado.
     *
     * @return void
     * 
     * @throws InvalidArgumentException Si la validación falla, el método `$this->data->save(...)`
     *                                  lanzará la excepción.
     */
    public function save(string $filename, array $data = [], bool $eval = false): void {
        $this->data->set_entropy($this->entropy);
        
        /**
         * Datos previamente almacenados, si estos existen o tienen formato reconocible.
         * 
         * @var array|null $current_data
         */
        $current_data = $this->data->get(filename: $filename);
        
        if (!\is_array($current_data)) {
            $current_data = [];
        }

        /**
         * Fusiona dos arrays en uno nuevo, donde el segundo sobrescribe al
         * primero cuando las claves coinciden.
         * 
         * @var array $new_data
         */
        $new_data = [...$current_data, ...$data];

        $this->data->save(filename: $filename, data: $new_data, eval: $eval);
    }

    /**
     * Devuelve los datos previamente almacenados
     *
     * @param string $filename Nombre del archivo del contenedor binario (sin extensiones)
     * @return array|null
     */
    public function get(string $filename): ?array {
        $this->data->set_entropy(entropy: $this->entropy);
        return $this->data->get($filename);
    }
}
