<script lang="ts">
    export let openMenu: boolean = false;
    let value: string = "auto";

    function onclick(event: MouseEvent): void {
        openMenu = !openMenu;
        value = openMenu ? "hidden": "auto";

        const { target: button } = event;
        if (!(button instanceof HTMLButtonElement)) return;

        const main: HTMLElement | null = button.closest("main");
        if (!(main instanceof HTMLElement)) return;

        main.style.setProperty("overflow", value);
    }

    let label: string = "Menú";

    $: {    
        label = openMenu ? "Cerrar" : "Menú";
        document.body.style.setProperty("overflow", value);
    }
</script>

<nav class="mobile">
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
