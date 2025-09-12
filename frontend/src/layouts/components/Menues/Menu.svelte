<script lang="ts">
    import type { SvelteComponent } from "svelte";
    import MenuItem from "./MenuItem.svelte";
    import IconCsv from "../../icons/IconCSV.svelte";
    import IconTime from "../../icons/IconTime.svelte";
    import IconSearchRegister from "../../icons/IconSearchRegister.svelte";
    import IconCertificate from "../../icons/IconCertificate.svelte";

    let iconCSV: typeof SvelteComponent = IconCsv as typeof SvelteComponent;

    let iconTime: typeof SvelteComponent = IconTime as typeof SvelteComponent;
    let iconSearchRegister: typeof SvelteComponent =
        IconSearchRegister as typeof SvelteComponent;

    let iconCertificate: typeof SvelteComponent =
        IconCertificate as typeof SvelteComponent;
</script>

<ul class="menu">
    <MenuItem href="/dashboard" label="Estudiantes" icon={iconCSV} />
    <MenuItem
        href="/dashboard/certificate"
        label="Certificados"
        icon={iconCertificate}
    />
    <MenuItem
        href="/dashboard/history"
        label="Historial de carga"
        icon={iconTime}
    />
    <MenuItem
        href="/dashboard/register"
        label="Buscador de registro"
        icon={iconSearchRegister}
    />
</ul>
