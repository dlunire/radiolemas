<script lang="ts">
    import SocialMedia from "../Footer/SocialMedia.svelte";

    export let lema: string = "";
</script>

<nav class="container__nav container__nav--home" id="home">
    <div class="container__nav-inner">
        <span class="container__nav-lema">{lema}</span>
        <span></span>
        <SocialMedia nav={true} />
    </div>
</nav>
