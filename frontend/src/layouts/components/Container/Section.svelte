<script lang="ts">
    import { onDestroy, onMount } from "svelte";

    export let id: string = "section";
    export let classList: string[] = [];

    let section: HTMLElement | null = null;
    let currentSection: string = "";
    let observer: IntersectionObserver | undefined = undefined;

    onMount(() => {
        if (!(section instanceof HTMLElement)) return;
        const tokens: string[] = classList.filter((token) => {
            return !section?.classList.contains(token) && token.length > 0;
        });
        
        section.classList.add(...tokens);

        if (location.hash == `#${id}`) {
            section.scrollIntoView({
                behavior: "smooth",
            });
        }

        observer = new IntersectionObserver(
            (entries) => {
                for (const entry of entries) {
                    if (entry.isIntersecting) {
                        currentSection = entry.target.id; // o dataset.section
                        history.replaceState(null, "", `#${currentSection}`);
                    }
                }
            },
            { threshold: 0.5 },
        );

        observer.observe(section);
    });

    onDestroy(() => {
        if (!observer) return;
        observer.disconnect();
    });
</script>

<section class="section" {id} bind:this={section}>
    <slot>Agregue contenido a la sección</slot>
</section>
