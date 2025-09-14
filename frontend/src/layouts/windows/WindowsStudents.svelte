<script lang="ts">
    import { onDestroy, onMount } from "svelte";
    import Table from "../components/Tables/Table.svelte";
    import type { DataTable } from "../components/Tables/interfaces/DataTable";
    import { openStudents } from "./store/windows";
    import IconClose from "../icons/IconClose.svelte";
    import Upload from "../components/Forms/Upload.svelte";
    import Icon from "../components/Graphics/Icon.svelte";
    import IconFiles from "../icons/IconFiles.svelte";
    import WindowsControls from "../components/Nav/WindowsControls.svelte";

    export let data: DataTable = { columns: {}, records: [] };
    export let title: string = "Cargar archivos";

    let open: boolean = false;
    let element: HTMLElement | null = null;
    let add: boolean = true;
    let success: boolean = false;

    onMount(() => {
        if (!(element instanceof HTMLElement)) return;
        document.body.appendChild(element);
    });

    function onclick(event: MouseEvent): void {
        const { target: button } = event;
        if (!(button instanceof HTMLButtonElement)) return;
        openStudents.set(false);
    }

    const unsubscribe = openStudents.subscribe((value) => {
        open = value;
    });

    onDestroy(() => {
        unsubscribe();
    });

    addEventListener("keydown", function (event: KeyboardEvent) {
        const { key } = event;

        if (key == "Escape") {
            event.preventDefault();
            openStudents.update(() => false);
        }
    });
</script>

{#if open}
    <div class="windows" data-open="" bind:this={element}>
        <header class="windows__header">
            <span>{title}</span>

            <WindowsControls bind:add />
            <button class="button button--windows-close" {onclick}>
                <IconClose />
            </button>
        </header>
        <section class="windows__content">
            {#if add}
                <Upload action="/dashboard/upload" bind:success bind:add />
            {:else}
                <div class="windows__table">
                    <Table bind:data showControls={false} />

                    <Icon
                        hidden={data.records.length > 0}
                        title="Cargue un archivo CSV"
                    >
                        {#snippet content()}
                            <IconFiles />
                        {/snippet}
                    </Icon>
                </div>
            {/if}
        </section>
    </div>
{/if}
