<script lang="ts">
    import { onMount } from "svelte";

    export let openMenu: boolean = false;
    export let mobile: boolean = false;

    // your script goes here
    let windows: HTMLElement | null = null;

    onMount(() => {
        if (!(windows instanceof HTMLElement)) return;
        document.body.appendChild(windows);
    });
</script>

{#if openMenu}
    <section class="window-container" bind:this={windows} class:window-container--mobile={true}>
        <div class="window" class:window--mobile={mobile}>
            <slot name="header"></slot>
            <slot name="container"></slot>
        </div>
    </section>
{/if}
