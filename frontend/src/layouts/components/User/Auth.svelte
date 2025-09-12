<script lang="ts">
    import IconExit from "../../icons/IconExit.svelte";
    import IconLoading from "../../icons/IconLoading.svelte";
    import IconUser from "../../icons/IconUser.svelte";
    import {
        getFullURL,
        getLocation,
        navigate,
    } from "../../routers/sources/router";
    import { endpoint } from "../Forms/lib/request";

    export let title: string = "Información del usuario";
    export let openMenu: boolean = false;
    export let action: string = "/logout";

    let top: number = 0;
    let error: boolean = false;
    let label: string = "David E Luna M";
    let loadingOpen: boolean = false;

    function onclick(event: MouseEvent): void {
        const { target: button } = event;
        if (!(button instanceof HTMLButtonElement)) return;
        openMenu = !openMenu;
        loadSize(button);
    }

    function onerror(event: Event): void {
        const { target: image } = event;
        if (!(image instanceof HTMLImageElement)) return;
        error = true;
    }

    function loadSize(button: HTMLButtonElement): void {
        if (!(button instanceof HTMLButtonElement)) {
            throw TypeError("Se esperaba un botón como argumento en «butto»");
        }

        const header: HTMLElement | null = button.closest("header");
        if (!(header instanceof HTMLElement)) return;

        const size: DOMRect = header.getBoundingClientRect();
        top = size.height + 5;
    }

    addEventListener("click", function (event: MouseEvent) {
        const { target: element } = event;
        if (!(element instanceof HTMLElement)) return;
        const { auth } = element.dataset;
        if (typeof auth == "string") return;
        openMenu = false;
    });

    addEventListener("keydown", function (event: KeyboardEvent) {
        const { key } = event;
        if (key === "Escape") {
            openMenu = false;
        }
    });

    async function closeSession(event: MouseEvent): Promise<void> {
        const url: string = endpoint(action);
        loadingOpen = true;
        await fetch(url, {
            method: "DELETE",
            credentials: "include",
        });
        loadingOpen = false;

        const a: HTMLAnchorElement = document.createElement("a");
        a.href = getFullURL("/login");
        a.click();
        a.remove();
    }

    function handleAnchor(event: MouseEvent): void {
        event.preventDefault();

        const { target: anchor } = event;
        if (!(anchor instanceof HTMLAnchorElement)) return;
        const href: string | null = anchor.getAttribute("href");
        if (!href) return;
        navigate(href);
    }
</script>

<nav class="auth">
    <button
        class="button button--user"
        aria-label="Usuario"
        {title}
        {onclick}
        data-auth=""
    >
        <IconUser />
    </button>
</nav>

{#if openMenu}
    <div class="profile-container" style="--top: {top}px">
        <section class="profile">
            <header class="profile__header">
                {#if error}
                    <IconUser />
                {:else}
                    <img
                        src=""
                        alt="Perfil de usuario"
                        loading="lazy"
                        {onerror}
                    />
                {/if}
            </header>
            <div class="profile__content">
                <h2 class="profile__title">{label}</h2>
                <div class="profile__buttons">
                    <button
                        class="button button--profile"
                        aria-label="Cerrar sesión"
                        data-auth=""
                        onclick={closeSession}
                    >
                        <IconExit />
                        <span>Cerrar sesión</span>
                        <IconLoading
                            bind:open={loadingOpen}
                            position="absolute"
                            size={30}
                        />
                    </button>
                </div>

                <div class="profile__links">
                    <a
                        href="/dashboard/profile"
                        class="profile__link"
                        onclick={handleAnchor}
                    >
                        <span>Revisar mi perfil</span>
                    </a>
                </div>
            </div>
        </section>
    </div>
{/if}
