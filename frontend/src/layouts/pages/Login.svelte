<script lang="ts">
    import { onMount } from "svelte";
    import { zIndexReverse } from "../../lib/zIndex";
    import Form from "../components/Forms/Form.svelte";
    import Container from "../sections/Container.svelte";
    import Windows from "../windows/Windows.svelte";
    import InstallationHelp from "../help/InstallationHelp.svelte";
    import IconHelp from "../icons/IconHelp.svelte";
    import IconLoading from "../icons/IconLoading.svelte";
    import IconKeys from "../icons/IconKeys.svelte";
    import IconCodigosdelFuturo from "../icons/IconCodigosdelFuturo.svelte";
    import ButtonLogin from "../components/Buttons/ButtonLogin.svelte";
    import ToggleButton from "../components/Buttons/ToggleButton.svelte";

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
    let toggleButtonActive: boolean = false;
</script>

<Container>
    <section class="section section--install" bind:this={container}>
        <div class="section__inner section__inner--login">
            <div class="section__logo section__logo--login">
                <IconCodigosdelFuturo />
            </div>
            <h2
                class="section__title section__title--center section__title--login"
            >
                <span>Ingrese sus credenciales</span>
            </h2>
            <Form
                action="/login"
                className="form--clase-01 form--clase-02"
                redirect="/dashboard"
                method="post"
                bind:loading
                autocomplete="off"
            >
                {#snippet content()}
                    <div class="form__inner">
                        <label
                            for="username"
                            class="form__label form__label--login"
                        >
                            <span>Usuario</span>
                            <input
                                type="text"
                                name="username"
                                id="username"
                                class="form__input form__input--login"
                                placeholder="Por ejemplo, su usuario"
                                required={true}
                                aria-required="true"
                                autocomplete="off"
                            />
                        </label>
                        <label
                            for="password"
                            class="form__label form__label--login"
                        >
                            <span>Contraseña</span>
                            <input
                                type={toggleButtonActive ? "text" : "password"}
                                name="password"
                                id="password"
                                class="form__input form__input--login"
                                placeholder="Por ejemplo, su contraseña"
                                required={true}
                                aria-required="true"
                                autocomplete="new-password"
                            />
                        </label>
                    </div>

                    <div class="form__inner--login">
                        <ToggleButton
                            bind:active={toggleButtonActive}
                            label="Mostrar contraseña"
                        />
                    </div>

                    <div class="form__buttons form__buttons--login">
                        <ButtonLogin bind:loading>
                            {#snippet content()}
                                <IconKeys />
                                <span>Iniciar sesión</span>
                                <IconLoading bind:open={loading} size={27} color="black" fixedColor="#0004" />
                            {/snippet}
                        </ButtonLogin>
                    </div>
                {/snippet}
            </Form>
        </div>
    </section>
</Container>

<Windows bind:open title="Ayuda con la instalación">
    {#snippet contentHeader()}
        <IconHelp />
    {/snippet}

    {#snippet content()}
        <InstallationHelp />
    {/snippet}
</Windows>
