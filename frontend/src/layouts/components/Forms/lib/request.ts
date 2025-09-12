import { getLocation } from "../../../routers/sources/router";
import type { ResponseData, ResponseServerData } from "../Interface/ResponseServer";

/**
 * Permite realizar una petición al servidor utilizando `fetch`.
 * 
 * Retorna un objeto con el código de estado HTTP, un posible valor de `route`, y un mensaje obtenido del cuerpo de la respuesta,
 * intentando detectar las claves comunes como `message`, `success`, `error` o `send`.
 * 
 * Si ocurre un error durante la petición (por ejemplo, fallo de red o respuesta malformada),
 * se captura la excepción y se retorna un objeto con un mensaje de error genérico.
 * 
 * @param action - URL o endpoint al que se enviará la solicitud.
 * @param init - Opciones opcionales para la configuración de la solicitud.
 * @returns 
 */
export async function request(action: string, init?: RequestInit): Promise<unknown> {
    try {
        const response: Response = await fetch(endpoint(action), init);
        const status = response.status;

        const data = await safeJSON(response, {});

        return {
            error: !response.ok,
            code: status,
            route: data.route ?? undefined,
            message: data.message ?? data.success ?? data.error ?? data.send,
            data
        };
    } catch (e) {
        console.error("Request failed:", e);
        return {
            error: true,
            message: "Ocurrió un error al realizar la solicitud.",
        };
    }
}

/**
 * Intenta parsear la respuesta como JSON.
 * Si falla, devuelve `null` o el valor por defecto proporcionado.
 * 
 * @param response - Objeto Response obtenido desde fetch.
 * @param fallback - Valor por defecto si no se puede parsear como JSON.
 * @returns Un objeto JSON o el valor de fallback.
 */
export async function safeJSON<T = unknown>(response: Response, fallback: T | null = null): Promise<any> {
    try {
        return await response.json();
    } catch {
        return fallback;
    }
}

/**
 * Obtiene la URL base pública definida en la etiqueta `<link rel="canonical">`.
 *
 * Esta función se utiliza principalmente para obtener la URL base del sitio en producción,
 * como por ejemplo `https://misitio.com`, partiendo del valor del atributo `href` de un
 * elemento `<link rel="canonical">`.
 *
 * - Si la etiqueta `<link rel="canonical">` no está presente o no es válida, la función
 *   retorna la URL actual del navegador (`location.href`) como fallback.
 *
 * - El valor retornado es normalizado, eliminando cualquier barra final redundante (`/`).
 *
 * @example
 * // HTML en producción:
 * // <link rel="canonical" href="https://misitio.com/" />
 *
 * const base = getURLBase();
 * // base === "https://misitio.com"
 *
 * @returns {string} URL base pública sin barras finales.
 */
export function getURLBase(): string {
    const link: HTMLLinkElement | null = document.querySelector("[rel='canonical']");

    if (!(link instanceof HTMLLinkElement)) {
        return getLocation().href;
    }

    const url: URL = new URL(link.href);
    return url.href.replace(/\/+$/, '');
}


/**
 * Obtiene la URL base local desde el atributo `data-href` del `<link rel="canonical">`.
 *
 * Esta función está pensada para entornos de desarrollo (por ejemplo, cuando se utiliza Vite)
 * donde la URL base del frontend puede diferir de la URL pública declarada en producción.
 *
 * - Si el atributo `data-href` está presente en el elemento `<link rel="canonical">`,
 *   se considera como la URL local (por ejemplo: `http://localhost:5173`).
 *
 * - Si `data-href` no está presente o el elemento no existe, la función retorna la
 *   URL pública usando `getURLBase()` como fallback.
 *
 * - El valor retornado es normalizado, eliminando cualquier barra final redundante (`/`).
 *
 * @example
 * // HTML en desarrollo:
 * // <link rel="canonical" href="http://localhost:4000" data-href="http://localhost:5173" />
 *
 * const localBase = getLocalURL();
 * // localBase === "http://localhost:5173"
 *
 * @returns {string} URL base local sin barras finales.
 */
export function getLocalURL(): string {
    const link: HTMLLinkElement | null = document.querySelector('[rel="canonical"]');

    if (!(link instanceof HTMLLinkElement)) {
        return getURLBase();
    }

    const { href } = link.dataset;
    if (!href) return getURLBase();

    const url: URL = new URL(href);
    return url.href.replace(/\/+$/, '');
}


/**
 * Construye una ruta absoluta a partir de una ruta lógica relativa.
 *
 * Esta función utiliza `getURLBase()` como base y concatena la ruta lógica proporcionada,
 * garantizando que no haya dobles slashes (`//`) entre los segmentos.
 *
 * - Elimina automáticamente cualquier barra inicial redundante en la ruta lógica.
 * - Funciona correctamente incluso si el sistema está desplegado en un subdirectorio
 *   (ej. `https://dominio.com/carpeta/`).
 *
 * @example
 * // Supongamos que el canonical es:
 * // <link rel="canonical" href="https://dominio.com/app/" />
 *
 * route('api/usuario'); // → "https://dominio.com/app/api/usuario"
 * route('/api/usuario'); // → "https://dominio.com/app/api/usuario"
 *
 * @param {string} route Ruta lógica relativa (por ejemplo: "api/usuario" o "/api/usuario").
 * @returns {string} Ruta absoluta correctamente compuesta a partir de la URL base.
 */
export function endpoint(route: string): string {
    route = route.replace(/^\/+/, '');
    return `${getURLBase()}/${route}`;
}


/**
 * Devuelve la respuesta del servidor formateada a formato legible.
 * 
 * @param input Datos de entrada desconocida a ser analizada.
 * @returns 
 */
export function getData(input: unknown): ResponseData {
    const data: ResponseServerData = input as ResponseServerData;

    return {
        error: !data.status,
        message: data.error ?? data.message ?? data.success ?? '',
        details: data.details
    };
}