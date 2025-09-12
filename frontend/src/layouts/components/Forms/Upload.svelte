<script lang="ts">
    import { onMount } from "svelte";
    import { getResponse, upload } from "./lib/upload";
    import ButtonPrimary from "../Buttons/ButtonPrimary.svelte";
    import NotificationFile from "../Notifications/NotificationFile.svelte";
    import IconUpload from "../../icons/IconUpload.svelte";
    import {
        getType,
        type ServerResponse,
    } from "../Notifications/ErrorInterface";
    import IconFiles from "../../icons/IconFiles.svelte";
    export let buttonContent: Function | undefined = undefined;
    export let name: string = "file";
    export let multiple: boolean = false;
    export let accept: string | undefined = undefined;
    export let action: string = "/files/upload";
    export let data: unknown = undefined;
    export let error: string | null = null;
    export let abort: string | null = null;
    export let success: boolean = false;
    export let add: boolean = false;

    let dragEnterTitle: string = multiple
        ? "Suelte los archivos a copiar"
        : "Suelte el archivo a copiar";

    let inputFile: HTMLInputElement | null = null;
    let form: HTMLFormElement | null = null;
    let progress: number = 0;
    let initialized: boolean = false;
    let isEnter: boolean = false;
    let inProgress: boolean = false;
    let open: boolean = false;
    let errorStatus: boolean = false;
    let warning: boolean = false;
    let info: boolean = false;
    let message: string = "";

    if (multiple) {
        name = `${name}[]`;
    }

    onMount(() => {
        addEventListener("paste", onpaste);
        return () => window.removeEventListener("paste", onpaste);
    });

    /**
     * Captura el evento de pegado de información
     *
     * @param event
     */
    function onpaste(event: ClipboardEvent): void {
        const { clipboardData } = event;
        if (!clipboardData) return;

        const files: FileList = clipboardData.files;
        const { length } = files;

        if (length > 0) {
            event.preventDefault();
        }

        if (!(inputFile instanceof HTMLInputElement)) {
            return;
        }

        setFiles(inputFile, files, multiple);
        if (length < 1) return;

        if (form instanceof HTMLFormElement) {
            form.requestSubmit();
        }
    }

    /**
     * Asigna uno o varios archivos a un elemento `<input type="file">`.
     *
     * Esta función intenta establecer los archivos proporcionados en el elemento `inputFile`.
     * Si el atributo `multiple` es `true`, se asigna la colección completa; de lo contrario, se asigna solo el primer archivo.
     *
     * **Nota:** Aunque la propiedad `input.files` es de solo lectura según la especificación, los navegadores permiten asignar
     * un objeto `FileList` generado artificialmente mediante `DataTransfer`, por lo que esta operación es posible en la práctica.
     *
     * @param inputFile - Elemento HTML de tipo `input` con `type="file"`.
     * @param files - Lista de archivos a establecer.
     * @param multiple - Indica si se deben permitir múltiples archivos (`true`) o solo uno (`false`).
     */
    function setFiles(
        inputFile: HTMLInputElement,
        files: FileList | File[],
        multiple: boolean = false,
    ): void {
        const dataTransfer = new DataTransfer();

        for (const file of files) {
            dataTransfer.items.add(file);
            if (!multiple) break;
        }

        inputFile.files = dataTransfer.files;
    }

    async function onsubmit(event: SubmitEvent): Promise<void> {
        event.preventDefault();
        const { target: form } = event;
        if (!(form instanceof HTMLFormElement)) return;
        initialized = false;
        progress = 0;

        upload(
            form,
            function (loaded: number) {
                if (!initialized) initialized = true;
                if (!inProgress) inProgress = true;

                progress = loaded;
            },

            function (xhr: XMLHttpRequest, done: boolean) {
                if (!(form instanceof HTMLFormElement) || !done) return;
                form.reset();
                data = getResponse(xhr);
                inProgress = false;
                open = true;
                success = xhr.status >= 200 && xhr.status < 300;
                errorStatus = !success;

                const response: ServerResponse = getType<ServerResponse>(
                    JSON.parse(xhr.responseText),
                );
                message =
                    response.error ??
                    response.message ??
                    response.success ??
                    "";
            },
            function (xhr: XMLHttpRequest): void {
                error = "Error al subir el archivo";
                message = error;
                open = true;
                errorStatus = true;
            },

            function (xhr: XMLHttpRequest): void {
                abort = "El usuario abortó la operación";
                message = abort;
                open = true;
                warning = true;
            },
        );
    }

    function ondragenter(event: DragEvent): void {
        event.preventDefault();
        const { target: region } = event;
        if (!(region instanceof HTMLElement)) return;
        isEnter = true;
    }

    function ondragover(event: DragEvent): void {
        event.preventDefault();
    }

    function ondragleave(event: DragEvent): void {
        event.preventDefault();
        const { target: region } = event;
        if (!(region instanceof HTMLElement)) return;
        isEnter = false;
    }

    function ondrop(event: DragEvent): void {
        event.preventDefault();
        const { dataTransfer } = event;
        if (!dataTransfer) return;
        if (!(inputFile instanceof HTMLInputElement)) return;

        const { files } = dataTransfer;
        setFiles(inputFile, files, multiple);

        if (form instanceof HTMLElement) {
            form.requestSubmit();
        }

        isEnter = false;
    }

    /**
     * Hace click sobre el elemento `inputFile`
     *
     * @param event Evento de Mouse.
     */
    function onclick(): void {
        if (!(inputFile instanceof HTMLInputElement)) return;
        inputFile.click();
    }

    /**
     * Solicita el envío del formulario si tiene archivos
     *
     * @param event Evento Change
     */
    function onchange(event: Event): void {
        const { target: input } = event;
        if (!(input instanceof HTMLInputElement)) return;
        if (!(form instanceof HTMLFormElement)) return;

        const { files } = input;
        if (!files) return;

        const { length } = files;
        if (length < 1) return;

        form.requestSubmit();
    }
