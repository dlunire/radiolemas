<script lang="ts">
    import IconFolder from "../../icons/IconFolder.svelte";
    import IconMenuItem from "../../icons/IconMenuItem.svelte";
</script>

<div class="links" id="links">
    <h3 class="links__title" aria-label="Enlaces externos">
        <IconMenuItem />
        <span>Enlaces externos</span>
    </h3>

    <menu class="link link--footer">
        <li class="link__item link__item--footer">
            <a
                href="#link"
                aria-label="Enlace 1"
                class="link__link link__link--footer"
            >
                <IconFolder />
                <span>Recurso del primer enlace</span>
            </a>
        </li>
        <li class="link__item link__item--footer">
            <a
                href="#link"
                aria-label="Enlace 2"
                class="link__link link__link--footer"
            >
                <IconFolder />
                <span>Músicas y vídeos</span>
            </a>
        </li>
        <li class="link__item link__item--footer">
            <a
                href="#link"
                aria-label="Enlace 3"
                class="link__link link__link--footer"
            >
                <IconFolder />
                <span>Programas de radio</span>
            </a>
        </li>
        <li class="link__item link__item--footer">
            <a
                href="#link"
                aria-label="Enlace 4"
                class="link__link link__link--footer"
            >
                <IconFolder />
                <span>Legal</span>
            </a>
        </li>
        <li class="link__item link__item--footer">
            <a
                href="#link"
                aria-label="Enlace 5"
                class="link__link link__link--footer"
            >
                <IconFolder />
                <span>Política de tratamiento de datos</span>
            </a>
        </li>
    </menu>
</div>
