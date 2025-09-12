<?php

declare(strict_types=1);

namespace DLUnire\Models\Tables;

use DLCore\Database\Model;
use DLUnire\Models\DTO\CoursesData;

/**
 * Copyright (c) 2025 David E Luna M
 * Licensed under the MIT License. See LICENSE file for details.
 *
 * Clase que representa la tabla `courses` en la base de datos.
 * Extiende la clase base `Model` del núcleo DLCore para acceder a
 * funcionalidades ORM como inserción, actualización, búsqueda y eliminación.
 *
 * @version v0.0.1
 * @package DLUnire\Models\Tables
 * @license MIT
 * @author David E Luna M
 * @copyright Copyright (c) 2025
 */
final class Courses extends Model {

    /**
     * Devuelve una lista de cursos
     *
     * @param string $order_by Campo seleccionado para ordenar el curso
     * @param integer $page [Opcional] Número de página.
     * @param integer $rows [Opcional] Número de registros por página.
     * @return array{
     *      pages: int;
     *      page: int;
     *      pagination: string;
     *      rows: int;
     *      total: int;
     *      register: array<int, CoursesData[]>
     * }
     */
    public static function get_courses(string $order_by, int $page = 1, int $rows = 30): array {

        /** @var array{
         *      pages: int;
         *      page: int;
         *      pagination: string;
         *      rows: int;
         *      total: int;
         *      register: array
         * } $data  */
        $data = self::order_by($order_by)->desc()->paginate($page, $rows);

        /** @var CoursesData[] $newData */
        $newData = [];

        foreach ($data['register'] ?? [] as $currentData) {
            $newData[] = new CoursesData($currentData);
        }

        $data['register'] = $newData;

        return $data;
    }
}