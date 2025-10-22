<script lang="ts">
    import IconFacebook from "../../icons/IconFacebook.svelte";
    import IconInstagram from "../../icons/IconInstagram.svelte";
    import IconPatreon from "../../icons/IconPatreon.svelte";
    import IconPinterest from "../../icons/IconPinterest.svelte";
    import IconSocialMedia from "../../icons/IconSocialMedia.svelte";
    import IconThreads from "../../icons/IconThreads.svelte";
    import IconTikTok from "../../icons/IconTikTok.svelte";
    import IconX from "../../icons/IconX.svelte";
    import IconYouTube from "../../icons/IconYouTube.svelte";

    export let nav: boolean = false;
</script>

<div class="links" id="links" class:links--nav={nav}>
    {#if !nav}
        <h3 class="links__title" aria-label="Enlaces externos">
            <IconSocialMedia />
            <span>Redes sociales</span>
        </h3>
    {/if}

    <ul class="social" class:social--footer={!nav} class:social--nav={nav}>
        <li
            class="social__item"
            class:social__item--footer={!nav}
            class:social__item--nav={nav}
        >
            <a
                href="#home"
                class="social__link"
                class:social__link--footer={!nav}
                aria-label="Pinterest"
            >
                <IconPinterest />
            </a>
        </li>

        <li
            class="social__item"
            class:social__item--footer={!nav}
            class:social__item--nav={nav}
        >
            <a
                href="#home"
                class="social__link"
                class:social__link--footer={!nav}
                aria-label="X"
            >
                <IconX />
            </a>
        </li>

        <li
            class="social__item"
            class:social__item--footer={!nav}
            class:social__item--nav={nav}
        >
            <a
                href="#home"
                class="social__link"
                class:social__link--footer={!nav}
                class:social__link--nav={nav}
                aria-label="Facebook"
            >
                <IconFacebook />
            </a>
        </li>

        <li
            class="social__item"
            class:social__item--footer={!nav}
            class:social__item--nav={nav}
        >
            <a
                href="#home"
                class="social__link"
                class:social__link--footer={!nav}
                class:social__link--nav={nav}
                aria-label="TikTok"
            >
                <IconTikTok />
            </a>
        </li>

        <li
            class="social__item"
            class:social__item--footer={!nav}
            class:social__item--nav={nav}
        >
            <a
                href="#home"
                class="social__link"
                class:social__link--footer={!nav}
                class:social__link--nav={nav}
                aria-label="Instagram"
            >
                <IconInstagram />
            </a>
        </li>

        <li
            class="social__item"
            class:social__item--footer={!nav}
            class:social__item--nav={nav}
        >
            <a
                href="#home"
                class="social__link"
                class:social__link--footer={!nav}
                class:social__link--nav={nav}
                aria-label="YouTube"
                data-youtube
            >
                <IconYouTube />
            </a>
        </li>

        <li
            class="social__item"
            class:social__item--footer={!nav}
            class:social__item--nav={nav}
        >
            <a
                href="#home"
                class="social__link"
                class:social__link--footer={!nav}
                class:social__link--nav={nav}
                aria-label="Threads"
            >
                <IconThreads />
            </a>
        </li>

        <li
            class="social__item"
            class:social__item--footer={!nav}
            class:social__item--nav={nav}
        >
            <a
                href="#home"
                class="social__link"
                class:social__link--footer={!nav}
                class:social__link--nav={nav}
                aria-label="Patreon"
            >
                <IconPatreon />
            </a>
        </li>
    </ul>
</div>
