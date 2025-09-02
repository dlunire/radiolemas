<?php
ini_set('display_errors', 1);

include dirname(__DIR__) . "/key.php";

/** @var string $key */
$key = Key::generate();

/** @var string $logo */
$logo = "./logo.png?" . Key::get_logo_hash();
?>
<!DOCTYPE html>
<html lang="es-CO">

<head>
    <!-- No quitar estas líneas -->
    <!-- Su función es prevenir la ejecución de scripts no autorizados -->
    <meta http-equiv="Content-Security-Policy" content="script-src 'nonce-<?= $key ?>'; object-src 'none'; base-uri 'none'; img-src 'self';">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Radio Lemas Cúcuta - Sitio Web en construcción</title>

    <link rel="stylesheet" href="style.css?<?= Key::get_css_hash() ?>">
    <link rel="icon" href="favicon.png" type="image/png">

    <!-- Open Graph -->
    <meta property="og:title" content="Radio Lemas Cúcuta" />
    <meta property="og:description" content="Escucha Radio Lemas en vivo. Sitio oficial en construcción con acceso al streaming de la emisora." />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="https://radiolemas.com/" />
    <meta property="og:image" content="https://radiolemas.com/preview.png" />
    <meta property="og:locale" content="es_CO" />

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="Radio Lemas Cúcuta" />
    <meta name="twitter:description" content="Escucha Radio Lemas en vivo. Sitio oficial en construcción con acceso al streaming de la emisora." />
    <meta name="twitter:image" content="https://radiolemas.com/preview.png" />

</head>

<body>
    <main>
        <section class="wrapper container">
            <picture class="picture">
                <source class="picture__source" type="image/png" src="<?= $logo ?>" srcset="<?= $logo ?>">
                <img class="picture__image" src="<?= $logo ?>" alt="Logotipo">
            </picture>

            <div class="controls">
                <button class="button button--play" aria-label="Reproducir" id="play" title="Escuchar en vivo">
                    <div class="button__item button__item--play" data-hidden="false">
                        <?= Key::get_play() ?>
                    </div>

                    <div class="button__item button__item--pause" data-hidden="true">
                        <?= Key::get_pause() ?>
                    </div>
                </button>

                <label for="volume" class="volume">
                    <input type="range" name="volume" id="volume" step="0.1" min="0" max="1" class="volume__input">
                    <div id="volume-label" class="volume__label">Volumen (<span>50</span>%)</div>
                </label>
            </div>

            <h1>Radio Lemas</h1>
            <h2>Sitio web en construcción</h2>
        </section>
    </main>
</body>

<script type="module" src="./script.js?<?= key::get_js_hash() ?>" nonce="<?= $key ?>"></script>

</html>