<?php

declare(strict_types=1);

namespace DLUnire\Controllers\Admin\Dashboard;

use DLUnire\Services\Traits\FrontendTrait;
use Framework\Abstracts\BaseController;

/**
 * Clase controladora responsable de gestionar la carga de la página principal del usuario autenticado.
 *
 * Esta clase extiende de `BaseController` y está diseñada para ser utilizada en entornos protegidos
 * mediante Middleware, lo cual garantiza que solo usuarios autenticados puedan acceder a sus métodos.
 * Se encarga principalmente de procesar la solicitud al panel de control (dashboard) y devolver la vista
 * correspondiente.
 *
 * @package DLUnire\Controllers\Admin\Dashboard
 * @version v0.0.1
 * @license Comercial
 * @author David E Luna M
 * @copyright Copyright (c) 2025 David E Luna M
 * @uses \DLUnire\Services\Traits\FrontendTrait
 *
 * @method string index() Retorna el contenido del panel de control del usuario autenticado.
 * @method string certificate() Devuelve la página de certificados.
 * @method string history() Devuelve la página del historial de actividades.
 * @method string settings() Devuelve la página de configuración.
 * @method string profile() Devuelve la página del perfil del usuario.
 */
final class DashboardController extends BaseController {
    use FrontendTrait;

    /**
     * Carga la página principal del usuario autenticado.
     *
     * Este método está protegido por Middleware que garantiza la autenticación del usuario.
     * Construye una instancia de Frontend con los metadatos necesarios (título, descripción, tokens),
     * y retorna la vista correspondiente al panel de control.
     *
     * @return string Contenido renderizado del panel de control.
     */
    public function index(): string {
        return $this->get_frontend_content("Dashboard", "Página principal de administración del sistema");
    }

    /**
     * Página de certificados.
     *
     * @return string Contenido renderizado de la sección de certificados.
     */
    public function certificate(): string {
        return $this->get_frontend_content("Certificados", "Revise y consulte los certificados de los estudiantes inscritos");
    }

    /**
     * Historial de carga.
     *
     * @return string Contenido renderizado del historial de actividades.
     */
    public function history(): string {
        return $this->get_frontend_content("Historial", "Revisa el histórico de actividades");
    }

    /**
     * Historial de carga.
     *
     * @return string Contenido renderizado del historial de actividades.
     */
    public function register(): string {
        return $this->get_frontend_content("Registro", "Consulte el registro de estudiantes");
    }


    /**
     * Página de configuración.
     *
     * @return string Contenido renderizado de la sección de configuración.
     */
    public function settings(): string {
        return $this->get_frontend_content("Configuración", "Coloque el nombre de su empresa o marca personal, logotipo y más");
    }

    /**
     * Página de perfil.
     *
     * @return string Contenido renderizado del perfil del usuario.
     */
    public function profile(): string {
        return $this->get_frontend_content("Mi perfil", "Actualice su contraseña");
    }
}
