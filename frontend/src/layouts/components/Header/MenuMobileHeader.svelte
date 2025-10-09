<script lang="ts">
    import type { ILink } from "../../../lib/interface/link";
    import IconRadioLemasH from "../../icons/IconRadioLemasH.svelte";
    import Link from "../../routers/components/Link.svelte";

    export let openMenu: boolean = false;
    export let links: ILink[] = [
        {
            href: "https://www.google.com",
            title: "Web de Google",
            native: true,
            target: "_blank",
            className: "menu__link menu__link--mobile"
        }
    ];
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
                bind:openMenu>Home</Link
            >
        </li>

        <li class="menu__item menu__item--mobile">
            <Link
                href="/#programming"
                native={true}
                className="menu__link menu__link--mobile"
                bind:openMenu>Programación</Link
            >
        </li>

        <li class="menu__item menu__item--mobile">
            <Link
                href="/online"
                native={false}
                className="menu__link menu__link--mobile"
                bind:openMenu>En Vivo</Link
            >
        </li>

        <li class="menu__item menu__item--mobile">
            <Link
                href="/news"
                native={false}
                className="menu__link menu__link--mobile"
                bind:openMenu>Noticias</Link
            >
        </li>
        <li class="menu__item menu__item--mobile">
            <Link
                href="/#contact"
                native={true}
                className="menu__link menu__link--mobile"
                bind:openMenu>Contacto</Link
            >
        </li>
    </menu>

    {#if links.length > 0}
    <!-- Otros enlaces -->
    <h2 class="grow__title" aria-label="Otros enlaces">
        <span>Otros enlaces</span>
    </h2>

    <menu class="menu menu--mobile">
        {#each links as link, index}
            <li class="menu__item menu__item--mobile">
                <Link {...link}>{index + 1}. Home</Link>
            </li>
        {/each}
    </menu>
    {/if}
</div>

<style>
    .grow {
        flex-grow: 1;
    }
</style>
