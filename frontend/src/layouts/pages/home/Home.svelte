<script lang="ts">
    import ContainerNav from "../../components/Container/ContainerNav.svelte";
    import ContainerNews from "../../components/Container/ContainerNews.svelte";
    import Live from "../../components/Header/Live.svelte";
    import MenuHeader from "../../components/Header/MenuHeader.svelte";
    import IconLogoHeader from "../../icons/IconLogoHeader.svelte";
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
</Container>
