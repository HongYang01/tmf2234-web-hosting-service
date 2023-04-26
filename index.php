<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="/asset/image/logo.svg" type="image/x-icon">
    <link rel="stylesheet" href="/css/main.css">
    <script src="/js/effect.js"></script>
    <title>Semicolonix</title>
</head>

<body>

    <div id="loader">
        <iframe src="/asset/loading.svg" title="logo"></iframe>
    </div>

    <?php
    $ds = DIRECTORY_SEPARATOR;
    require_once(__DIR__ . "{$ds}php{$ds}nav.php");
    ?>

    <div id="layout" class="flex-col">

        <!-- <div class="flex-row">
            <p class="middle">Color Palette</p>
            <div class="color-palette flex-row">
                <span class="black" title="Black"></span>
                <span class="c1" title="c1"></span>
                <span class="c2" title="c2"></span>
                <span class="c3" title="c3"></span>
                <span class="c4" title="c4"></span>
            </div>
        </div> -->

        <header class="header-container flex-row middle">

            <div class="header-left flex-col middle">
                <!-- left -->
                <h1 class="c1 text-title">Your Website Deserves A Home</h1>
                <p class="font-second font-w-600">Lorem ipsum dolor sit amet consectetur adipisicing elit. Illum beatae minima, iure, tempora atque saepe quo veniam unde architecto quia voluptas, rem officia. Itaque quisquam doloremque illo, voluptatibus ipsa eos.</p>

            </div>

            <div class="header-right middle">
                <!-- right -->
                <iframe id="image-1" src="/asset/image/index_image.svg" title="logo"></iframe>
            </div>

        </header>

        <section class="flex-col center">
            <h1 class="c3 text-title" style="margin: 24px 0;">Server Location</h1>
            <iframe id="image-2" src="/asset/image/world_map.svg" title="logo"></iframe>
        </section>

        <footer class="flex-row between">
            <p class="font-second font-w-400">Semicolonix Group Project @UNIMAS</p>
            <p class="font-second font-w-400">for educational purposes only</p>
        </footer>

    </div>

</body>

</html>