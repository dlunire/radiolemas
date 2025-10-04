<script lang="ts">
    let maps: string = `<iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d63633.16193886583!2d-74.28415362159237!3d4.580981992379528!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8e3f9fcd7b8c3479%3A0x2419f1284b958960!2sCentro%20Comercial%20Mercurio!5e0!3m2!1ses-419!2sco!4v1759575923489!5m2!1ses-419!2sco"
                width="600"
                height="450"
                style="border:0;"
                loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"
                title="Google Maps"
            ></iframe>`
</script>

<section class="section section--home section--contact" id="contact-us">
    <div class="section__inner section__inner--contact">
        <h2
            class="section__title section__title--contact"
            aria-label="Contacto"
        >
            Contacto
        </h2>
    </div>

    <section class="contact">
        <div class="contact__column contact__column--maps">
            {@html maps}
        </div>

        <div class="contact__column contact__column--form"></div>
    </section>
</section>
