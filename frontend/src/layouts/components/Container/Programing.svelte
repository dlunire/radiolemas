<script lang="ts">
    import { onMount } from "svelte";
    import Table from "../Tables/Table.svelte";
    import Section from "./Section.svelte";

    const classList: string[] = ["section--home", "section--news"];
</script>

<Section {classList} id="programming">
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
</Section>
