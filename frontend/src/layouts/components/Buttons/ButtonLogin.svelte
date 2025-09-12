<script lang="ts">
    export const onclick: Function | null = null;
    export let content: Function | undefined = undefined;
    export let loading: boolean = false;
</script>

<button
    class="button button--normalize button--login"
    type="submit"
    disabled={Boolean(loading)}
>
    {#if content}
        {@render content()}
    {:else}
        <span>Guardar registro</span>
    {/if}
</button>
