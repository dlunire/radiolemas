<script lang="ts">
    export let title: string = "Título de la noticia"
    export let category: string = "Nombre de categoría";
</script>
<article class="trend__item">
    <header class="trend__item-header">Foto</header>

    <div class="trend__item-content">
        <span class="trend__item-label">{category}</span>
        <h2 class="trend__item-title" aria-label="{title}">
            {title}
        </h2>
        <div class="trend__item-resume">
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Nesciunt, quas ducimus. Minima velit...
        </div>
    </div>
</article>
