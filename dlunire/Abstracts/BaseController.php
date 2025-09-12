<?php

declare(strict_types=1);

namespace Framework\Abstracts;

use DLCore\Core\BaseController as CoreBaseController;
use DLRoute\Server\DLServer;
use DLStorage\Errors\StorageException;
use DLUnire\Models\DTO\FilenameData;
use DLUnire\Models\DTO\Frontend;
use DLUnire\Services\Traits\CheckConectionTrait;
use DLUnire\Services\Traits\FrontendTrait;
use Exception;

abstract class BaseController extends CoreBaseController {
    use FrontendTrait, CheckConectionTrait;

    /**
     * Devuelve el contenido del frontend
     *
     * @param string $title Título del frontend
     * @param string $description Descripción del frontend
     * @return string
     */
    public function get_frontend_content(string $title = "Consultas", string $description = "Consulta de registros"): string {
        /** @var Frontend $frontend */
        $frontend = new Frontend();

        $frontend->set_title($title);
        $frontend->set_description($description);
        $frontend->set_token($this->generate_uuid());
        $frontend->set_csrf($this->get_csrf());

        return $this->get_frontend($frontend);
    }

    /**
     * Depura la ruta para convertirla al formado del sistema operativo en el que está
     * corriendo la aplicación
     *
     * @param string $route Ruta a ser depurada
     * @return string
     */
    private function debug_route(string $route): string {
        $route = trim($route);
        $route = trim($route, "\\\/");
        $route = preg_replace("/\/+|\\\\+/", DIRECTORY_SEPARATOR, $route);
        return $route;
    }
}
