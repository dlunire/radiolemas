<script lang="ts">
    export let dashboard: boolean = false;
</script>

<header class="header" class:header--dashboard={dashboard}>
    <div class="header__inner" class:header__inner--dashboard={dashboard}>
        <slot>Agregue su componente aqui</slot>
    </div>
</header>
