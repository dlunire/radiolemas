<script lang="ts">
    import type { Unsubscriber } from "svelte/store";
    import { buttonsExists } from "../../../lib/store/store";
    import IconHelp from "../../icons/IconHelp.svelte";
    import IconSettings from "../../icons/IconSettings.svelte";
    import { navigate } from "../../routers/sources/router";
    import { onDestroy } from "svelte";

    export let openHelp: boolean = false;
    let exists: boolean = false;

    function gotoSettings(event: MouseEvent): void {
        const { target: button } = event;
        if (!(button instanceof HTMLButtonElement)) return;
        navigate("/dashboard/settings");
    }

    function gotoHelp(event: MouseEvent): void {
        const { target: button } = event;
        if (!(button instanceof HTMLButtonElement)) return;
        openHelp = true;
    }

    const unsubscribe: Unsubscriber = buttonsExists.subscribe(
        (value: boolean) => {
            exists = value;
        },
    );
    onDestroy(() => {
        unsubscribe();
    });
</script>

<nav class="fixed-buttons">
    <button
        class="button button--nav"
        class:border-left={exists}
        aria-label="Configuración"
        title="Configuración"
        onclick={gotoSettings}
    >
        <IconSettings />
        <span>Configuración</span>
    </button>
    <button class="button button--nav" title="Ayuda" onclick={gotoHelp}>
        <IconHelp />
        <span>Ayuda</span>
    </button>
</nav>

<style lang="scss">
    @use "../../../assets/sass/vars" as *;
    .fixed-buttons {
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .border-left {
        border-left: 1px solid rgba($border-color, 0.35);
    }
</style>
