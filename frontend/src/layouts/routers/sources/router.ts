import { writable } from 'svelte/store';
import { getLocalURL } from '../../components/Forms/lib/request';

export const currentRoute = writable(getPathname());

/**
 * Navega a una nueva ruta utilizando la History API sin recargar la página.
 * 
 * - Elimina cualquier slash duplicado entre `base` y `path`.
 * - Normaliza la URL final para evitar errores en subdirectorios.
 * 
 * @param path Ruta relativa o absoluta a navegar (ej: "/producto/123", "producto/123")
 */
export function navigate(path: string): void {
    /** Elimina slashes finales */
    const base = getLocalURL().replace(/\/+$/, '');

    /** Elimina slashes iniciales y finales y después, elimina duplicados */
    const cleanPath = path.replace(/^\/+|\/+$/g, '').replace(/\/+/g, '/');

    /** Ensambla la URL completa */
    const fullURL = `${base}/${cleanPath}`;

    /** Instancia de URL */
    const url = new URL(fullURL);

    /** URL Completa */
    const current = location.href;

    if (url.href !== current) {
        history.pushState({}, '', url.href);
        currentRoute.set(url.pathname);
    }
}

/**
 * Devuelve la URL completa a partir de una ruta relativa.
 * 
 * @param path Ruta relativa
 * @returns 
 */
export function getFullURL(path: string): string {
    path = path.replace(/^\/+|\/+$/, '');
    let url: string = `${getLocalURL()}/${path}`;
    return url;
}

/**
 * Devuelve la ruta relativa a partir del objeto Location
 * 
 * @returns 
 */
export function getPathname(): string {
    return getLocation().pathname;
}

/**
 * Devuelve el objeto Location
 * @returns 
 */
export function getLocation(): Location {
    let location: Location | undefined = undefined;

    if (typeof globalThis != "undefined" && typeof globalThis.location) {
        location = globalThis.location;
    }

    if (typeof window != "undefined" && !location) {
        location = window.location;
    }

    if (!location) {
        throw new Error("No se pudo obtener «location»");
    }

    return location;
}

// Escucha cambios de historial (botones atrás/adelante del navegador)
window.addEventListener('popstate', () => {
    currentRoute.set(getPathname());
});
