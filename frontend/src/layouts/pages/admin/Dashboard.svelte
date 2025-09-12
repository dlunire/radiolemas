<script lang="ts">
    import { onMount } from "svelte";
    import { zIndexReverse } from "../../../lib/zIndex";
    import Container from "../../sections/Container.svelte";
    import Header from "../../sections/Header.svelte";
    import IconInstall from "../../icons/IconInstall.svelte";
    import Windows from "../../windows/Windows.svelte";
    import Sidebar from "../../sections/Dashboard/Sidebar.svelte";
    import Content from "../../sections/Dashboard/Content.svelte";
    import HeaderRouter from "../../routers/components/HeaderRouter.svelte";
    import ButtonMenu from "../../components/Buttons/ButtonMenu.svelte";
    import Auth from "../../components/User/Auth.svelte";
    import FixedButtons from "../../components/Nav/FixedButtons.svelte";
    import IconHelp from "../../icons/IconHelp.svelte";
    import UserHelp from "../../help/UserHelp.svelte";

    onMount(() => {
        if (container instanceof HTMLElement) zIndexReverse(container);
    });

    let container: HTMLElement | null = null;

    let openMenu: boolean = false;
    let headerHeight: number = 0;
    let openHelp: boolean = false;
</script>

<Header dashboard={true}>
    <h2 class="header__title">
        <IconInstall />
        <span>Panel de administración</span>
    </h2>
    <ButtonMenu bind:open={openMenu} bind:top={headerHeight} />
    <div class="header__options">
        <HeaderRouter />
        <FixedButtons bind:openHelp />
        <Auth />
    </div>
</Header>

<Container dashboard={true}>
    <section class="section section--dashboard" bind:this={container}>
        <Sidebar bind:open={openMenu} bind:top={headerHeight} />
        <Content dashboard={true} />
    </section>
</Container>

<Windows bind:open={openHelp} title="Usuario del sistema">
    {#snippet contentHeader()}
        <IconHelp />
    {/snippet}

    {#snippet content()}
        <UserHelp />
    {/snippet}
</Windows>
