<script lang="ts">
    import { type SvelteComponent } from "svelte";
    import { currentRoute } from "../sources/router";
    import NotFound from "../../pages/NotFound.svelte";
    import { routes } from "../routes";

    // Componente y parámetros que se actualizarán automáticamente cuando cambie la ruta
    let Page: typeof SvelteComponent = NotFound as typeof SvelteComponent;
    let params: Record<string, string> = {};

    // Reacción automática a los cambios de ruta
    $: {
        const path = $currentRoute;
        let matched = false;

        for (const r of routes) {
            const match = r.pattern.exec(path);
            if (match) {
                Page = r.component;
                params = r.extractParams(match);
                matched = true;
                break;
            }
        }

        if (!matched) {
            Page = NotFound as typeof SvelteComponent;
            params = {};
        }
    }
</script>

<!-- El uso de {#key} fuerza el desmontaje completo del componente anterior -->
{#key $currentRoute}
    <svelte:component this={Page} {...params} />
{/key}
