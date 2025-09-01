<?php
ini_set('display_errors', 1);

include dirname(__DIR__) . "/key.php";

/** @var string $key */
$key = Key::generate();
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sitio Web en construcción </title>

    <link rel="stylesheet" href="style.css?<?= Key::get_css_hash() ?>">
    <link rel="icon" href="favicon.png" type="image/png">

    <!-- No quitar estas líneas -->
    <!-- Su función es prevenir la ejecución de scripts no autorizados -->
    <meta http-equiv="Content-Security-Policy" content="
        script-src 'nonce-<?= $key ?>';
        object-src 'none';
        base-uri 'none';
        img-src 'self';
        connect-src 'self' https://api.tawk.to;
        frame-src https://embed.tawk.to; ">
</head>

<body>
    <main>
        <section class="wrapper container">
            <picture class="picture">
                <source class="picture__source" type="image/png" src="./logo.png" srcset="./logo.png">
                <img class="picture__image" src="./logo.png" alt="Logotipo">
            </picture>

            <div class="controls">
                <button class="button button--play" aria-label="Reproducir" id="play">
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