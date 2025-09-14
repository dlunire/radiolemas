<script lang="ts">
    import { onMount } from "svelte";
    import { zIndexReverse } from "../../lib/zIndex";
    import ButtonSubmit from "../components/Buttons/ButtonSubmit.svelte";
    import Form from "../components/Forms/Form.svelte";
    import Container from "../sections/Container.svelte";
    import Header from "../sections/Header.svelte";
    import Windows from "../windows/Windows.svelte";
    import InstallationHelp from "../help/InstallationHelp.svelte";
    import IconHelp from "../icons/IconHelp.svelte";
    import IconLoading from "../icons/IconLoading.svelte";
    import IconKeys from "../icons/IconKeys.svelte";

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
        <IconKeys />
        <span>Comprobar credenciales</span>
    </h2>
    <button class="button button--help" {onclick}>
        <IconHelp />
        <span>Ayuda</span>
    </button>
</Header>

<Container>
    <section class="section section--install" bind:this={container}>
        <div class="section__inner">
            <p class="p-width p-center">
                Presiona el botón <strong>Verificar credenciales</strong> para comprobar
                la conexión con la base de datos. Si los datos ingresados son válidos,
                continuarás con la creación del usuario administrador. En caso contrario,
                podrás corregir las credenciales antes de seguir con la instalación.
            </p>
            <Form
                action="/credentials/check"
                className="form--clase-01 form--clase-02"
                redirect="/create/user"
                backredirect="/install/credentials"
                method="post"
                bind:loading
            >
                {#snippet content()}
                    <div class="form__buttons form__buttons--center">
                        <ButtonSubmit bind:loading>
                            {#snippet content()}
                                <IconKeys />
                                <span>Verificar credenciales</span>
                                <IconLoading bind:open={loading} size={25} />
                            {/snippet}
                        </ButtonSubmit>
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
