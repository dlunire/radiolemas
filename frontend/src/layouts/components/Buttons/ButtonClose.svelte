<script lang="ts">
    type Click = (event?: MouseEvent) => void;

    export let close: boolean = false;
    export let onclick: Click;
    export let content: Function;
</script>

<button
    class="button button--normalize"
    class:button--close={close}
    class:button--primary={!close}
    type="button"
    {onclick}
>
    {@render content()}
</button>
