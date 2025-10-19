<script lang="ts">
    import IconRadioLemasDark from "../../icons/IconRadioLemasDark.svelte";
    import ContainerNav from "./ContainerNav.svelte";

    let lema: string = "La voz que conecta contigo";
</script>
<section class="online">
    <header class="online__header">
        <ContainerNav lema="La Poderosa" />
    </header>

    <div class="online__content">
        <IconRadioLemasDark />
        <h2 class="online__title" aria-label="{lema}">{lema}</h2>
    </div>

    <footer class="online__footer">
        <div class="online__play"></div>
    </footer>
</section>