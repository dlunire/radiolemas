<script lang="ts">
    import { onDestroy, onMount } from "svelte";
    import { buttonsExists } from "../../../lib/store/store";
    import IconCertificate from "../../icons/IconCertificate.svelte";
    import IconUpload from "../../icons/IconUpload.svelte";

    onMount(() => {
        buttonsExists.set(true);
    });

    onDestroy(() => {
        buttonsExists.set(false);
    });
</script>

<nav class="nav">
    <button
        class="button button--nav"
        aria-label="Agregar archivo CSV"
        title="Agregar archivo CSV"
    >
        <IconUpload />
        <span>Agregar certificado</span>
    </button>
    <button
        class="button button--nav"
        aria-label="Editar registro"
        title="Editar registro"
    >
        <IconCertificate />
        <span>Revisar certificados</span>
    </button>
</nav>
