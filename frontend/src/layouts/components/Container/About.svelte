<script lang="ts">
    let about: string | undefined = undefined;
</script>

<section class="section section--home section--news" id="tendencies">
    <div class="section__inner section__inner--article">
        <h2
            class="section__title section__title--news"
            aria-label="Acerca de nosotros"
        >
            Acerca de nosotros
        </h2>

        <div class="about">
            {#if about}
                {@html about}
            {:else}
                <p>
                    Lorem ipsum dolor sit amet consectetur adipisicing elit.
                    Asperiores numquam, dolores explicabo maxime ad ex eveniet
                    adipisci earum, omnis odio suscipit soluta voluptas
                    temporibus reprehenderit beatae consequuntur aperiam quis,
                    facere laudantium a nulla. Consequuntur ratione, quos
                    assumenda blanditiis beatae facere.
                </p>

                <p>
                    Lorem ipsum dolor sit, amet consectetur adipisicing elit.
                    Quidem suscipit vitae nemo pariatur harum reiciendis
                    doloribus non quos! Nulla sint rem exercitationem reiciendis
                    nam tenetur expedita, provident aliquid culpa. Suscipit
                    accusantium itaque illo saepe ab tenetur, molestiae ea
                    eveniet nesciunt!
                </p>

                <h3 class="about__title">Misión</h3>
                <p>
                    Lorem, ipsum dolor sit amet consectetur adipisicing elit.
                    Ipsum nostrum dolor eum reprehenderit, iusto cum ratione et
                    iure maiores quibusdam assumenda maxime quae minima error
                    libero. Dicta exercitationem omnis hic sit at! Sed itaque
                    quia ea. Libero minus nulla illum?
                </p>

                <h3 class="about__title">Visión</h3>
                <p>
                    Lorem ipsum dolor sit, amet consectetur adipisicing elit.
                    Amet nostrum provident harum architecto in neque ex
                    assumenda sequi iusto nulla eum ipsa voluptates labore,
                    voluptate atque distinctio fugiat! Voluptas itaque
                    reprehenderit unde dolore a illo fuga quas distinctio
                    quibusdam deserunt.
                </p>
                <p>
                    Consequatur magnam atque explicabo, eos repellendus tempora
                    eum enim a officia sit reiciendis voluptas quibusdam beatae
                    fuga est incidunt sapiente tenetur nulla nihil totam
                    possimus quidem laudantium corporis? At dicta commodi
                    molestias deleniti pariatur explicabo aspernatur iure magnam
                    quos esse.
                </p>
                <p>
                    Harum inventore natus et quibusdam eligendi! Excepturi
                    nesciunt praesentium deserunt at, officiis ut, perspiciatis
                    magnam ad laboriosam, quod fugiat nobis perferendis
                    obcaecati adipisci nihil dolores sapiente! Nobis omnis
                    possimus aperiam sint animi odit voluptatibus eaque
                    recusandae tenetur, in inventore totam!
                </p>
            {/if}
        </div>
    </div>
</section>
