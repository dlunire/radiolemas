<script lang="ts">
    import IconCodigosdelFuturo from "../icons/IconCodigosdelFuturo.svelte";
    import Footer from "./Footer.svelte";
    export let dashboard: boolean = false;
    export let install: boolean = true;
    export let home: boolean = false;
    export let author: string = "David E Luna M (DLUnire)";
    export let vendor: string = "Sistemas Cúcuta";
</script>

<div class="container">
    <slot>Agregue un contenido o componente aquí</slot>
</div>

<Footer bind:dashboard bind:install bind:home>
    <slot name="footer-content"></slot>

    {#if !home}
        <div
            class="footer__inner"
            class:footer__inner--dashboard={dashboard}
            class:footer__inner--home={home}
        >
            <div
                class="footer__author"
                class:footer__author--dashboard={dashboard}
                class:footer__author--home={home}
            >
                Powered by <a
                    href="https://github.com/dlunire"
                    class="footer__link"
                    class:footer__link--dashboard={dashboard}
                    target="_blank"
                    title="{author} • {vendor}"
                >
                    <IconCodigosdelFuturo />
                    <span>{author}</span>
                    <span class="separator separator--dot">•</span>
                    <span>{vendor}</span>
                </a>
            </div>
        </div>
    {:else}
        <div class="footer__info" class:footer__info--home={home}>
            <div class="footer__author" class:footer__autor--home={home}>
                Powered by <a
                    href="https://github.com/dlunire"
                    class="footer__link"
                    class:footer__link--dashboard={dashboard}
                    target="_blank"
                    title="{author} • {vendor}"
                >
                    <IconCodigosdelFuturo />
                    <span>{author}</span>
                    <span class="separator separator--dot">•</span>
                    <span>{vendor}</span>
                </a>
            </div>
        </div>
    {/if}
</Footer>
