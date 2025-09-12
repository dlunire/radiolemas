import { writable, type Writable } from "svelte/store";

export const buttonsExists: Writable<boolean> = writable<boolean>(false);