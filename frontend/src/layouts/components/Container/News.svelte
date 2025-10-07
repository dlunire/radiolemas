<script lang="ts">
    import { onMount } from "svelte";
    import AsideNews from "./AsideNews.svelte";
    import RecentNews from "./RecentNews.svelte";

    let section: HTMLElement | null = null;

    onMount(() => {
        if (!(section instanceof HTMLElement)) return;
        if (location.hash != "#news") return;

        section.scrollIntoView({
            behavior: "smooth",
        });
    });
</script>

<section class="section section--home section--news" id="news" bind:this={section}>
    <div class="section__inner section__inner--news">
        <div class="news news--recent">
            <RecentNews />
            <AsideNews />
        </div>
    </div>
</section>
