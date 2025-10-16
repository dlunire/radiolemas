<script lang="ts">
    import IconAddress from "../../icons/IconAddress.svelte";
    import IconContact from "../../icons/IconContact.svelte";
    import IconEmail from "../../icons/IconEmail.svelte";
    import IconWhatsApp from "../../icons/IconWhatsApp.svelte";
</script>

<div class="informations" id="links">
    <h3 class="informations__title" aria-label="Información de contacto">
        <IconContact />
        <span>Información de contacto</span>
    </h3>

    <ul class="info info--contact">
        <li class="info__item info__item--contact">
            <IconAddress />
            <span>Alguna dirección, calle falsa</span>
        </li>
        
        <li class="info__item info__item--contact">
            <IconEmail />
            <span>correo@dominio.com</span>
        </li>
        
        <li class="info__item info__item--contact">
            <IconWhatsApp />
            <span>+1 000 000 0000</span>
        </li>
    </ul>
</div>
