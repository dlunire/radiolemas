<script lang="ts">
    import About from "../../components/Container/About.svelte";
    import Contact from "../../components/Container/Contact.svelte";
    import ContainerNav from "../../components/Container/ContainerNav.svelte";
    import ContainerNews from "../../components/Container/ContainerNews.svelte";
    import Programing from "../../components/Container/Programing.svelte";
    import Tendencies from "../../components/Container/Tendencies.svelte";
    import InfoContact from "../../components/Footer/InfoContact.svelte";
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
    import Link from "../../routers/components/Link.svelte";
    import Container from "../../sections/Container.svelte";
    import Header from "../../sections/Header.svelte";

    /** Indica si es una página de usuario */
    let home: boolean = true;
    let lema: string = "La Poderosa Online";
    let openMenu: boolean = false;
</script>

<Header bind:home id="home">
    
    <Link href="/#home" className="header__logo header__logo--home">
        <IconLogoHeader />
    </Link>

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

        <div class="container__hero-info">
            <div class="container__hero-column container__hero-column--left">
                <IconRadioLemasDark />
            </div>
            <div
                class="container__hero-column container__hero-column--right"
            ></div>
        </div>
    </section>

    <ContainerNews />
    <Tendencies />
    <Programing />
    <About />
    <Contact />

    <div class="footer__inner footer__inner--home" slot="footer-content">
        <div class="footer__cards">
            <div class="footer__item footer__item--logo">
                <div>
                    <IconRadioLemasDark />
                    <InfoContact />
                </div>
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

        <div class="footer__copyright">
            <span>© 2025 RadioLemas. Todos los derechos reservados.</span>
            
            <div class="footer__copyright-info">
                <Link href="/legal" className="footer__link">Aviso Legal</Link>
                <Link href="/privacidad" className="footer__link">Política de privacidad</Link>
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
