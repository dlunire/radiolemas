<script lang="ts">
    import { type SvelteComponent } from "svelte";
    import { currentRoute } from "../sources/router";
    import { routes } from "../routes";

    let Header: typeof SvelteComponent | null = null;
    let params: Record<string, string> = {};

    $: {
        const path = $currentRoute;
        Header = null;
        params = {};

        for (const r of routes) {
            const match = r.pattern.exec(path);
            if (match && r.headerComponent) {
                Header = r.headerComponent;
                params = r.extractParams(match);
                break;
            }
        }
    }
</script>

{#if Header}
    {#key $currentRoute}
        <svelte:component this={Header} {...params} />
    {/key}
{/if}
