<script lang="ts">
    let { onclick, content } = $props();
</script>

<button class="button button--normalize button--reset" type="reset" {onclick}>
    {@render content()}
</button>
