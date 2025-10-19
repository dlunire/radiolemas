<script lang="ts">
    import AsideNews from "./AsideNews.svelte";
    import RecentNews from "./RecentNews.svelte";
    import Section from "./Section.svelte";
</script>

<Section id="news" classList={["section--home", "section--news"]}>
    <div class="section__inner section__inner--news">
        <div class="news news--recent">
            <RecentNews />
            <AsideNews />
        </div>
    </div>
</Section>
