<script lang="ts">
    import { onMount } from "svelte";
    import { zIndexReverse } from "../../lib/zIndex";
    import ButtonList from "../components/Buttons/ButtonList.svelte";
    import ButtonSubmit from "../components/Buttons/ButtonSubmit.svelte";
    import Form from "../components/Forms/Form.svelte";
    import Container from "../sections/Container.svelte";
    import Header from "../sections/Header.svelte";
    import Windows from "../windows/Windows.svelte";
    import InstallationHelp from "../help/InstallationHelp.svelte";
    import IconHelp from "../icons/IconHelp.svelte";
    import IconLoading from "../icons/IconLoading.svelte";
    import IconKeys from "../icons/IconKeys.svelte";
    import IconInstall from "../icons/IconInstall.svelte";
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
                <span>Credenciales de la base de datos</span>
            </h1>
            <hr />

            <p>
                Bienvenido al asistente de instalación del sistema. Por favor,
                ingrese las credenciales de la base de datos del sistema.
            </p>

            <p>&nbsp;</p>
            <Form
                action="/install/credentials"
                className="form--clase-01 form--clase-02"
                redirect="/credentials/check"
                method="post"
                bind:loading
            >
                {#snippet content()}
                    <div class="form__inner">
                        <div
                            class="form__item"
                            title="Seleccione el entorno de ejecución de su proyecto"
                        >
                            <span>Seleccione una opción:</span>
                            <ButtonList required={true} label="Selecione..." />
                        </div>

                        <label
                            for="lifetime"
                            class="form__item"
                            title="Tiempo de vida de la sesión en segundos"
                        >
                            <span>Tiempo de vida:</span>
                            <input
                                type="text"
                                inputmode="numeric"
                                oninput={handleNumeric}
                                name="lifetime"
                                id="lifetime"
                                placeholder="Por ejemplo, 3600 (1 hora) para la sesión"
                                class="form__input"
                                value="3600"
                                autocomplete="off"
                            />
                        </label>

                        <label
                            for="database-name"
                            class="form__item"
                            title="Nombre de la base de datos"
                        >
                            <span>Nombre de la BD:</span>
                            <input
                                type="text"
                                name="database-name"
                                id="database-name"
                                placeholder="Por ejemplo, cdelfuturo"
                                class="form__input"
                                autocomplete="off"
                            />
                        </label>

                        <label
                            for="database-user"
                            class="form__item"
                            title="Usuario de la base de datos"
                        >
                            <span>Usuario de la BD:</span>
                            <input
                                type="text"
                                name="database-user"
                                id="database-user"
                                placeholder="Por ejemplo, root"
                                class="form__input"
                                autocomplete="off"
                            />
                        </label>

                        <label
                            for="database-passwordd"
                            class="form__item"
                            title="Contraseña de la base de datos"
                        >
                            <span>Contraseña de la BD:</span>
                            <input
                                type={toggleButtonActive ? "text" : "password"}
                                name="database-password"
                                id="database-password"
                                placeholder="Tu contraseña aquí"
                                class="form__input"
                                autocomplete="off"
                            />
                        </label>

                        <label
                            for="hostname"
                            class="form__item"
                            title="Servidor de la base de datos"
                        >
                            <span>Servidor:</span>
                            <input
                                type="text"
                                name="hostname"
                                id="hostname"
                                placeholder="Por ejemplo, localhost"
                                class="form__input"
                                autocomplete=""
                                value="localhost"
                            />
                        </label>

                        <label
                            for="number-port"
                            class="form__item"
                            title="Número de puerto utilizado"
                        >
                            <span>Nº de puerto:</span>
                            <input
                                type="text"
                                name="number-port"
                                id="number-port"
                                placeholder="Por ejemplo, 3306"
                                class="form__input"
                                oninput={handleNumeric}
                                autocomplete="off"
                                value="3306"
                            />
                        </label>

                        <label
                            for="database-charset"
                            class="form__item"
                            title="Codificación de caracteres"
                        >
                            <span>Codificción:</span>
                            <input
                                type="text"
                                name="database-charset"
                                id="database-charset"
                                placeholder="Por ejemplo, utf8"
                                class="form__input"
                                autocomplete="off"
                                value="utf8"
                            />
                        </label>

                        <label
                            for="database-collation"
                            class="form__item"
                            title="Colación de la base de datos"
                        >
                            <span>Colación:</span>
                            <input
                                type="text"
                                name="database-collation"
                                id="database-collation"
                                placeholder="Por ejemplo, utf8_general_ci"
                                class="form__input"
                                autocomplete="off"
                                value="utf8_general_ci"
                            />
                        </label>

                        <div
                            class="form__item"
                            title="Seleccione el entorno de ejecución de su proyecto"
                        >
                            <span>Motor de BD:</span>
                            <ButtonList
                                name="database-drive"
                                required={true}
                                label="Selecione una base de datos..."
                                list={[
                                    { label: "MySQL", value: "mysql" },
                                    { label: "MariaDB", value: "mariadb" },
                                    { label: "SQLite", value: "sqlite" },
                                    { label: "PostgreSQL", value: "pgsql" },
                                ]}
                            />
                        </div>

                        <label
                            for="database-prefix"
                            class="form__item"
                            title="Prefijo de las tablas"
                        >
                            <span>Motor de BD:</span>
                            <input
                                type="text"
                                name="database-prefix"
                                id="database-prefix"
                                placeholder="Por ejemplo, dl_"
                                class="form__input"
                                autocomplete="off"
                                value="dl_"
                            />
                        </label>
                    </div>

                    <div class="form__inner form__inner--toggle">
                        <div class="form__inner--login">
                            <ToggleButton
                                bind:active={toggleButtonActive}
                                label="Mostrar contraseña"
                            />
                        </div>
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

<Windows bind:open title="Ayuda con la instalación">
    {#snippet contentHeader()}
        <IconHelp />
    {/snippet}

    {#snippet content()}
        <InstallationHelp />
    {/snippet}
</Windows>

<!-- # Indica si la aplicación debe correr o no en producción:
# Motor de base de datos. Si no se define esta variable, el valor
# por defecto será `mysql`:
DL_DATABASE_DRIVE: string = "mysql"

# Si la base de datos usa prefijo, entonces debe declararla aquí:
DL_PREFIX: string = "dl_" -->
