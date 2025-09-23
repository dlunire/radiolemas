<script lang="ts">
    export let dashboard: boolean = false;
    export let home: boolean = false;
    export const content: Function | undefined = undefined;
</script>

<header
    class="header"
    class:header--dashboard={dashboard}
    class:header--home={home}
>
    <div
        class="header__inner"
        class:header__inner--dashboard={dashboard}
        class:header__inner--home={home}
    >
        <slot>Agregue su componente aqui</slot>
    </div>
    
    <slot name="nav"></slot>
</header>
