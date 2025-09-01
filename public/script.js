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
    
    audio.controls = false;
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

    const button = document.querySelector("#play");
    if (!(button instanceof HTMLButtonElement)) return;

    /** @type { boolean } */
    let play = false;

    button.addEventListener("click", async function() {
        play = !play;

        console.log({ play });
    });
}

init(url);