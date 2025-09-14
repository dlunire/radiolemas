<script lang="ts">
    import { onDestroy, onMount } from "svelte";
    import { buttonsExists } from "../../../lib/store/store";
    import IconRegister from "../../icons/IconRegister.svelte";
    import IconUpload from "../../icons/IconUpload.svelte";
    import { openStudents } from "../../windows/store/windows";

    onMount(() => {
        buttonsExists.set(true);
    });

    onDestroy(() => {
        buttonsExists.set(false);
    });

    function onclick(event: MouseEvent): void {
        const { target: button } = event;
        if (!(button instanceof HTMLButtonElement)) return;
        openStudents.update(() => true);
    }
</script>

<nav class="nav">
    <button
        class="button button--nav"
        aria-label="Agregar archivo CSV"
        title="Agregar archivo CSV"
        {onclick}
    >
        <IconUpload />
        <span>Noticias</span>
    </button>
    <button
        class="button button--nav"
        aria-label="Editar registro"
        title="Editar registro"
    >
        <IconRegister />
        <span>Editar registro</span>
    </button>
</nav>
