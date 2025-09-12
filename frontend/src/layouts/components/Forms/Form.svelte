<script lang="ts">
    import { onMount } from "svelte";
    import type { Method } from "./Interface/Method";
    import { getData, request } from "./lib/request";
    import type {
        ResponseData,
        ResponseServer,
    } from "./Interface/ResponseServer";
    import NotificationFile from "../Notifications/NotificationFile.svelte";
    import { getFullURL } from "../../routers/sources/router";

    export let method: Method = undefined;
    export let action: string = "/";
    export let className: string = "";
    export let content: Function | undefined = undefined;
    export let loading: boolean = false;
    export let redirect: string | undefined = undefined;
    export let backredirect: string | undefined = undefined;
    export let autocomplete: AutoFillBase | null | undefined = "on";

    let currentData: ResponseData | undefined = undefined;
    let open: boolean = false;
    let error: boolean = false;
    let success: boolean = false;

    async function onsubmit(event: SubmitEvent): Promise<void> {
        event.preventDefault();
        if (!method) return;

        const { target: form } = event;
        if (!(form instanceof HTMLFormElement)) return;

        const requireds = form.querySelectorAll("[aria-required='true']");

        for (const input of requireds) {
            if (!(input instanceof HTMLInputElement)) continue;
            if (!input.required) continue;
            if (input.type != "hidden") continue;

            if (input.value.trim().length < 1) {
                const button: HTMLButtonElement | null = form.querySelector(
                    `[data-name="${input.name}"]`,
                );

                if (!(button instanceof HTMLButtonElement)) return;

                setTimeout(() => {
                    button.classList.remove("button--error");
                });

                setTimeout(() => {
                    button.classList.add("button--error");
                }, 50);
                return;
            }
        }
        const formData: FormData = new FormData(form);
        const fields = Object.fromEntries(formData.entries());

        let data: ResponseServer;

        loading = true;
        if (method.toLowerCase() == "get") {
            data = (await request(action, {
                credentials: "include",
                method: "GET",
            })) as ResponseServer;
        } else {
            data = (await request(action, {
                credentials: "include",
                method: method ?? "POST",
                body: JSON.stringify(fields),
            })) as ResponseServer;
        }
        loading = false;

        currentData = getData(data.data);
        open = true;
        error = currentData.error;
        success = !currentData.error;

        if (redirect && success) {
            const anchor: HTMLAnchorElement = document.createElement("a");
            const href: string = getFullURL(redirect);
            anchor.href = href;

            setTimeout(() => {
                anchor.click();
                anchor.remove();
            }, 1000);
        }

        if (backredirect && error) {
            const anchor: HTMLAnchorElement = document.createElement("a");
            const href: string = getFullURL(backredirect);
            anchor.href = href;

            setTimeout(() => {
                anchor.click();
                anchor.remove();
            }, 1000);
        }
    }

    let form: HTMLFormElement | null = null;

    onMount(() => {
        if (!(form instanceof HTMLFormElement)) return;
        const classNames: string[] = className.split(/\s+/);
        form.classList.add(...classNames);
    });
</script>

<form
    {action}
    method="post"
    class="form"
    {onsubmit}
    bind:this={form}
    {autocomplete}
>
    {#if content}
        {@render content()}
    {:else}
        <span>Agregue contenido al formulario</span>
    {/if}
</form>

<NotificationFile bind:open bind:error bind:success>
    {#snippet content()}
        {#if currentData}
            <span>{currentData.message}</span>
        {/if}
    {/snippet}
</NotificationFile>
