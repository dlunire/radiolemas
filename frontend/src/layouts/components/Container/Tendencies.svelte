<script>
    import TrendItemNews from "./TrendItemNews.svelte";

</script>
<section class="section section--home section--news" id="tendencies">
    <div class="section__inner section__inner--article">
        <h2 class="section__title section__title--news" aria-label="Recientes">
            Noticias en tendencias
        </h2>

        <div class="tendencies">
            <section class="trend">
                <TrendItemNews />
                <TrendItemNews />
                <TrendItemNews />
                <TrendItemNews />
            </section>
        </div>
    </div>
</section>