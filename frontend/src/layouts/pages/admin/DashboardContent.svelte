<script lang="ts">
    import Icon from "../../components/Graphics/Icon.svelte";
    import type { DataTable } from "../../components/Tables/interfaces/DataTable";
    import Table from "../../components/Tables/Table.svelte";
    import IconStudents from "../../icons/IconStudents.svelte";
    import WindowsStudents from "../../windows/WindowsStudents.svelte";

    let show: boolean = true;
    let data: DataTable;
</script>

<section class="content">
    <Icon title="Estudiantes" bind:hidden={show}>
        {#snippet content()}
            <IconStudents />
        {/snippet}
    </Icon>

    {#if show}
        <Table bind:show action="/v1/dashboard/query" bind:data>
            {#snippet content()}
                <IconStudents />
            {/snippet}
        </Table>
    {/if}
</section>

<WindowsStudents bind:data />
