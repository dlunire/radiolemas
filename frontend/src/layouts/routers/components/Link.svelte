<!-- lib/router/Link.svelte -->
<script lang="ts">
    import { navigate } from "../sources/router";

    export let href: string;
    export let title: string = "";
    export let target: string = "_top";
    export let ariaLabel: string = "";

    function handle(event: MouseEvent) {
        const { target: anchor } = event;
        if (!(anchor instanceof HTMLAnchorElement)) return;

        event.preventDefault();
        navigate(href);
    }
</script>

<a {href} on:click={handle} {title} {target} aria-label={ariaLabel}>
    <slot />
</a>
