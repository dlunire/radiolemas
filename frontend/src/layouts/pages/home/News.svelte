<script lang="ts">
    import ContainerNav from "../../components/Container/ContainerNav.svelte";
    import ContainerNews from "../../components/Container/ContainerNews.svelte";
    import FooterInfo from "../../components/Footer/FooterInfo.svelte";
    import Live from "../../components/Header/Live.svelte";
    import MenuHeader from "../../components/Header/MenuHeader.svelte";
    import MenuMobileHeader from "../../components/Header/MenuMobileHeader.svelte";
    import MobileMenu from "../../components/Header/MobileMenu.svelte";
    import WindowMenu from "../../components/Header/WindowMenu.svelte";
    import IconLogoHeader from "../../icons/IconLogoHeader.svelte";
    import Link from "../../routers/components/Link.svelte";
    import Container from "../../sections/Container.svelte";
    import Header from "../../sections/Header.svelte";

    /** Indica si es una página de usuario */
    let home: boolean = true;
    // let lema: string = "La Poderosa Online";
    let lema: string = "Un lema de prueba";
    let openMenu: boolean = false;
</script>

<Header bind:home>
    <Link
        href="/#home"
        className="header__logo header__logo--home"
        native={true}
    >
        <IconLogoHeader />
    </Link>

    <MobileMenu bind:openMenu />
    <MenuHeader />

    <Live />
</Header>

<Container dashboard={false} install={false} home={true}>
    <ContainerNav bind:lema />
    <!-- <Hero /> -->
    <ContainerNews />
    <FooterInfo slot="footer-content" />
</Container>

<WindowMenu bind:openMenu>
    <ContainerNav slot="header" />

    <div class="window__container" slot="container">
        <MenuMobileHeader bind:openMenu />
    </div>
</WindowMenu>
