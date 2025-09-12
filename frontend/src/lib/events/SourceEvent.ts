import { getURLBase } from "../../layouts/components/Forms/lib/request";

/**
 * Conecta a un servidor SSE (Server-Sent Events) para recibir eventos en tiempo real.
 * 
 * @param route Ruta del servidor para la conexión SSE.
 * @param element Elemento HTML donde se mostrará la salida.
 * @returns Función para cerrar la conexión manualmente.
 */
export function event(route: string, element: HTMLElement): () => void {
    if (!(element instanceof HTMLElement)) {
        throw new Error("El parámetro 'element' debe ser un HTMLElement válido.");
    }

    if (!route || typeof route !== "string") {
        throw new Error("El parámetro 'route' debe ser una cadena de texto válida.");
    }

    route = route.trim();
    const url: string = getURLBase().replace(/\/$/, "") + "/" + route.replace(/^\//, "");

    const source: EventSource = new EventSource(url);
    let retries = 0;

    source.onmessage = (event: MessageEvent) => {
        const textNode = document.createTextNode(event.data + "\n");
        element.appendChild(textNode);
        element.scrollTop = element.scrollHeight;
    };

    source.onerror = () => {
        ++retries;
        const errorNode = document.createTextNode(`Error SSE. Reintento #${retries}\n`);
        element.appendChild(errorNode);
        element.scrollTop = element.scrollHeight;
    };

    // Devuelvo una función para cerrar la conexión manualmente
    return () => source.close();
}
