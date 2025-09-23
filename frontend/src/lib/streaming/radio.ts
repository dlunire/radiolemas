export const urlStream: string = "https://stream.jokmah.it/8024/stream";
export let play: boolean = false;

export interface Audio {
    volume: number;
    play: boolean;
    pause: boolean;
}

/**
 * Almacena el el volumen seleccionado por el usuario en el navegador.
 * 
 * @param value Valor numérico que representa el volumen.
 */
export function setVolume(value: number): void {
    if (typeof value != "number") {
        throw new Error("setVolume: se esperaba un valor numérico como argumento en «value»");
    }

    localStorage.setItem('volume', String(value));
}

/**
 * Devuelve el volumen previamente almacenado en el navegador.
 * 
 * @returns
 */
export function getVolume(): number {
    const value: number = Number(localStorage.getItem('volume') ?? 0.5);
    return value;
}

/**
 * Permite inicializar la escucha de la radio.
 * 
 * @param { string } url URL del stream
 */
function init(url: string): void {
    if (!url || typeof url !== "string") {
        throw new Error("init: Se requiere un «string» como argumento");
    }

    /** @type { HTMLAudioElement } */
    const audio: HTMLAudioElement = document.createElement('audio');

    audio.controls = true;
    audio.volume = getVolume();
    audio.src = url;

    constrols(audio);
}

/**
 * Permite controlar el elemento de audio
 * 
 * @param audio Elemento de audio a ser manipulado
 */
export function constrols(audio: HTMLAudioElement, volume: number = 1): Audio {
    if (!(audio instanceof HTMLAudioElement)) {
        throw new Error("controls: Se esperaba un elemento de audio como argumento en «audio»");
    }

    let play: boolean = false;
    let pause: boolean = true;
    let currentVolume: number = getVolume();

    audio.addEventListener('pause', function() {

    });

    return {
        volume: 0,
        play: false,
        pause: true
    }
}

init(urlStream);