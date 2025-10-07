<script lang="ts">
    // your script goes here
    export let openMenu: boolean = false;

    function onclick(event: MouseEvent): void {
        openMenu = !openMenu;
    }

    $: label = openMenu ? "Cerrar" : "Menú";
</script>

<nav class="mobile">
    <button
        class="button button--menu"
        aria-label="Menu"
        {onclick}
        class:button--menu-open={!openMenu}
        class:button--menu-close={openMenu}
    >
        <span></span>
        <span></span>
        <span></span>

        <span class="label">{label}</span>
    </button>
</nav>
