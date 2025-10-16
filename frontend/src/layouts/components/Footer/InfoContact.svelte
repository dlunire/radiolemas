<script lang="ts">
    import IconAddress from "../../icons/IconAddress.svelte";
    import IconContact from "../../icons/IconContact.svelte";
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
    </ul>
</div>
