<script lang="ts">
    import { onMount } from "svelte";
    import { urlStream } from "../../../lib/streaming/radio";
    import IconPlay from "../../icons/IconPlay.svelte";
    import IconPause from "../../icons/IconPause.svelte";
    import IconLoading from "../../icons/IconLoading.svelte";

    export let audio: HTMLAudioElement | undefined = undefined;
    export let paused: boolean = true;
    export let playing: boolean = false;

    let openLoading: boolean = false;
    let error: boolean = false;
    let timer: number | null = null;

    function onclick(event: MouseEvent): void {
        if (!(audio instanceof HTMLAudioElement)) return;

        openLoading = true;
        paused = audio.paused;
        paused ? audio.play() : audio.pause();
    }

    /**
     * Crea el elemento audio si no existe
     *
     * @param audio Elemento audio a evaluar, en el caso de que lo sea.
     */
    function createAudioIfNotExist(): void {
        if (audio instanceof HTMLAudioElement) return;

        audio = document.createElement("audio");
        audio.src = urlStream;

        /**
         * Se dispara si se produce un error
         *
         * @param event Evento
         */
        audio.addEventListener("error", function (event: ErrorEvent) {
            openLoading = false;
            error = true;

            if (timer) {
                clearTimeout(timer);
            }

            timer = setTimeout(() => {
                error = false;
            }, 3000);
        });
    }

    onMount(() => {
        createAudioIfNotExist();
    });

    $: if (audio instanceof HTMLAudioElement && !audio.paused) {
        openLoading = false;
    }
</script>

<div class="live">
    <button class="button button--live" aria-label="Play" {onclick} class:error disabled={openLoading}>
        <IconPlay bind:hidden={playing} />
        <IconPause bind:hidden={paused} />

        <IconLoading color="black" size={24} bind:open={openLoading} />
    </button>

    <h2 class="live__title">Señal en vivo</h2>
</div>

<style>
    .error {
        --icon-color: red;
    }
</style>
