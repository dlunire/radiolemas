<?php

declare(strict_types=1);

namespace DLUnire\Errors;

/**
 * CSVParserException
 *
 * Excepción personalizada utilizada por el analizador CSV para representar errores
 * específicos durante el procesamiento de archivos con formato CSV.
 * 
 * Esta clase extiende directamente de \Exception y permite identificar
 * de forma precisa los errores relacionados con la tokenización, delimitación,
 * estructura o lectura de archivos CSV dentro del sistema DLUnire.
 *
 * @package DLUnire\Errors
 * @version v0.0.1
 * @author David E Luna M
 * @license MIT
 * @copyright Copyright (c) 2025 David E Luna M
 */
final class CSVParserException extends \Exception {
}