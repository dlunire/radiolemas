<script lang="ts">
    import IconCodigosdelFuturo from "../icons/IconCodigosdelFuturo.svelte";
    import Footer from "./Footer.svelte";
    export let dashboard: boolean = false;
    export let author: string = "David E Luna M (DLUnire)";
</script>

<div class="container">
    <slot>Agregue un contenido o componente aquí</slot>
</div>

<Footer {dashboard}>
    <div class="footer__inner" class:footer__inner--dashboard={dashboard}>
        <div class="footer__author" class:footer__author--dashboard={dashboard}>
            Desarrollado por <a
                href="https://github.com/dlunire"
                class="footer__link"
                class:footer__link--dashboard={dashboard}
                target="_blank"
            >
                <IconCodigosdelFuturo />
                <span>{author}</span>
            </a>
        </div>
    </div>
</Footer>
