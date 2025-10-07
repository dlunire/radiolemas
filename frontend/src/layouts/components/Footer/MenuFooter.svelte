<script lang="ts">
    import Link from "../../routers/components/Link.svelte";
</script>

<div class="grow">
    <h3 class="footer__title footer__title--menu" aria-label="Navegación">Navegación</h3>
    <menu class="menu menu--footer">
        <li class="menu__item menu__item--footer">
            <Link
                href="/#home"
                native={true}
                className="menu__link menu__link--footer">Home</Link
            >
        </li>

        <li class="menu__item menu__item--footer">
            <Link
                href="/#programming"
                native={true}
                className="menu__link menu__link--footer">Programación</Link
            >
        </li>

        <li class="menu__item menu__item--footer">
            <Link
                href="/online"
                native={false}
                className="menu__link menu__link--footer">En Vivo</Link
            >
        </li>

        <li class="menu__item menu__item--footer">
            <Link
                href="/news"
                native={false}
                className="menu__link menu__link--footer">Noticias</Link
            >
        </li>
        <li class="menu__item menu__item--footer">
            <Link
                href="/#contact"
                native={true}
                className="menu__link menu__link--footer">Contacto</Link
            >
        </li>
    </menu>
</div>

<style>
    .grow {
        flex-grow: 1;
    }
</style>