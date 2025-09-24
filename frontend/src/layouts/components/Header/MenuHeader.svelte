<script>
    import Link from "../../routers/components/Link.svelte";
    import { getFullURL } from "../../routers/sources/router";
</script>

<div class="header__menu">
    <ul class="menu menu--home">
        <li class="menu__item menu__item--home">
            <a
                href={getFullURL("/#home")}
                class="menu__link menu__link--home"
                aria-label="Home">Home</a
            >
        </li>

        <li class="menu__item menu__item--home">
            <a
                href={getFullURL("/#programming")}
                class="menu__link menu__link--home"
                aria-label="Programación"
            >
                Programación
            </a>
        </li>
        <li class="menu__item menu__item--home">
            <Link
                href="/online"
                ariaLabel="En Vivo"
                className="menu__link menu__link--home"
                title="En Vivo">En Vivo</Link
            >
        </li>
        <li class="menu__item menu__item--home">
            <Link
                href="/news"
                ariaLabel="En Vivo"
                className="menu__link menu__link--home"
                title="En Vivo">Noticias</Link
            >
        </li>
        <li class="menu__item menu__item--home">
            <a
                href={getFullURL("/#contact")}
                class="menu__link menu__link--home">Contacto</a
            >
        </li>
    </ul>
</div>
