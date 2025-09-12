<script lang="ts">
    import { onMount } from "svelte";
    import Form from "../../components/Forms/Form.svelte";
    import Icon from "../../components/Graphics/Icon.svelte";
    import IconFolder from "../../icons/IconFolder.svelte";
    import IconSettings from "../../icons/IconSettings.svelte";
    import IconTable from "../../icons/IconTable.svelte";
    import { request } from "../../components/Forms/lib/request";

    let hidden: boolean = true;
    let actions: string = "/dashboard/current/settings";

    onMount(() => {
        loadSettings();
    });

    async function loadSettings(): Promise<void> {
        const data: unknown = await request(actions, {
            credentials: "include",
            method: "GET",
        });
        console.log({ data });
    }
</script>

<section class="content content--settings" aria-labelledby="csv-settings-title">
    <div class="form-container">
        <h2
            class="form-container__title"
            id="csv-settings-title"
            aria-label="Configuración de columnas de tabla"
        >
            <IconSettings />
            <span>Configuración del sistema</span>
        </h2>

        <blockquote class="fade-in-delay">
            <h3>Importante</h3>

            <p class="form__instructions">
                Ingrese un título descriptivo para cada campo técnico. Este
                título será visible como encabezado de columna en la tabla de
                datos. <strong>No escriba valores reales</strong>
                como <code>“12345678”</code> o <code>“25 de marzo”</code>, sino
                nombres genéricos como <code>Nombres</code>,
                <code>“Fecha de nacimiento”</code>, etc.
            </p>

            <p>
                El propósito es colocar el nombre de las columnas de su hoja de
                cálculo exportada a CSV para que coincidan con los campos
                interno de la base de datos, de decir, colocar nombres legibles
                para determinar que ese nombre legible de campo se corresponde
                con el nombre interno de las de la base de datos.
            </p>
        </blockquote>

        <Form
            action="/dashboard/settings"
            method="post"
            className="form--settings"
        >
            {#snippet content()}
                <h3 class="form__title">
                    <IconTable />
                    <span>Definir nombres de columnas</span>
                </h3>

                <fieldset
                    class="form__fieldset fieldset fieldset--settings fade-in-delay"
                >
                    <legend class="form__legend">
                        Asigne nombres legibles a los campos técnicos
                    </legend>

                    <label
                        for="first_name"
                        class="form__label"
                        aria-label="Nombre legible para 'first_name'"
                    >
                        <span>Campo técnico: <code>first_name</code></span>
                        <input
                            type="text"
                            name="first_name"
                            id="first_name"
                            placeholder="Ej.: Nombres"
                            class="form__input form__input--settings"
                        />
                    </label>

                    <label
                        for="last_name"
                        class="form__label"
                        aria-label="Nombre legible para 'last_name'"
                    >
                        <span>Campo técnico: <code>last_name</code></span>
                        <input
                            type="text"
                            name="last_name"
                            id="last_name"
                            placeholder="Ej.: Apellidos"
                            class="form__input form__input--settings"
                        />
                    </label>

                    <label
                        for="doc_type"
                        class="form__label"
                        aria-label="Nombre legible para 'doc_type'"
                    >
                        <span>Campo técnico: <code>doc_type</code></span>
                        <input
                            type="text"
                            name="doc_type"
                            id="doc_type"
                            placeholder="Ej.: Tipo de documento"
                            class="form__input form__input--settings"
                        />
                    </label>

                    <label
                        for="document_number"
                        class="form__label"
                        aria-label="Nombre legible para 'document_number'"
                    >
                        <span>Campo técnico: <code>document_number</code></span>
                        <input
                            type="text"
                            name="document_number"
                            id="document_number"
                            placeholder="Ej.: Nº de documento"
                            class="form__input form__input--settings"
                        />
                    </label>

                    <label
                        for="birth_date"
                        class="form__label"
                        aria-label="Nombre legible para 'birth_date'"
                    >
                        <span>Campo técnico: <code>birth_date</code></span>
                        <input
                            type="text"
                            name="birth_date"
                            id="birth_date"
                            placeholder="Ej.: Fecha de nacimiento"
                            class="form__input form__input--settings"
                        />
                    </label>

                    <label
                        for="course_name"
                        class="form__label"
                        aria-label="Nombre legible para 'course_name'"
                    >
                        <span>Campo técnico: <code>course_name</code></span>
                        <input
                            type="text"
                            name="course_name"
                            id="course_name"
                            placeholder="Ej.: Curso"
                            class="form__input form__input--settings"
                        />
                    </label>
                </fieldset>

                <div class="form__buttons">
                    <button class="button button--primary">
                        <IconFolder />
                        <span>Guardar configuración</span>
                    </button>
                </div>
            {/snippet}
        </Form>
    </div>

    <Icon bind:hidden title="Configuración">
        {#snippet content()}
            <IconSettings />
        {/snippet}
    </Icon>
</section>
