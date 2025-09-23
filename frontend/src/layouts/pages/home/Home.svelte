<script lang="ts">
    import Live from "../../components/Header/Live.svelte";
    import IconLogoHeader from "../../icons/IconLogoHeader.svelte";
    import IconRadioLema from "../../icons/IconRadioLema.svelte";
    import IconRadioLemasH from "../../icons/IconRadioLemasH.svelte";
    import { getFullURL } from "../../routers/sources/router";
    import Container from "../../sections/Container.svelte";
    import Header from "../../sections/Header.svelte";

    /** Indica si es una página de usuario */
    let home: boolean = true;

    let lema: string = "La Poderosa Online";

    function onclick(event: MouseEvent): void {
        const anchor: HTMLAnchorElement = document.createElement("a");
        anchor.href = getFullURL("/dashboard");
        anchor.click();
        anchor.remove();
    }
</script>

<Header bind:home>
    <h1 class="header__title header__title--home">
        <IconLogoHeader />
    </h1>

    <Live />
</Header>

<Container>
    <nav class="container__nav container__nav--home">
        <div class="container__nav-inner">
            <span>{lema}</span>
        </div>
    </nav>

    <section class="container__hero"></section>

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

            <blockquote>
                <p>
                    <strong>Nota importante:</strong>
                    Si usted observa este mensaje, significa que las próximas horas
                    estará disponible la Web de la emisora. No olvides que debe alimentar
                    el sitio Web de noticias.
                </p>

                <p>
                    La emisora ya incluye un <strong
                        >panel de administración</strong
                    > para que pueda cargar las noticias por sí mismo. También se
                    incluyen módulos de configuración que le permita personalizar
                    su herramienta.
                </p>
            </blockquote>
        </div>
    </section>
</Container>
