<script lang="ts">
    import ArrowLeft from "../../icons/ArrowLeft.svelte";
    import { request } from "../Forms/lib/request";
    import type { DataTable } from "../Tables/interfaces/DataTable";

    export let data: DataTable | undefined = undefined;
    export let action: string | undefined = undefined;

    let paginate: string = "1 de 3";

    async function requestServer(action: string | undefined): Promise<void> {
        if (!action) return;
        const newData: unknown = await request(action, {
            credentials: "include",
            method: "GET",
        });

        const dataTable: DataTable = newData as DataTable;
        data = { ...dataTable };
    }

    $: requestServer(action);
</script>

{#if data}
    <nav class="paginate">
        <div class="paginate__info">
            <span>{paginate}</span>
        </div>
        <button
            class="button button--paginate"
            aria-label="Página anterior"
            data-direction="left"
        >
            <ArrowLeft />
        </button>

        <button
            class="button button--paginate"
            aria-label="Siguiente página"
            data-direction="right"
        >
            <ArrowLeft />
        </button>
    </nav>
{/if}
