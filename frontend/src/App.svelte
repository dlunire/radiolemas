<script lang="ts">
  import Dashboard from "./layouts/pages/admin/Dashboard.svelte";
  import Router from "./layouts/routers/components/Router.svelte";
  import { getFullURL, getPathname } from "./layouts/routers/sources/router";

  let routes: string[] = [
    getFullURL("/install/credentials"),
    getFullURL("/credentials/check"),
    getFullURL("/create/user"),
    getFullURL("/login"),
  ];
</script>

<main>
  {#if routes.includes(getFullURL(getPathname()))}
    <Router />
  {:else}
    <Dashboard />
  {/if}
</main>
