<script lang="ts">
    import TrendItemNews from "./TrendItemNews.svelte";
    import Section from "./Section.svelte";

    const classList: string[] = ["section--home", "section--news"];
</script>
<Section id="tendencies" {classList}>
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
</Section>