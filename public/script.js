/** @type { string } */
const url = "https://stream.jokmah.it/8024/stream";

/**
 * Permite inicializar la escucha de la radio.
 * 
 * @param { string } url URL del stream
 */
function init(url) {
    if (!url || typeof url !== "string") {
        throw new Error("init: Se requiere un «string» como argumento");
    }

    /** @type { HTMLAudioElement } */
    const audio = document.createElement('audio');

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
function constrols(audio) {
    if (!(audio instanceof HTMLAudioElement)) {
        throw new Error("controls: Se esperaba un elemento de audio como argumento en «audio»");
    }

    /** @type { HTMLButtonElement | null } */
    const button = document.querySelector("#play");

    if (!(button instanceof HTMLButtonElement)) return;

    /** @type { boolean } */
    let play = false;

    /** @type { HTMLElement | null } */
    const iconPlay = button.querySelector("[data-hidden]:first-child");

    /** @type { HTMLElement | null } */
    const iconPause = button.querySelector("[data-hidden]:last-child");

    if (!(iconPlay instanceof HTMLElement) || !(iconPause instanceof HTMLElement)) return;

    /** @type { HTMLInputElement | null } */
    const volume = document.querySelector("#volume");
    if (!(volume instanceof HTMLInputElement)) return;

    volume.value = String(getVolume());

    /** @type { HTMLSpanElement | null } */
    const label = document.querySelector("#volume-label span");
    if (!(label instanceof HTMLSpanElement)) return;

    button.addEventListener("click", function () {
        play = !play;
        play ? audio.play() : audio.pause();
    });

    volume.addEventListener('input', function () {
        /** @type { number } */
        const value = Number(this.value.trim());

        if (Number.isNaN(value)) return;
        audio.volume = value;
        setVolume(value);
        
        label.textContent = value * 100;
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
    function iconState(play) {
        iconPlay.dataset.hidden = String(play);
        iconPause.dataset.hidden = String(!play);
    }
}

/**
 * Almacena el el volumen seleccionado por el usuario en el navegador.
 * 
 * @param { number } value Valor numérico que representa el volumen.
 * @returns { void }
 */
function setVolume(value) {
    if (typeof value != "number") {
        throw new Error("setVolume: se esperaba un valor numérico como argumento en «value»");
    }

    localStorage.setItem('volume', String(value));
}

/**
 * Devuelve el volumen previamente almacenado en el navegador.
 * 
 * @returns { number }
 */
function getVolume() {
    /** @type { number } */
    const value = Number(localStorage.getItem('volume') ?? 0.5);

    return value;
}


init(url);