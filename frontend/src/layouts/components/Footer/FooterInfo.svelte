<script lang="ts">
    import IconRadioLemasDark from "../../icons/IconRadioLemasDark.svelte";
    import Link from "../../routers/components/Link.svelte";
    import InfoContact from "./InfoContact.svelte";
    import Links from "./Links.svelte";
    import MenuFooter from "./MenuFooter.svelte";
    import SocialMedia from "./SocialMedia.svelte";
</script>

<div class="footer__inner footer__inner--home">
    <div class="footer__cards">
        <div class="footer__item footer__item--logo">
            <div>
                <Link href="/#home" native={true} className="footer__link footer__link--logo">
                    <IconRadioLemasDark />
                </Link>

                <InfoContact />
            </div>
        </div>

        <div class="footer__item footer__item--links">
            <MenuFooter />
        </div>
        <div class="footer__item footer__item--">
            <Links />
        </div>
        <div class="footer__item">
            <SocialMedia />
        </div>
    </div>
</div>
<div class="footer__inner footer__inner--copyright">
    <div class="footer__copyright">
        <span>© 2025 RadioLemas. Todos los derechos reservados.</span>

        <div class="footer__copyright-info">
            <Link href="/legal" className="footer__link">Aviso Legal</Link>
            <Link href="/privacy" className="footer__link"
                >Política de privacidad</Link
            >
        </div>
    </div>
</div>
