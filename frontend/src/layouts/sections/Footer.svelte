<script lang="ts">
    export let dashboard: boolean = false;
    export let install: boolean = false;
    export let home: boolean = false;
</script>

<footer class="footer" class:footer--dashboard={dashboard} class:footer--install={install} class:footer--home={home}>
    <slot>Agregue su contenido o componente en el pie de página</slot>
</footer>
