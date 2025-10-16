<script lang="ts">
    import { onMount } from "svelte";

    export let openMenu: boolean = false;

    let nav: HTMLElement | null = null;
    let main: HTMLElement | null = null;

    onMount(() => {
        if (!(nav instanceof HTMLElement)) return;

        main = nav.closest("main");
        if (!(main instanceof HTMLElement)) return;

        main.classList.remove("overflow-hidden");
        document.body.classList.remove("overflow-hidden");
    });

    function onclick(event: MouseEvent): void {
        openMenu = !openMenu;
    }

    let label: string = "Menú";

    function windowsMenu(openMenu: boolean): void {
        if (!(main instanceof HTMLElement)) return;

        main.classList.toggle("overflow-hidden", openMenu);
        document.body.classList.toggle("overflow-hidden", openMenu);
    }

    $: windowsMenu(openMenu);
</script>

<nav class="mobile" bind:this={nav}>
    <button
        class="button button--menu"
        aria-label="Menu"
        {onclick}
        class:button--menu-open={openMenu}
        class:button--menu-close={!openMenu}
    >
        <span></span>
        <span></span>
        <span></span>

        <span class="label">{label}</span>
    </button>
</nav>
