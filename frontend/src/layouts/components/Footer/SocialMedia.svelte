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
</script>

<div class="links" id="links">
    <h3 class="links__title" aria-label="Enlaces externos">
        <IconSocialMedia />
        <span>Redes sociales</span>
    </h3>

    <ul class="social social--footer">
        <li class="social__item social__item--footer">
            <a
                href="#home"
                class="social__link social__link--footer"
                aria-label="Pinterest"
            >
                <IconPinterest />
            </a>
        </li>

        <li class="social__item social__item--footer">
            <a
                href="#home"
                class="social__link social__link--footer"
                aria-label="X"
            >
                <IconX />
            </a>
        </li>

        <li class="social__item social__item--footer">
            <a
                href="#home"
                class="social__link social__link--footer"
                aria-label="Facebook"
            >
                <IconFacebook />
            </a>
        </li>

        <li class="social__item social__item--footer">
            <a
                href="#home"
                class="social__link social__link--footer"
                aria-label="TikTok"
            >
                <IconTikTok />
            </a>
        </li>
        
        <li class="social__item social__item--footer">
            <a
                href="#home"
                class="social__link social__link--footer"
                aria-label="Instagram"
            >
                <IconInstagram />
            </a>
        </li>
        
        <li class="social__item social__item--footer">
            <a
                href="#home"
                class="social__link social__link--footer"
                aria-label="YouTube"
                data-youtube
            >
                <IconYouTube />
            </a>
        </li>

        <li class="social__item social__item--footer">
            <a
                href="#home"
                class="social__link social__link--footer"
                aria-label="Threads"
            >
                <IconThreads />
            </a>
        </li>

        <li class="social__item social__item--footer">
            <a
                href="#home"
                class="social__link social__link--footer"
                aria-label="Patreon"
            >
                <IconPatreon />
            </a>
        </li>
    </ul>
</div>
