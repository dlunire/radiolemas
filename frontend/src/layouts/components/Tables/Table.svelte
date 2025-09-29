<script lang="ts">
    import { onMount } from "svelte";
    import unknown from "./data.json";
    import type {
        DataTable,
        Direction,
        Register,
    } from "./interfaces/DataTable";
    import IconSearchRegister from "../../icons/IconSearchRegister.svelte";
    import Paginate from "../Paginate/Paginate.svelte";
    import ArrowLeft from "../../icons/ArrowLeft.svelte";

    export let show: boolean = false;
    export let action: string | undefined = undefined;
    export let title: string = "Lista de estudiantes";
    export let showNumber: boolean = true;
    export let content: Function | undefined = undefined;
    export let showControls: boolean = true;
    export let relative: boolean = false;

    export let data: DataTable = unknown as DataTable;

    onMount(() => {
        if (!data) return;
        const { length } = data.records;
        show = length > 0;

        const records: Register[] = data.records.map((value: Register) => {
            return value;
        });

        data.records = [...records];
    });

    async function onsubmit(event: SubmitEvent): Promise<void> {
        event.preventDefault();
    }

    function handleOrder(event: MouseEvent): void {
        const { target: button } = event;
        if (!(button instanceof HTMLButtonElement)) return;

        const thead: HTMLTableSectionElement | null = button.closest("thead");
        if (!(thead instanceof HTMLTableSectionElement)) return;

        const otherButtons: NodeListOf<HTMLButtonElement> =
            thead.querySelectorAll("[data-direction]");

        for (const currentButton of otherButtons) {
            if (!(currentButton instanceof HTMLButtonElement)) continue;
            const { index: currentIndex } = currentButton.dataset;
            const { index } = button.dataset;
            if (index == currentIndex) continue;

            currentButton.removeAttribute("data-direction");
        }

        const { direction } = button.dataset;
        button.dataset.direction = direction === "asc" ? "desc" : "asc";

        const { key } = button.dataset;
        if (!key) return;
        orderRegister(key, (direction as Direction) ?? "desc");
        console.log({ key });
    }

    function orderRegister(
        key: keyof Register,
        direction: "asc" | "desc",
    ): void {
        data.records = [...data.records].sort((a: Register, b: Register) => {
            const valueA = a[key];
            const valueB = b[key];

            // Manejo de nulls y undefined
            if (valueA == null && valueB != null)
                return direction === "asc" ? 1 : -1;
            if (valueA != null && valueB == null)
                return direction === "asc" ? -1 : 1;
            if (valueA == null && valueB == null) return 0;

            // Comparación de strings y números
            if (typeof valueA === "string" && typeof valueB === "string") {
                return direction === "asc"
                    ? valueA.localeCompare(valueB)
                    : valueB.localeCompare(valueA);
            }

            if (typeof valueA === "number" && typeof valueB === "number") {
                return direction === "asc" ? valueA - valueB : valueB - valueA;
            }

            // Comparación de booleanos
            if (typeof valueA === "boolean" && typeof valueB === "boolean") {
                return direction === "asc"
                    ? Number(valueA) - Number(valueB)
                    : Number(valueB) - Number(valueA);
            }

            // Si son de tipo mixto, conviértelos a string
            return direction === "asc"
                ? String(valueA).localeCompare(String(valueB))
                : String(valueB).localeCompare(String(valueA));
        });
    }
</script>

{#if show}
    <div class="table-container" class:relative>
        {#if showControls}
            <header class="table-container__header">
                <h2 class="table-container__title">
                    {#if content}
                        {@render content()}
                    {/if}
                    <span>{title}</span>
                </h2>

                <div class="table-container__controls">
                    <div class="table-container__buttons">
                        <form {action} class="form form--search" {onsubmit}>
                            <div class="form__search">
                                <input
                                    type="search"
                                    name="query"
                                    id="query"
                                    placeholder="Criterio de búsqueda"
                                    class="form__input form__input--query"
                                    autocomplete="off"
                                />
                                <button class="button button--query">
                                    <IconSearchRegister />
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </header>
        {/if}

        <div class="table-container__container" class:relative>
            <div class="table-container__content" class:relative>
                <table class="table">
                    <colgroup>
                        {#if showNumber}
                            <col />
                        {/if}
                        {#each Object.entries(data.columns) as [key, label]}
                            <col />
                        {/each}
                    </colgroup>

                    <thead class="fixed fixed--panel">
                        <tr>
                            {#if showNumber}
                                <th class="fixed fixed--column">
                                    <span>Nº</span>
                                </th>
                            {/if}
                            {#each Object.entries(data.columns) as [key, label], index}
                                <th data-key={key}>
                                    <button
                                        class="button button--table-header"
                                        onclick={handleOrder}
                                        data-index={index}
                                        data-key={key}
                                    >
                                        <span>{label}</span>
                                        <ArrowLeft />
                                        <ArrowLeft />
                                    </button>
                                </th>
                            {/each}
                        </tr>
                    </thead>

                    <tbody>
                        {#each data.records as record, index}
                            <tr>
                                {#if showNumber}
                                    <td class="center fixed fixed--column"
                                        ><span>{index + 1}</span></td
                                    >
                                {/if}
                                {#each Object.keys(data.columns) as item}
                                    <td>
                                        <button
                                            class="button button--table"
                                            aria-label={String(
                                                record[item as keyof Register],
                                            )}
                                        >
                                            {record[item as keyof Register]}
                                        </button>
                                    </td>
                                {/each}
                            </tr>
                        {/each}
                    </tbody>
                </table>
            </div>
        </div>

        <footer class="table-container__footer">
            <div class="table-container__info"></div>
            <div class="table-container__info">
                <Paginate bind:data />
            </div>
        </footer>
    </div>
{/if}


<style>
    .relative {
        position: relative;
        overflow-x: auto;
    }
</style>