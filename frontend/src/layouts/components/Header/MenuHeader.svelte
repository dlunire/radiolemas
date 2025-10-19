<script>
    import IconContact from "../../icons/IconContact.svelte";
    import IconHome from "../../icons/IconHome.svelte";
    import IconNews from "../../icons/IconNews.svelte";
    import IconOclock from "../../icons/IconOclock.svelte";
    import IconStation from "../../icons/IconStation.svelte";
    import Link from "../../routers/components/Link.svelte";
</script>

<div class="header__menu">
    <ul class="menu menu--home">
        <li class="menu__item menu__item--home">
            <Link
                href="/#home"
                className="menu__link menu__link--home"
                ariaLabel="Home"
                native={false}
            >
                <IconHome />
                <span>Home</span>
            </Link>
        </li>

        <li class="menu__item menu__item--home">
            <Link
                href="/#programming"
                className="menu__link menu__link--home"
                ariaLabel="ProgramacióTotalmehnte.n"
            >
                <IconOclock />
                <span>Programación</span>
            </Link>
        </li>
        <li class="menu__item menu__item--home">
            <Link
                href="/online"
                ariaLabel="En Vivo"
                className="menu__link menu__link--home"
                title="En Vivo"
            >
                <IconStation />
                <span>En Vivo</span>
            </Link>
        </li>
        <li class="menu__item menu__item--home">
            <Link
                href="/news"
                ariaLabel="En Vivo"
                className="menu__link menu__link--home"
                title="En Vivo"
            >
                <IconNews />
                <span>News</span>
            </Link>
        </li>
        <li class="menu__item menu__item--home">
            <Link href="/#contact" className="menu__link menu__link--home">
                <IconContact />
                <span>Contacto</span>
            </Link>
        </li>
    </ul>
</div>
