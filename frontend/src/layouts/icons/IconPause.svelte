<script lang="ts">
    export let hidden: boolean = false;
</script>

<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class:hidden
    ><path d="M11 7H8v10h3V7zM13 17h3V7h-3v10z" /></svg
>

<style>
    svg {
        min-width: var(--icon-width);
        min-height: var(--icon-height);
        max-width: var(--icon-width);
        max-height: var(--icon-height);
        transition: 300ms ease;

        transform: scale(1.7);
    }

    path {
        fill: var(--icon-color);
    }
</style>
