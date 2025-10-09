<script lang="ts">
    import IconRadioLemasDark from "../../icons/IconRadioLemasDark.svelte";
    import IconRadioLemasH from "../../icons/IconRadioLemasH.svelte";
    import IconRadioLemasIso from "../../icons/IconRadioLemasIso.svelte";
    import Link from "../../routers/components/Link.svelte";

    export let openMenu: boolean = false;
</script>

<div class="grow">
    <div class="grow__logo">
        <IconRadioLemasH />
    </div>

    <h2 class="grow__title" aria-label="Menú de Navegación">
        <span>Menú de navegación</span>
    </h2>

    <!-- Enlace principal -->
    <menu class="menu menu--mobile">
        <li class="menu__item menu__item--mobile">
            <Link
                href="/#home"
                native={true}
                className="menu__link menu__link--mobile"
                bind:openMenu
                >Home</Link
            >
        </li>

        <li class="menu__item menu__item--mobile">
            <Link
                href="/#programming"
                native={true}
                className="menu__link menu__link--mobile" bind:openMenu>Programación</Link
            >
        </li>

        <li class="menu__item menu__item--mobile">
            <Link
                href="/online"
                native={false}
                className="menu__link menu__link--mobile" bind:openMenu>En Vivo</Link
            >
        </li>

        <li class="menu__item menu__item--mobile">
            <Link
                href="/news"
                native={false}
                className="menu__link menu__link--mobile" bind:openMenu>Noticias</Link
            >
        </li>
        <li class="menu__item menu__item--mobile">
            <Link
                href="/#contact"
                native={true}
                className="menu__link menu__link--mobile" bind:openMenu>Contacto</Link
            >
        </li>
    </menu>

    <!-- Otros enlaces -->
    <h2 class="grow__title" aria-label="Otros enlaces">
        <span>Otros enlaces</span>
    </h2>

    <menu class="menu menu--mobile">
        <li class="menu__item menu__item--mobile">
            <Link
                href="/#home"
                native={true}
                className="menu__link menu__link--mobile">Home</Link
            >
        </li>

        <li class="menu__item menu__item--mobile">
            <Link
                href="/#programming"
                native={true}
                className="menu__link menu__link--mobile">Programación</Link
            >
        </li>

        <li class="menu__item menu__item--mobile">
            <Link
                href="/online"
                native={false}
                className="menu__link menu__link--mobile">En Vivo</Link
            >
        </li>

        <li class="menu__item menu__item--mobile">
            <Link
                href="/news"
                native={false}
                className="menu__link menu__link--mobile">Noticias</Link
            >
        </li>
        <li class="menu__item menu__item--mobile">
            <Link
                href="/#contact"
                native={true}
                className="menu__link menu__link--mobile">Contacto</Link
            >
        </li>
    </menu>
</div>

<style>
    .grow {
        flex-grow: 1;
    }
</style>
