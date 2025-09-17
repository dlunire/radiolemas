export const urlStream: string = "https://stream.jokmah.it/8024/stream";

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
 * @param { HTMLAudioElement } audio Elemento de audio a ser manipulado
 */
export function constrols(audio: HTMLAudioElement) {
    if (!(audio instanceof HTMLAudioElement)) {
        throw new Error("controls: Se esperaba un elemento de audio como argumento en «audio»");
    }

    const button: HTMLButtonElement | null = document.querySelector("#play");
    if (!(button instanceof HTMLButtonElement)) return;

    let play: boolean = false;

    const iconPlay: HTMLElement | null = button.querySelector("[data-hidden]:first-child");
    const iconPause: HTMLElement | null = button.querySelector("[data-hidden]:last-child");
    if (!(iconPlay instanceof HTMLElement) || !(iconPause instanceof HTMLElement)) return;

    const volume: HTMLInputElement | null = document.querySelector("#volume");
    if (!(volume instanceof HTMLInputElement)) return;

    volume.value = String(getVolume());

    const label: HTMLSpanElement | null = document.querySelector("#volume-label span");
    if (!(label instanceof HTMLSpanElement)) return;

    label.textContent = String(100 * getVolume());
    const title: string = button.title;

    button.addEventListener("click", function () {
        play = !play;
        play ? audio.play() : audio.pause();

        button.title = !play ? title : "Pausar reproducción";
    });

    volume.addEventListener('input', function () {
        const value: number = Number(this.value.trim());
        if (Number.isNaN(value)) return;

        audio.volume = value;
        setVolume(value);

        label.textContent = String(value * 100);
    });

    audio.addEventListener("pause", function () {
        if (play) {
            play = false;
        }

        iconState(play);
    });

    audio.addEventListener("playing", function () {
        if (!play) {
            play = true;
        }

        iconState(play);
    });

    /**
    * Cambia el icon en función del estado de reproducción.
    * 
    * @param { boolean } play Estado de la reproducción
    * @returns { void }
    */
    function iconState(play: boolean): void {
        if (!(iconPlay instanceof HTMLElement) || !(iconPause instanceof HTMLElement)) return;
        iconPlay.dataset.hidden = String(play);
        iconPause.dataset.hidden = String(!play);
    }
}

init(urlStream);