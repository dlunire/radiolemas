<script lang="ts">
    import IconDashboard from "../../icons/IconDashboard.svelte";
    import IconRadioLema from "../../icons/IconRadioLema.svelte";
    import IconRadioLemasH from "../../icons/IconRadioLemasH.svelte";
    import { getFullURL } from "../../routers/sources/router";
    import Container from "../../sections/Container.svelte";
    import Header from "../../sections/Header.svelte";

    /** Indica si es una página de usuario */
    let home: boolean = true;

    function onclick(event: MouseEvent): void {
        const anchor: HTMLAnchorElement = document.createElement("a");
        anchor.href = getFullURL("/dashboard");
        anchor.click();
        anchor.remove();
    }
</script>

<Header bind:home>
    <h1 class="header__title header__title--home">
        <IconRadioLemasH />
    </h1>

    <button class="button button--primary" {onclick}>
        <IconDashboard />
        <span>Dashboard</span>
    </button>
</Header>

<Container>
    <section class="section section--home">
        <div class="section__inner section__inner--home">
            <div class="logo logo--central">
                <IconRadioLema />
            </div>
            <blockquote>
                <strong>Importante:</strong>
                Actualmente estamos configurando la página principal de la emisora.
                Una vez completada la instalación, podrás acceder a todo su contenido
                y funcionalidades.
            </blockquote>

            <p>Eduardo</p>
        </div>
    </section>
</Container>
