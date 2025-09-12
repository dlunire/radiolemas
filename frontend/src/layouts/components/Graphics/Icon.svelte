<script lang="ts">
    import { onMount } from "svelte";

    export let hidden: boolean = false;
    export let title: string = "Estudiantes";
    export let content: Function | undefined = undefined;
    export let relative: boolean = false;
    onMount(() => {
        title = title.toUpperCase();
    });
</script>

{#if content}
    <div class="icon-graphic" class:relative>
        <div class="icon-graphic__inner">
            <div class="icon-graphic__icon">
                {@render content()}
            </div>
            {#if !hidden}
                <h2
                    class="icon-graphic__title"
                    class:relative__title={relative}
                >
                    {@render content()}
                    <span>{title}</span>
                </h2>
            {/if}
        </div>
    </div>
{/if}

<style lang="scss">
    .relative {
        position: relative;

        &__title {
            font: {
                size: 1.5rem;
            }
        }
    }
</style>
