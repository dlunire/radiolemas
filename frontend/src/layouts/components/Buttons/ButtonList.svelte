<script lang="ts">
    import { zIndexReverse } from "../../../lib/zIndex";
    import ArrowLeft from "../../icons/ArrowLeft.svelte";
    import type { ButtonList } from "./Interfaces/ButtonType";

    export let list: ButtonList[] = [
        {
            label: "Producción",
            value: "true",
        },
        { label: "Entorno de desarrollo", value: "false" },
    ];

    export let label: string = "Seleccione...";
    export let name: string = "environment";
    export let required: boolean = false;

    let value: string = "";
    let menuHeight: number = 0;
    let open: boolean = false;

    /**
     * Captura el evento click del botón
     *
     * @param event Evento del Mouse.
     */
    function onclick(event: MouseEvent): void {
        const { target: button } = event;
        if (!(button instanceof HTMLButtonElement)) return;

        const { item: newValue } = button.dataset;

        if (!newValue) {
            open = !open;
            menuHeight = getHeight(button);
            return;
        }

        label = String(button.textContent);
        value = newValue;
        open = false;
    }

    addEventListener("click", function (event: MouseEvent) {
        const { target: element } = event;
        if (
            element instanceof HTMLButtonElement &&
            element.dataset.name == name
        ) {
            return;
        }

        open = false;
    });

    /**
     * Devuelve la altura total de la lisa
     *
     * @returns
     */
    function getHeight(button: HTMLButtonElement): number {
        if (!(button instanceof HTMLButtonElement)) {
            throw new Error(
                "Se esperaba un elementl «HTMLButtonElement» como argumento",
            );
        }

        const container: HTMLElement | null = button.closest(".list");
        if (!(container instanceof HTMLElement)) return 0;

        const nodes: NodeListOf<HTMLElement> =
            container.querySelectorAll("[data-list-item]");

        let height: number = 0;

        for (const element of nodes) {
            if (!(element instanceof HTMLButtonElement)) continue;
            const size: DOMRect = element.getBoundingClientRect();
            height += size.height;
        }

        return height + 10;
    }

    function onmousedown(event: MouseEvent): void {
        const { target: button } = event;
        if (!(button instanceof HTMLButtonElement)) return;

        const form: HTMLFormElement | null = button.closest("form");
        if (!(form instanceof HTMLFormElement)) return;
        zIndexReverse(form);
    }
</script>

<div class="list" role="list" data-list="">
    <button
        class="button button--list"
        data-open={String(open)}
        aria-label="Entorno de Ejecución"
        type="button"
        {onclick}
        {onmousedown}
        data-name={name}
        title={label}
    >
        <span>{label}</span>
        <ArrowLeft />
    </button>

    <ul
        class="list__box"
        role="listbox"
        data-open={String(open)}
        style="--menu-height: {menuHeight}px; --padding: 5px"
    >
        {#each list as item}
            <li class="list__item">
                <button
                    type="button"
                    class="button button--item"
                    data-item={item.value}
                    {onclick}
                    data-list-item=""
                    title={item.label}
                >
                    <span>{item.label}</span>
                </button>
            </li>
        {/each}
    </ul>
</div>

<input type="hidden" {name} {value} {required} aria-required={required} />

<style>
    .list {
        --icon-size: 20px;
        --icon-color: white;
        --icon-width: var(--icon-size);
        --icon-height: var(--icon-size);
    }
</style>
