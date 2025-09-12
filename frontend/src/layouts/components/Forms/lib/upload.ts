import { getURLBase } from "./request";

export type OnProgress = (progress: number, done: boolean) => void;
export type OnLoaded = (xhr: XMLHttpRequest, done: boolean) => void;
export type OnError = (xhr: XMLHttpRequest) => void;
export type OnAbort = (xhr: XMLHttpRequest) => void;

export function upload(
    form: HTMLFormElement,
    onprogress: OnProgress | undefined = undefined,
    onloaded: OnLoaded | undefined = undefined,
    onerror: OnError | undefined = undefined,
    onabort: OnAbort | undefined = undefined
): unknown {
    if (!(form instanceof HTMLFormElement)) {
        throw new Error("Se esperaba un formulario como argumento en el parámetro «form»");
    }

    const action: string | null = form.getAttribute('action');
    if (typeof action != "string") return undefined;

    let value: unknown = undefined;
    let done: boolean = false;

    const url: string = `${getURLBase()}${action}`;
    const xhr = new XMLHttpRequest();
    xhr.open('POST', url);

    xhr.upload.onprogress = function (event: ProgressEvent): void {
        if (typeof onprogress != "function") return;
        const loaded: number = (event.loaded / event.total) * 100;
        onprogress(loaded, event.loaded == event.total);
    }

    xhr.upload.onerror = function (event: ProgressEvent): void {
        if (!(this instanceof XMLHttpRequest)) return;
        if (typeof onerror != "function") return;
        onerror(this);
    };

    xhr.onabort = function (event: ProgressEvent): void {
        if (!(this instanceof XMLHttpRequest)) return;
        if (typeof onabort != "function") return;
        onabort(this);
    }

    xhr.upload.onload = function (event: ProgressEvent): void {
        done = event.loaded === event.total;
    }

    xhr.onload = function (event: ProgressEvent): void {
        if (!(this instanceof XMLHttpRequest)) return;
        if (typeof onloaded != "function") return;
        onloaded(this, done);
    }

    xhr.send(new FormData(form));
    return value;
}

/**
 * Devuelve la respuesta del servidor después de completar o fracasar en el intento de subida de archivos.
 * Esta función interpreta la respuesta contenida en el objeto `XMLHttpRequest` proporcionado,
 * devolviendo el contenido parseado si es posible, o `undefined` si la respuesta es inválida o vacía.
 * 
 * @param xhr Objeto `XMLHttpRequest` que contiene la respuesta del servidor.
 * @returns El contenido de la respuesta parseado como JSON, texto plano o `undefined` si no hay respuesta válida.
 */
export function getResponse(xhr: XMLHttpRequest): unknown {
    try {
        const contentType = xhr.getResponseHeader("Content-Type") ?? "";

        if (!xhr.responseText) {
            return undefined;
        }

        const isJSON: boolean = /^applications\/json/.test(contentType);

        return isJSON
            ? JSON.parse(xhr.responseText)
            : xhr.responseText
    } catch {
        return xhr.responseText ? xhr.responseText : undefined;
    }
}
