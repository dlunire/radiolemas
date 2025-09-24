<script lang="ts">
    import { getFullURL, navigate } from "../sources/router";

    export let href: string;
    export let title: string = "";
    export let target: string = "_top";
    export let ariaLabel: string = "";
    export let className: string = "";
    export let native: boolean = false;
    export let rel: string = "follow";
    function onclick(event: MouseEvent) {
        if (native) return;

        event.preventDefault();
        navigate(href);
    }

    $: safeRel = target === "_blank" ? "noopener noreferrer" : rel;
</script>

<a
    href={native ? getFullURL(href) : href}
    {onclick}
    {title}
    {target}
    aria-label={ariaLabel}
    class={className}
    rel={safeRel}
>
    <slot />
</a>
