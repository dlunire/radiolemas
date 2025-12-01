<script lang="ts">
    import { onMount } from "svelte";
    import IconClose from "../../icons/IconClose.svelte";

    export let content: Function | undefined = undefined;
    export let time: number = 7000;
    export let open: boolean = false;
    export let error: boolean = false;
    export let success: boolean = false;
    export let warning: boolean = false;
    export let info: boolean = false;
    export let closeButton: boolean = true;
    export let add: boolean = true;

    let notification: HTMLElement | null = null;
    let timeout: number | null = null;

    $: if (open) {
        if (timeout) clearTimeout(timeout);

        timeout = setTimeout(() => {
            reset();
        }, time);
    }

    /**
     * Cierra la notificación
     */
    function onclick() {
        reset();
        if (timeout) {
            clearTimeout(timeout);
        }
    }

    /**
     * Reinicia el mensaje
     */
    function reset(): void {
        if (add) {
            add = !success;
        }

        error = false;
        warning = false;
        success = false;
        info = false;
        open = false;
    }

    function update(element: HTMLElement | null = null): void {
        if (!(element instanceof HTMLElement)) return;
        document.body.appendChild(element);
    }

    $: update(notification);
</script>

{#if open}
    <section
        class="notification notification--file scrollable"
        bind:this={notification}
    >
        <div
            class="notification__inner"
            class:notification__inner--info={info}
            class:notification__inner--success={success}
            class:notification__inner--error={error}
            class:notification__inner--warning={warning}
        >
            <div class="notification__content">
                {#if content}
                    {@render content()}
                {:else}
                    <span
                        >Lorem ipsum dolor sit amet consectetur adipisicing
                        elit. Aliquam, error!</span
                    >
                {/if}
            </div>
            {#if closeButton}
                <footer class="notification__footer">
                    <button class="button button--dialog-close" {onclick}>
                        <IconClose />
                        <span>Aceptar</span>
                    </button>
                </footer>
            {/if}
        </div>
    </section>
{/if}
