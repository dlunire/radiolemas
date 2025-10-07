<script lang="ts">
    import { onMount } from "svelte";

    // your script goes here
    let windows: HTMLElement | null = null;

    onMount(() => {
        if (!(windows instanceof HTMLElement)) return;
        document.body.appendChild(windows);
    });
</script>

<section class="window-container" bind:this={windows}>
    
</section>