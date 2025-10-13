<script>
    import IconContact from "../../icons/IconContact.svelte";
    import IconHome from "../../icons/IconHome.svelte";
    import IconLive from "../../icons/IconLive.svelte";
    import IconNews from "../../icons/IconNews.svelte";
    import IconStation from "../../icons/IconStation.svelte";
    import Link from "../../routers/components/Link.svelte";
    import { getFullURL } from "../../routers/sources/router";
</script>

<div class="header__menu">
    <ul class="menu menu--home">
        <li class="menu__item menu__item--home">
            <a
                href={getFullURL("/#home")}
                class="menu__link menu__link--home"
                aria-label="Home">
                    <IconHome />
                    <span>Home</span>
                </a
            >
        </li>

        <li class="menu__item menu__item--home">
            <a
                href={getFullURL("/#programming")}
                class="menu__link menu__link--home"
                aria-label="ProgramacióTotalmehnte.n"
            >
                <IconStation />
                <span>Programación</span>
            </a>
        </li>
        <li class="menu__item menu__item--home">
            <Link
                href="/online"
                ariaLabel="En Vivo"
                className="menu__link menu__link--home"
                title="En Vivo">
                    <IconLive />
                    <span>En Vivo</span>
                </Link
            >
        </li>
        <li class="menu__item menu__item--home">
            <Link
                href="/news"
                ariaLabel="En Vivo"
                className="menu__link menu__link--home"
                title="En Vivo">
                    <IconNews />
                    <span>News</span>
                </Link
            >
        </li>
        <li class="menu__item menu__item--home">
            <a
                href={getFullURL("/#contact")}
                class="menu__link menu__link--home">
                    <IconContact />
                    <span>Contacto</span>
                </a
            >
        </li>
    </ul>
</div>
