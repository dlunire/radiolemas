<script lang="ts">
    import type { ILink } from "../../../lib/interface/link";
    import IconContact from "../../icons/IconContact.svelte";
    import IconHome from "../../icons/IconHome.svelte";
    import IconLInk from "../../icons/IconLInk.svelte";
    import IconNews from "../../icons/IconNews.svelte";
    import IconOclock from "../../icons/IconOclock.svelte";
    import IconRadioLemasH from "../../icons/IconRadioLemasH.svelte";
    import IconStation from "../../icons/IconStation.svelte";
    import Link from "../../routers/components/Link.svelte";

    export let openMenu: boolean = false;
    export let links: ILink[] = [
        {
            href: "https://www.google.com",
            title: "Web de Google",
            native: true,
            target: "_blank",
            className: "menu__link menu__link--mobile",
        },
    ];
</script>

<div class="grow grow--mobile">
    <div class="grow__logo grow__logo--mobile">
        <IconRadioLemasH />
    </div>

    <h2 class="grow__title grow__title--mobile" aria-label="Menú de Navegación">
        <span>Menú de navegación</span>
    </h2>

    <!-- Enlace principal -->
    <menu class="menu menu--mobile">
        <li class="menu__item menu__item--mobile">
            <Link
                href="/#home"
                native={false}
                className="menu__link menu__link--mobile"
                bind:openMenu
            >
                <IconHome />
                <span>Home</span>
            </Link>
        </li>

        <li class="menu__item menu__item--mobile">
            <Link
                href="/#programming"
                native={false}
                className="menu__link menu__link--mobile"
                bind:openMenu
            >
                <IconOclock />
                <span>Programación</span>
            </Link>
        </li>

        <li class="menu__item menu__item--mobile">
            <Link
                href="/online"
                native={false}
                className="menu__link menu__link--mobile"
                bind:openMenu
            >
                <IconStation />
                <span>En Vivo</span>
            </Link>
        </li>

        <li class="menu__item menu__item--mobile">
            <Link
                href="/news"
                native={false}
                className="menu__link menu__link--mobile"
                bind:openMenu
            >
                <IconNews />
                <span>Noticias</span>
            </Link>
        </li>
        <li class="menu__item menu__item--mobile">
            <Link
                href="/#contact"
                native={false}
                className="menu__link menu__link--mobile"
                bind:openMenu
            >
                <IconContact />
                <span>Contacto</span>
            </Link>
        </li>
        .
    </menu>

    {#if links.length > 0}
        <!-- Otros enlaces -->
        <h2 class="grow__title" aria-label="Otros enlaces">
            <span>Otros enlaces</span>
        </h2>

        <menu class="menu menu--mobile">
            {#each links as link}
                <li class="menu__item menu__item--mobile">
                    <Link {...link}>
                        <IconLInk />
                        <span>{link.title}</span>
                    </Link>
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
