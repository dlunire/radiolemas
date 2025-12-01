<script lang="ts">
    import { onMount } from "svelte";

    export let dashboard: boolean = false;
    export let home: boolean = false;
    export const content: Function | undefined = undefined;
    export let id: string = "header";
    export let tokens: string[] = [];

    let header: HTMLElement | null = null;

    onMount(() => {
        const root: HTMLElement | null = document.body.closest("html");
        if (!(root instanceof HTMLElement) || !(header instanceof HTMLElement))
            return;

        const size: DOMRect = header.getBoundingClientRect();
        root.style.setProperty("--header-height", `${size.height}px`);

        const newTokens: string[] = tokens.filter((token) => {
            return Boolean(
                !header?.classList.contains(token) && token.trim().length > 0,
            );
        });

        header.classList.add(...newTokens);
    });
</script>

<header
    class="header"
    class:header--dashboard={dashboard}
    class:header--home={home}
    {id}
    bind:this={header}
>
    <div
        class="header__inner"
        class:header__inner--dashboard={dashboard}
        class:header__inner--home={home}
    >
        <slot>Agregue su componente aqui</slot>
    </div>

    <slot name="nav"></slot>
</header>
