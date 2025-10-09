import type { HTMLAttributeAnchorTarget } from "svelte/elements";

export interface ILink {
    href: string;
    title?: string;
    target?: HTMLAttributeAnchorTarget | null | undefined;
    ariaLabel?: string;
    className?: string;
    native: boolean;
}