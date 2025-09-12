<script lang="ts">
    import { onMount } from "svelte";
    import { zIndexReverse } from "../../lib/zIndex";
    import ButtonSubmit from "../components/Buttons/ButtonSubmit.svelte";
    import Form from "../components/Forms/Form.svelte";
    import Container from "../sections/Container.svelte";
    import Header from "../sections/Header.svelte";
    import Windows from "../windows/Windows.svelte";
    import IconHelp from "../icons/IconHelp.svelte";
    import IconLoading from "../icons/IconLoading.svelte";
    import IconKeys from "../icons/IconKeys.svelte";
    import IconInstall from "../icons/IconInstall.svelte";
    import UserHelp from "../help/UserHelp.svelte";

    onMount(() => {
        if (container instanceof HTMLElement) zIndexReverse(container);
    });

    let container: HTMLElement | null = null;

    function handleNumeric(event: Event): void {
        const { target: input } = event;
        if (!(input instanceof HTMLInputElement)) return;

        const reg: RegExp = /[^0-9]+/;
        input.value = input.value.replace(reg, "");
    }

    let open: boolean = false;
    function onclick(event: MouseEvent): void {
        open = !open;
    }

    let loading: boolean = false;
</script>

<Header>
    <h2 class="header__title">
        <IconInstall />
        <span>Programa de instalación</span>
    </h2>
    <button class="button button--help" {onclick}>
        <IconHelp />
        <span>Ayuda</span>
    </button>
</Header>

<Container>
    <section class="section section--install" bind:this={container}>
        <div class="section__inner">
            <h1 class="section__title">
                <IconKeys />
                <span>Creación de usuario</span>
            </h1>
            <hr />

            <p>
                Programa de instalación, diseñado para configurar rápidamente
                los parámetros de conexión a la base de datos.
            </p>

            <p>&nbsp;</p>
            <Form
                action="/create/user"
                className="form--clase-01 form--clase-02"
                redirect="/login"
                method="post"
                bind:loading
            >
                {#snippet content()}
                    <div class="form__inner">
                        <label
                            for="user-name"
                            class="form__item"
                            title="Nombres"
                        >
                            <span>Nombres:</span>
                            <input
                                type="text"
                                name="user-name"
                                id="user-name"
                                placeholder="Por ejemplo, John"
                                class="form__input"
                                autocomplete="off"
                                required={true}
                            />
                        </label>
                        <label
                            for="user-lastname"
                            class="form__item"
                            title="Apellidos"
                        >
                            <span>Apellidos:</span>
                            <input
                                type="text"
                                name="user-lastname"
                                id="user-lastname"
                                placeholder="Por ejemplo, Connor"
                                class="form__input"
                                autocomplete="off"
                                required={true}
                            />
                        </label>

                        <label
                            for="user-email"
                            class="form__item"
                            title="Correo electrónico"
                        >
                            <span>Correo electrónico:</span>
                            <input
                                type="email"
                                name="user-email"
                                id="user-email"
                                placeholder="Por ejemplo, correo@ejemplo.com"
                                class="form__input"
                                autocomplete="off"
                                required={true}
                            />
                        </label>

                        <label
                            for="user-username"
                            class="form__item"
                            title="Usuario"
                        >
                            <span>Usuario:</span>
                            <input
                                type="text"
                                name="user-username"
                                id="user-username"
                                placeholder="Por ejemplo, admin"
                                class="form__input"
                                autocomplete="off"
                                required={true}
                            />
                        </label>
                        <label
                            for="user-pasword"
                            class="form__item"
                            title="Contraseña"
                        >
                            <span>Contraseña:</span>
                            <input
                                type="password"
                                name="user-password"
                                id="user-password"
                                placeholder="Su contraseña aquí"
                                class="form__input"
                                autocomplete="off"
                                required={true}
                            />
                        </label>
                    </div>

                    <div class="form__buttons">
                        <ButtonSubmit bind:loading>
                            {#snippet content()}
                                <IconKeys />
                                <span>Establecer credenciales</span>
                                <IconLoading bind:open={loading} size={25} />
                            {/snippet}
                        </ButtonSubmit>
                    </div>
                {/snippet}
            </Form>
        </div>
    </section>
</Container>

<Windows bind:open title="Usuario del sistema">
    {#snippet contentHeader()}
        <IconHelp />
    {/snippet}

    {#snippet content()}
        <UserHelp />
    {/snippet}
</Windows>
