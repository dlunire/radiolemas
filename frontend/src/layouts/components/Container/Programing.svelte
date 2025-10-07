<script lang="ts">
    import { onMount } from "svelte";
    import Table from "../Tables/Table.svelte";

    let section: HTMLElement | null = null;

    onMount(() => {
        if (!(section instanceof HTMLElement)) return;
        if (location.hash != "#about") return;

        section.scrollIntoView({
            behavior: "smooth",
        });
    });
</script>

<section
    class="section section--home section--news"
    id="programming"
    bind:this={section}
>
    <div class="section__inner section__inner--article">
        <h2
            class="section__title section__title--news"
            aria-label="Programación"
        >
            Programación
        </h2>

        <div class="programming">
            <Table showControls={false} />
        </div>
    </div>
</section>
