<script lang="ts">
    import About from "../../components/Container/About.svelte";
    import Contact from "../../components/Container/Contact.svelte";
    import ContainerNav from "../../components/Container/ContainerNav.svelte";
    import ContainerNews from "../../components/Container/ContainerNews.svelte";
    import Programing from "../../components/Container/Programing.svelte";
    import Tendencies from "../../components/Container/Tendencies.svelte";
    import Links from "../../components/Footer/Links.svelte";
    import MenuFooter from "../../components/Footer/MenuFooter.svelte";
    import SocialMedia from "../../components/Footer/SocialMedia.svelte";
    import Live from "../../components/Header/Live.svelte";
    import MenuHeader from "../../components/Header/MenuHeader.svelte";
    import MenuMobileHeader from "../../components/Header/MenuMobileHeader.svelte";
    import MobileMenu from "../../components/Header/MobileMenu.svelte";
    import WindowMenu from "../../components/Header/WindowMenu.svelte";
    import IconLogoHeader from "../../icons/IconLogoHeader.svelte";
    import IconRadioLemasDark from "../../icons/IconRadioLemasDark.svelte";
    import Container from "../../sections/Container.svelte";
    import Header from "../../sections/Header.svelte";

    /** Indica si es una página de usuario */
    let home: boolean = true;
    let lema: string = "La Poderosa Online";
    let openMenu: boolean = false;
</script>

<Header bind:home id="home">
    <h1 class="header__title header__title--home">
        <IconLogoHeader />
    </h1>

    <MobileMenu bind:openMenu />
    <MenuHeader />

    <Live />
</Header>

<Container dashboard={false} install={false} home={true}>
    <ContainerNav bind:lema />
    <section class="container__hero">
        <picture>
            <!-- Imagen para pantallas pequeñas -->
            <source srcset="./hero-mobile.png" media="(max-width: 500px)" />

            <!-- Imagen por defecto (pantallas grandes) -->
            <source srcset="./hero.png" />

            <!-- Fallback para navegadores antiguos -->
            <img src="./hero.png" alt="Imagen de cabecera" />
        </picture>
    </section>

    <ContainerNews />
    <Tendencies />
    <Programing />
    <About />
    <Contact />

    <div class="footer__inner footer__inner--home" slot="footer-content">
        <div class="footer__cards">
            <div class="footer__item footer__item--logo">
                <IconRadioLemasDark />
            </div>

            <div class="footer__item footer__item--links">
                <MenuFooter />
            </div>
            <div class="footer__item footer__item--">
                <Links />
            </div>
            <div class="footer__item">
                <SocialMedia />
            </div>
        </div>
    </div>
</Container>

<WindowMenu bind:openMenu>
    <ContainerNav slot="header" />

    <div class="window__container" slot="container">
        <MenuMobileHeader bind:openMenu />
    </div>
</WindowMenu>
