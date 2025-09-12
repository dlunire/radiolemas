import { writable, type Writable } from "svelte/store";

export const openStudents: Writable<boolean> = writable<boolean>(false);