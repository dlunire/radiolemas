<script lang="ts">
    import Icon from "../../components/Graphics/Icon.svelte";
    import IconProfile from "../../icons/IconProfile.svelte";

    let show: boolean = false;
</script>

<section class="content">
    <Icon bind:hidden={show} title="Mi perfil de usuario">
        {#snippet content()}
            <IconProfile />
        {/snippet}
    </Icon>
</section>
