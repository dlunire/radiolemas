<?php

declare(strict_types=1);

namespace DLUnire\Services\Traits;

use DLStorage\Errors\ValueError;
use DLUnire\Models\DTO\Frontend;
use Exception;
use InvalidArgumentException;

/**
 * Trait FrontendTrait
 *
 * Ofrece protección CSRF y funciones utilitarias para el frontend del sistema.
 *
 * @package DLUnire\Services\Traits
 * @version v0.0.1
 * @author David E Luna M
 * @license Comercial
 * @copyright Copyright (c) 2025 David E Luna M
 * @copyright Copyright (c) 2025 Alvaro Mantilla
 */
trait FrontendTrait {
    /**
     * Longitud del token en caracteres hexadecimales (debe ser par).
     *
     * @var integer $token_length
     */
    private int $token_length = 500;

    /**
     * Devuelve el Frontend del sistema.
     *
     * Recibe una instancia de Frontend con los metadatos preparados (título, descripción, token, etc.)
     * y renderiza la vista correspondiente, pasándola como contexto a la plantilla.
     *
     * @param Frontend $frontend Objeto de metadatos del frontend para inyectar en la vista.
     * @return string Contenido HTML renderizado.
     */
    public function get_frontend(Frontend $frontend): string {
        return view('home', [
            "frontend" => $frontend
        ]);
    }


    /**
     * Establece el token de protección contra ataques de referencia cruzada.
     *
     * @param string $field Nombre del campo que contiene el token CSRF.
     * @return void
     * 
     * @throws Exception
     */
    private function generate_csrf_token(string $field = 'csrf_token'): void {
        $this->validate_session();

        if (!$this->token_exists($field)) {
            $_SESSION[$field] = bin2hex(random_bytes($this->token_length / 2));
        }
    }

    /**
     * Devuelve el token CSRF para evitar ataques por referencia cruzada (CSRF).
     * 
     * Si el token aún no existe o no es válido, se genera automáticamente.
     *
     * @param string $field Nombre del campo donde se encuentra el token.
     * @return string Token CSRF válido para ser usado en formularios.
     * 
     * @throws Exception Si la sesión no está iniciada.
     */

    public function get_csrf(string $field = 'csrf_token'): string {
        $this->validate_session();
        $this->generate_csrf_token($field);
        return $_SESSION[$field];
    }

    /**
     * Verifica si el token de protección contra ataques de referencia cruzada (CSRF) existe.
     *
     * @param string $field Campo donde se encuentra el token
     * @return boolean
     * 
     * @throws Exception
     */
    private function token_exists(string $field = 'csrf_token'): bool {
        $this->validate_session();

        /** @var string|null $token */
        $token = $_SESSION[$field] ?? null;

        /** @var string $pattern */
        $pattern = "/^[0-9a-f]{{$this->token_length}}$/i";

        return is_string($token) && boolval(preg_match($pattern, $token));
    }

    /**
     * Verifica si la sesión se encuentra activa
     *
     * @return boolean
     */
    private function session_active(): bool {
        return session_status() === PHP_SESSION_ACTIVE;
    }

    /**
     * Valida si la sesión PHP está activa.
     * 
     * Lanza una excepción si la sesión no ha sido iniciada mediante `session_start()`.
     *
     * @return void
     * 
     * @throws Exception Si la sesión no está activa.
     */

    private function validate_session(): void {
        if (!$this->session_active()) {
            throw new Exception("Debe colocar «session_start();» para poder generar tokens");
        }
    }

    /**
     * Establece la longitud del token CSRF.
     *
     * Si se proporciona un número impar, se ajustará automáticamente al siguiente número par.
     *
     * @param integer $length Opcional. Longitud del token CSRF en caracteres hexadecimales. Valor por defecto: 500.
     * @return void
     * 
     * @throws InvalidArgumentException Si la longitud está fuera del rango permitido.
     */

    public function set_csrf_token_length(int $length = 500): void {

        if ($length < 32 || $length > 4096) {
            throw new InvalidArgumentException("La longitud del token debe estar entre 32 y 4096 caracteres.");
        }

        if (($length & 1) === 1) {
            ++$length;
        }

        $this->token_length = $length;
    }

    /**
     * Valida el token CSRF enviado por el cliente HTTP.
     *
     * Este método compara de forma segura el token recibido desde una petición HTTP (por ejemplo, en un formulario POST
     * o cabecera personalizada) con el token previamente generado y almacenado en la sesión del servidor. La comparación
     * se realiza utilizando `hash_equals()` para evitar ataques de temporización (timing attacks).
     *
     * Si los tokens no coinciden, se lanza una excepción con código de estado HTTP 403, lo que indica un intento
     * potencial de falsificación de solicitud entre sitios (CSRF).
     *
     * @param string $csrf_token Token CSRF recibido desde el cliente (por ejemplo, vía input hidden o cabecera HTTP).
     * @param string|null $field [Opcional] Nombre del campo de sesión donde se encuentra el token CSRF. Por defecto: 'csrf_token'.
     * @return void
     *
     * @throws ValueError Si el token proporcionado no coincide con el almacenado en la sesión.
     *
     * @see https://owasp.org/www-community/attacks/csrf — OWASP: Cross-Site Request Forgery (CSRF)
     *
     * @note Este método sigue las prácticas recomendadas de OWASP para la prevención de CSRF, incluyendo:
     *       - Almacenamiento de tokens en la sesión del servidor.
     *       - Envío del token mediante canal separado (POST/cabecera).
     *       - Comparación segura con `hash_equals()`.
     */
    public function validate_csrf(string $csrf_token, ?string $field = null): void {
        if (!hash_equals($this->get_csrf($field ?? 'csrf_token'), $csrf_token)) {
            throw new ValueError("El token CSRF puede estar comprometido", 403);
        }
    }
}