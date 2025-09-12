<script lang="ts">
    import Router from "../../routers/components/Router.svelte";
    export let dashboard: boolean = false;
</script>

<div
    class="section__column section__column--content"
    class:section__column--dashboard={dashboard}
>
    <Router />
</div>
