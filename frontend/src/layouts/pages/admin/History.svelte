<script lang="ts">
    import Icon from "../../components/Graphics/Icon.svelte";
    import IconTime from "../../icons/IconTime.svelte";

    let show: boolean = true;
</script>

<section class="content">
    {#if !show}
        <h2 class="content__title">
            <span>Histórico de cargas</span>
        </h2>
    {/if}

    <Icon bind:show title="Histórico de cargas">
        {#snippet content()}
            <IconTime />
        {/snippet}
    </Icon>
</section>
