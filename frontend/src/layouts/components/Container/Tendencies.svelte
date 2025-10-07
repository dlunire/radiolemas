<script lang="ts">
    import { onMount } from "svelte";
    import TrendItemNews from "./TrendItemNews.svelte";

    let section: HTMLElement | null = null;

    onMount(() => {
        if (!(section instanceof HTMLElement)) return;
        if (location.hash != "#tendencies") return;
        
        section.scrollIntoView({
            behavior: "smooth",
        });
    });
</script>
<section class="section section--home section--news" id="tendencies" bind:this={section}>
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