</script>

<form
    {action}
    method="post"
    enctype="multipart/form-data"
    {onsubmit}
    bind:this={form}
>
    {#if accept}
        <input
            type="file"
            {accept}
            {name}
            {multiple}
            bind:this={inputFile}
            {onchange}
        />
    {:else}
        <input type="file" {name} {multiple} bind:this={inputFile} {onchange} />
    {/if}
</form>

<div
    class="dropzone"
    {ondragenter}
    {ondragleave}
    {ondragover}
    {ondrop}
    role="region"
    style="--progress: {progress}%"
    class:dropzone--copying={initialized}
    class:dropzone--dragenter={isEnter}
    data-title={dragEnterTitle}
>
    <section class="dropzone__inner">
        <header class="dropzone__header">
            <h2 class="dropzone__title">
                <IconFiles />
                <span>Cargue sus archivos aquí</span>
            </h2>
        </header>

        <div class="dropzone__content">
            <ButtonPrimary type="button" {onclick}>
                {#snippet content()}
                    {#if buttonContent}
                        {@render buttonContent()}
                    {:else}
                        <IconUpload />
                        <span>Subir archivos</span>
                    {/if}
                {/snippet}
            </ButtonPrimary>
            <h3 class="dropzone__subtitle">
                Arrastra tus archivos aquí o pégalos con Ctrl + V
            </h3>

            <p>
                El formulario también permite seleccionar archivos desde tu
                dispositivo. Puedes usar el botón, arrastrar y soltar, o copiar
                y pegar.
            </p>
        </div>
    </section>

    <section class="dropzone__info" class:dropzone__info--loading={inProgress}>
        <div>
            {#if multiple}
                <span>Copiando archivos al servidor</span>
            {:else}
                <span>Copiando archivo al servidor</span>
            {/if}

            <div class="dropzone__progress">
                {Math.ceil(progress)}%
            </div>
        </div>
    </section>
</div>

<div class="watermark">
    <IconFiles />
</div>

<NotificationFile
    bind:open
    bind:error={errorStatus}
    bind:success
    bind:info
    bind:warning
    bind:add
>
    {#snippet content()}
        <span>{message}</span>
    {/snippet}
</NotificationFile>

<style>
    [type="file"] {
        display: none;
    }

    .dropzone {
        display: flex;
        align-items: center;
        justify-content: center;
    }
</style>
