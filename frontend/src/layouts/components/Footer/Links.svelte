<script lang="ts">
    import IconMenuItem from "../../icons/IconMenuItem.svelte";
</script>

<div class="links" id="links">
    <h3 class="links__title" aria-label="Enlaces externos">
        <IconMenuItem />
        <span>Enlaces externos</span>
    </h3>

    <menu class="link link--footer">
        <li class="link__item link__item--footer">
            <a href="#link" aria-label="Enlace 1" class="link__link link__link--footer"
                >Enlace 1</a
            >
        </li>
        <li class="link__item link__item--footer">
            <a href="#link" aria-label="Enlace 2" class="link__link link__link--footer"
                >Enlace 2</a
            >
        </li>
        <li class="link__item link__item--footer">
            <a href="#link" aria-label="Enlace 3" class="link__link link__link--footer"
                >Enlace 3</a
            >
        </li>
        <li class="link__item link__item--footer">
            <a href="#link" aria-label="Enlace 4" class="link__link link__link--footer"
                >Enlace 4</a
            >
        </li>
        <li class="link__item link__item--footer">
            <a href="#link" aria-label="Enlace 5" class="link__link link__link--footer"
                >Enlace 5</a
            >
        </li>
    </menu>
</div>
