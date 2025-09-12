<?php

declare(strict_types=1);

namespace DLUnire\Models\DTO;

/**
 * Copyright (c) 2025 David E Luna M
 * Licensed under the MIT License. See LICENSE file for details.
 *
 * Objeto de transferencia de datos (DTO) para exponer la metadata esencial del frontend,
 * como título, descripción, token de seguridad y token CSRF. Esta clase es de solo lectura
 * y se utiliza para inyectar valores semánticos en vistas y encabezados HTML.
 *
 * @version v0.0.1
 * @package DLUnire\Models\DTO
 * @author David E Luna M
 * @license MIT
 *
 * @property-read string $title       Título del documento o página HTML.
 * @property-read string $description Descripción general para SEO y tarjetas sociales.
 * @property-read string $token       Token de seguridad o autorización para vistas.
 * @property-read string $csrf        Token antifalsificación (CSRF) para formularios.
 * @property-read string $color       Color de tema visual para navegadores compatibles (mobile/desktop).
 */
final class Frontend {

    /** @var string $title Título principal del documento HTML. */
    public readonly string $title;

    /** @var string $description Descripción resumida del contenido. */
    public readonly string $description;

    /** @var string $token Token de autorización o identificación contextual. */
    public readonly string $token;

    /** @var string $csrf Token de protección contra ataques CSRF. */
    public readonly string $csrf;

    /** @var string $color Color de tema de la aplicación */
    public readonly string $color;

    /**
     * Constructor vacío. Los valores se asignan mediante setters explícitos.
     */
    public function __construct() {
    }

    /**
     * Establece el título del documento.
     *
     * @param string $title Título visible en la pestaña del navegador o encabezado HTML.
     */
    public function set_title(string $title): void {
        $this->title = trim($title);
    }

    /**
     * Establece la descripción del contenido.
     *
     * @param string $description Descripción para motores de búsqueda y tarjetas sociales.
     */
    public function set_description(string $description): void {
        $this->description = trim($description);
    }

    /**
     * Establece el token de autorización para uso general.
     *
     * @param string $token Token generado para uso contextual (no CSRF).
     */
    public function set_token(string $token): void {
        $this->token = trim($token);
    }

    /**
     * Establece el token antifalsificación (CSRF).
     *
     * @param string $token Token único para protección CSRF.
     */
    public function set_csrf(string $token): void {
        $this->csrf = trim($token);
    }

    /**
     * Establece el color de tema visual para navegadores compatibles.
     *
     * Este color se utiliza principalmente en la etiqueta `<meta name="theme-color" />`
     * para personalizar la interfaz en dispositivos móviles y navegadores modernos.
     *
     * @param string $color Código de color en formato HEX (ej. "#08d").
     */
    public function set_color(string $color): void {
        $this->color = trim($color);
    }
}