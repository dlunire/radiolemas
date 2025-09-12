<script lang="ts">
    import type { Type } from "../Forms/Interface/Method";

    type Click = (event: MouseEvent) => void;

    export let onclick: Click | undefined = undefined;
    export let content: Function | undefined = undefined;
    export let type: Type = "button";
</script>

<button class="button button--normalize button--primary" {type} {onclick}>
    {#if content}
        {@render content()}
    {:else}
        <span>Texto del botón</span>
    {/if}
</button>
