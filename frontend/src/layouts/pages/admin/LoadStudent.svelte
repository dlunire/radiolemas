<script lang="ts">
    import Icon from "../../components/Graphics/Icon.svelte";
    import IconCertificate from "../../icons/IconCertificate.svelte";

    let show: boolean = true;
</script>

<section class="content">
    <Icon bind:show title="Certificados">
        {#snippet content()}
            <IconCertificate />
        {/snippet}
    </Icon>
</section>
