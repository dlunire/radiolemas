<script lang="ts">
    import About from "../../components/Container/About.svelte";
    import Contact from "../../components/Container/Contact.svelte";
    import ContainerNav from "../../components/Container/ContainerNav.svelte";
    import ContainerNews from "../../components/Container/ContainerNews.svelte";
    import Programing from "../../components/Container/Programing.svelte";
    import Tendencies from "../../components/Container/Tendencies.svelte";
    import MenuFooter from "../../components/Footer/MenuFooter.svelte";
    import Live from "../../components/Header/Live.svelte";
    import MenuHeader from "../../components/Header/MenuHeader.svelte";
    import SocialMedia from "../../components/SocialMedia/SocialMedia.svelte";
    import IconLogoHeader from "../../icons/IconLogoHeader.svelte";
    import IconRadioLemasDark from "../../icons/IconRadioLemasDark.svelte";
    import Link from "../../routers/components/Link.svelte";
    import Container from "../../sections/Container.svelte";
    import Header from "../../sections/Header.svelte";

    /** Indica si es una página de usuario */
    let home: boolean = true;

    let lema: string = "La Poderosa Online";
</script>

<Header bind:home id="home">
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

            <div class="footer__item footer__item--links">
                <MenuFooter />
            </div>
            <div class="footer__item footer__item--">2</div>
            <div class="footer__item">3</div>
        </div>
    </div>
</Container>
