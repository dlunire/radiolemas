<script lang="ts">
    import type { SvelteComponent } from "svelte";
    import { navigate } from "../../routers/sources/router";

    export let label: string = "Texto del enlace";
    export let href: string = "/";
    export let icon: typeof SvelteComponent | undefined = undefined;

    function onclick(event: MouseEvent): void {
        event.preventDefault();
        const { target: anchor } = event;
        console.log({ anchor });
        if (!(anchor instanceof HTMLAnchorElement)) return;

        const route: string | null = anchor.getAttribute("href");
        if (!route) return;
        navigate(route);
    }
</script>

<li class="menu__item">
    <a class="menu__link" {href} title={label} aria-label={label} {onclick}>
        {#if icon}
            <svelte:component this={icon} aria-hidden="true" />
        {/if}

        <span>{label}</span>
    </a>
</li>
