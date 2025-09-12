<script lang="ts">
    import Icon from "../../components/Graphics/Icon.svelte";
    import IconSearchRegister from "../../icons/IconSearchRegister.svelte";

    let show: boolean = false;
</script>

<section class="content">
    <Icon bind:hidden={show} title="Buscador de registro">
        {#snippet content()}
            <IconSearchRegister />
        {/snippet}
    </Icon>
</section>
