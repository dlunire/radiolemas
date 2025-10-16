<script lang="ts">
    import IconNews from "../../icons/IconNews.svelte";
    import IconRadioLemasDark from "../../icons/IconRadioLemasDark.svelte";
    import IconStation from "../../icons/IconStation.svelte";
</script>

<section class="container__hero">
    <picture>
        <!-- Imagen para pantallas pequeñas -->
        <source srcset="./hero-mobile.png" media="(max-width: 500px)" />

        <!-- Imagen por defecto (pantallas grandes) -->
        <source srcset="./hero.png" />

        <!-- Fallback para navegadores antiguos -->
        <img src="./hero.png" alt="Imagen de cabecera" />
    </picture>

    <div class="container__hero-info">
        <div class="container__hero-column container__hero-column--left">
            <IconRadioLemasDark />
        </div>

        <div class="container__hero-column container__hero-column--right">
            <button class="button button--hero button--online">
                <IconStation />
                <span>Escuchar en Vivo</span>
            </button>

            <button class="button button--hero button--news">
                <IconNews />
                <span>Noticias</span>
            </button>
        </div>
    </div>
</section>
