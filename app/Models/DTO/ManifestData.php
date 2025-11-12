<?php

declare(strict_types=1);

namespace DLUnire\Models\DTO;

use InvalidArgumentException;

/**
 * Estructura de un Manifiesto de un PWA
 * 
 * @package DLUnire\Models\DTO
 * @author David E Luna M <dlunireframework@gmail.com>
 * @copyright (c) 2025 - David E Luna M
 * @license Propietaria
 */
final class ManifestData {
    /** @var string Indica que debe comportarse como una aplicación nativa */
    public const NATIVE = "standalone";

    /** @var string Ocupa toda la pantalla sin ningún marco, ni barra de estado */
    public const FULLSCREEN = "fullscreen";

    /** @var string Muestra solo un mínimo de controles en el navegador. Botones atrás o recargar */
    public const MINIMAL_UI = "minimal-ui";

    /** @var string Se abre como un navegador normal, mostrando la URL y controles completos */
    public const BROWSER = "browser";

    public const DISPLAY = [self::NATIVE, self::FULLSCREEN, self::MINIMAL_UI, self::BROWSER];

    /** @var string $name Nombre de la aplicación */
    public readonly string $name;

    /** @var string $short_name Nombre corto de la aplicación */
    public readonly string $short_name;

    /** @var string $start_url URL corta o relativa de la aplicación */
    public readonly string $start_url;

    /**
     * @var string $display Modo de visualización de la PWA según el manifiesto Web App Manifest.
     * Define cómo se presenta la aplicación en el navegador/dispositivo:
     * - 'standalone': Como app nativa (sin barra de navegador).
     * - 'fullscreen': Pantalla completa, sin marcos ni barras.
     * - 'minimal-ui': Controles mínimos (ej: botones atrás/recargar).
     * - 'browser': Modo navegador completo con URL y controles.
     * 
     * Valida contra las constantes DISPLAY. Obligatorio para PWAs.
     */
    public readonly string $display;

    /** @var string $background_color Color de fondo de la aplicación */
    public readonly string $background_color;

    /** @var string $theme_color Color de tema de la aplicación */
    public readonly string $theme_color;

    /** @var string Orientación de la aplicación */
    public readonly string $orientation;

    /** @var ManifestIcon[] $icons */
    public readonly array $icons;

    /** @var array $manifest Configuración cruda (RAW) de la configuración de la aplicación */
    private array $manifest = [];

    /**
     * Carga los datos del manifiesto para ser almacenado en formato binario
     * 
     * @param array $manifest Datos del manifiesto
     * @throws InvalidArgumentException Si los datos no son válidos
     */
    public function __construct(array $manifest) {
        $this->manifest = $manifest;
        
        $this->load_options();
        $this->load_icons();
    }

    /**
     * Carga las opciones de configuración del manifiesto
     * 
     * @return void
     * @throws InvalidArgumentException
     */
    private function load_options(): void {
        $this->name = $this->get_value('name');
        $this->short_name = $this->get_value('short_name');
        $this->start_url = $this->get_value('start_url');

        /** @var string $display */
        $display = $this->get_value('display');

        if (!in_array($display, self::DISPLAY, strict: true)) {
            /** @var string $valid */
            $valid = implode(" | ", self::DISPLAY);

            throw new InvalidArgumentException("__construct: Los valores permitidos son algunos de los siguientes: {$valid}, sin embargo, se recibió «{$display}»", 400);
        }

        $this->display = $display;
        $this->background_color = $this->get_value('background_color');
        $this->theme_color = $this->get_value('theme_color');
        $this->orientation = $this->get_value('orientation');
    }

    /**
     * Devuelve el valor del manifiesto. No devuelve array
     * 
     * @param string $key Campo del manifiesto
     * @return string
     * 
     * @throws InvalidArgumentException
     */
    private function get_value(string $key): string {
        /** @var string|null $value */
        $value = $this->manifest[$key] ?? null;

        /** @var string $type */
        $type = gettype($value);

        if (!is_string($value)) {
            throw new InvalidArgumentException("__construct: Se esperaba una cadena en el campo «{$key}», pero en su lugar, se obtuvo «{$type}»", 400);
        }

        return $value;
    }

    /**
     * Devuelve un array de iconos
     * 
     * @return void
     * @throws InvalidArgumentException
     */
    private function load_icons(): void {
        /** @var array $iconsRaw */
        $iconsRaw = $this->manifest['icons'] ?? [];

        if (!is_array($iconsRaw)) {
            throw new InvalidArgumentException("__construct: Se esperaba un array en el campo «icons»", 400);
        }

        /** @var ManifestIcon[] $icons */
        $icons = [];

        foreach ($iconsRaw as $icon) {
            if (!is_array($icon)) continue;
            $icons[] = new ManifestIcon($icon);
        }

        // Lanza excepción SOLO si no hay icons después de procesar
        if (empty($icons)) {
            throw new InvalidArgumentException("__construct: Se esperaba un array de íconos en el campo «icons», sin embargo, no se definieron iconos", 400);
        }

        $this->icons = $icons;
    }
}
