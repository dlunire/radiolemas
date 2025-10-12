<script lang="ts">
    import IconContact from "../../icons/IconContact.svelte";
    import IconHome from "../../icons/IconHome.svelte";
    import IconLive from "../../icons/IconLive.svelte";
    import IconMenuItem from "../../icons/IconMenuItem.svelte";
    import IconNews from "../../icons/IconNews.svelte";
    import IconStation from "../../icons/IconStation.svelte";
    import Link from "../../routers/components/Link.svelte";
</script>

<div class="grow">
    <h3 class="footer__title footer__title--menu" aria-label="Navegación">
        <IconMenuItem />
        <span>Navegación</span>
    </h3>
    <menu class="menu menu--footer">
        <li class="menu__item menu__item--footer">
            <Link
                href="/#home"
                native={true}
                className="menu__link menu__link--footer"
            >
                <IconHome />
                <span>Home</span>
            </Link>
        </li>

        <li class="menu__item menu__item--footer">
            <Link
                href="/#programming"
                native={true}
                className="menu__link menu__link--footer"
            >
                <IconStation />
                <span>Programación</span>
            </Link>
        </li>

        <li class="menu__item menu__item--footer">
            <Link
                href="/online"
                native={false}
                className="menu__link menu__link--footer"
            >
                <IconLive />
                <span>En Vivo</span>
            </Link>
        </li>

        <li class="menu__item menu__item--footer">
            <Link
                href="/news"
                native={false}
                className="menu__link menu__link--footer"
            >
                <IconNews />
                <span>Noticias</span>
            </Link>
        </li>
        <li class="menu__item menu__item--footer">
            <Link
                href="/#contact"
                native={true}
                className="menu__link menu__link--footer"
            >
                <IconContact />
                <span>Contacto</span>
            </Link>
        </li>
    </menu>
</div>

<style>
    .grow {
        flex-grow: 1;
    }
</style>
