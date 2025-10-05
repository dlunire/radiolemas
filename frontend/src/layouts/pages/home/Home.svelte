<script lang="ts">
    import About from "../../components/Container/About.svelte";
    import Contact from "../../components/Container/Contact.svelte";
    import ContainerNav from "../../components/Container/ContainerNav.svelte";
    import ContainerNews from "../../components/Container/ContainerNews.svelte";
    import Programing from "../../components/Container/Programing.svelte";
    import Tendencies from "../../components/Container/Tendencies.svelte";
    import Live from "../../components/Header/Live.svelte";
    import MenuHeader from "../../components/Header/MenuHeader.svelte";
    import SocialMedia from "../../components/SocialMedia/SocialMedia.svelte";
    import IconAddress from "../../icons/IconAddress.svelte";
    import IconEmail from "../../icons/IconEmail.svelte";
    import IconFacebook from "../../icons/IconFacebook.svelte";
    import IconInstagram from "../../icons/IconInstagram.svelte";
    import IconLogoHeader from "../../icons/IconLogoHeader.svelte";
    import IconLogoSCR from "../../icons/IconLogoSCR.svelte";
    import IconRadioLemasDark from "../../icons/IconRadioLemasDark.svelte";
    import IconRadioLemasH from "../../icons/IconRadioLemasH.svelte";
    import IconRadioLemasIso from "../../icons/IconRadioLemasIso.svelte";
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

    <MenuHeader />

    <Live />
</Header>

<Container dashboard={false} install={false} home={true}>
    <ContainerNav bind:lema />
    <section class="container__hero"></section>

    <ContainerNews />
    <Tendencies />
    <Programing />
    <About />
    <Contact />

    <div class="footer__inner footer__inner--home" slot="footer-content">
        <div class="footer__cards">
            <div class="footer__item footer__item--logo">
                <IconRadioLemasDark />
                <SocialMedia />
            </div>
            <div class="footer__item footer__item--links">2</div>
            <div class="footer__item footer__item--">2</div>
            <div class="footer__item">3</div>
        </div>
    </div>
</Container>
