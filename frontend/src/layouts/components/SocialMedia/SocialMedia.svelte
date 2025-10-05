<script lang="ts">
    import IconAddress from "../../icons/IconAddress.svelte";
    import IconEmail from "../../icons/IconEmail.svelte";
    import IconFacebook from "../../icons/IconFacebook.svelte";
    import IconInstagram from "../../icons/IconInstagram.svelte";
</script>

<div class="footer__social-media">
    <p class="social-label">Siguenos en:</p>
    <ul class="social-media">
        <li class="social-media__item">
            <a
                href="https://web.facebook.com/"
                aria-label="Perfil en Facebook"
                rel="nofollow"
                target="_blank"
                class="social-media__link"
            >
                <IconFacebook />
            </a>
        </li>

        <li class="social-media__item">
            <a
                href="https://instagram.com/"
                aria-label="Perfil en Instagram"
                rel="nofollow"
                target="_blank"
                class="social-media__link"
            >
                <IconInstagram />
            </a>
        </li>

        <li class="social-media__item">
            <a
                href="https://"
                aria-label="Perfil de correo"
                rel="nofollow"
                target="_blank"
                class="social-media__link"
            >
                <IconEmail />
            </a>
        </li>

        <li class="social-media__item">
            <a
                href="https://"
                aria-label="Dirección"
                rel="nofollow"
                target="_blank"
                class="social-media__link"
            >
                <IconAddress />
            </a>
        </li>
    </ul>
</div>
