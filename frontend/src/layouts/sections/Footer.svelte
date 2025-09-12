<script lang="ts">
    export let dashboard: boolean = false;
</script>

<footer class="footer" class:footer--dashboard={dashboard}>
    <slot>Agregue su contenido o componente en el pie de página</slot>
</footer>
