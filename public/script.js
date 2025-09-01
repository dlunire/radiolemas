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
    audio.volume = 0.5;
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

    /** @type { HTMLSpanElement | null } */
    const label = document.querySelector("#volume-label span");
    if (!(label instanceof HTMLSpanElement)) return;

    button.addEventListener("click", function() {
        play = !play;
        play ? audio.play() : audio.pause();

        iconPlay.dataset.hidden = String(play);
        iconPause.dataset.hidden = String(!play);
    });

    volume.addEventListener('input', function() {
        /** @type { number } */
        const value = Number(this.value.trim());

        if (Number.isNaN(value)) return;
        audio.volume = value;

        label.textContent = value * 100;
    });
}


init(url);