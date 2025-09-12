<script lang="ts">
    import IconClose from "../icons/IconClose.svelte";

    export let title: string = "Título de la ventana";
    export let open: boolean = false;
    export let content: Function | null = null;
    export let contentHeader: Function | null = null;

    addEventListener("keydown", function (event: KeyboardEvent) {
        const { key } = event;
        if (key != "Escape") return;
        open = false;
    });

    function onclick(): void {
        open = false;
    }

    function scrolling(scrollbar: boolean = true): void {
        const main: HTMLElement | null = document.querySelector("main");
        if (!(main instanceof HTMLElement)) return;

        main.style.setProperty("overflow", !scrollbar ? "hidden" : "auto");
    }

    $: scrolling(!open);
</script>

{#if open}
    <section class="modal-container" role="dialog" data-open="true">
        <header class="modal-container__header deploy-down">
            <h3 class="modal-container__title">
                {#if contentHeader}
                    {@render contentHeader()}
                {/if}
                <span>{title}</span>
            </h3>
            <button
                class="button button--windows-close"
                aria-label="Cerrar"
                {onclick}
            >
                <IconClose />
            </button>
        </header>

        <div class="modal-container__content">
            <section class="modal fade-in">
                <div class="modal__content">
                    {#if content}
                        {@render content()}
                    {/if}
                </div>
            </section>
        </div>
    </section>
{/if}
