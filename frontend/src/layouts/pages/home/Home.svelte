<script lang="ts">
    import Live from "../../components/Header/Live.svelte";
    import IconLogoHeader from "../../icons/IconLogoHeader.svelte";
    import IconRadioLema from "../../icons/IconRadioLema.svelte";
    import IconRadioLemasH from "../../icons/IconRadioLemasH.svelte";
    import Link from "../../routers/components/Link.svelte";
    import { getFullURL } from "../../routers/sources/router";
    import Container from "../../sections/Container.svelte";
    import Header from "../../sections/Header.svelte";

    /** Indica si es una página de usuario */
    let home: boolean = true;

    let lema: string = "La Poderosa Online";

    function onclick(event: MouseEvent): void {
        const anchor: HTMLAnchorElement = document.createElement("a");
        anchor.href = getFullURL("/dashboard");
        anchor.click();
        anchor.remove();
    }
</script>

<Header bind:home>
    <h1 class="header__title header__title--home">
        <IconLogoHeader />
    </h1>

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
                    href={getFullURL("/online")}
                    ariaLabel="En Vivo"
                    className="menu__link menu__link--home"
                    title="En Vivo">En Vivo</Link
                >
            </li>
            <li class="menu__item menu__item--home">
                <Link
                    href={getFullURL("/news")}
                    ariaLabel="En Vivo"
                    className="menu__link menu__link--home"
                    title="En Vivo">Noticias</Link
                >
            </li>
            <li class="menu__item menu__item--home">
                <a href={getFullURL("/#contact")} class="menu__link menu__link--home">Contacto</a>
            </li>
        </ul>
    </div>

    <Live />
</Header>

<Container>
    <nav class="container__nav container__nav--home">
        <div class="container__nav-inner">
            <span>{lema}</span>
        </div>
    </nav>

    <section class="container__hero"></section>

    <section class="section section--home">
    </section>
</Container>
