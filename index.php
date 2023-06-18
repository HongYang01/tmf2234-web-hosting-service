<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="/assets/image/logo.svg" type="image/x-icon">
    <link rel="stylesheet" href="/css/main.css">
    <script src="/js/effect.js"></script>
    <title>Semicolonix</title>
</head>

<body>

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

    <div id="loader">
        <iframe src="/assets/loading.svg" title="logo"></iframe>
    </div>

    <?php
    require_once($_SERVER['DOCUMENT_ROOT'] . "/includes/nav.php");
    ?>

    <div class="main-container">

        <div class="title flex-row middle around">

            <div class="title-content">
                <h1 class="c1 text-title">Your Website Deserves A Home</h1>
                <p class="black text-normal font-w-400">Semicolonix aims to address common challenges such as lack of knowledge, inefficient servers, and poor technical support that hinder people from adopting web hosting services.</p>

                <div class="black text-normal" style="margin-top:30px;">
                    <p class="flex-row middle"><span class='icon-tick'></span> Beginner Friendly</p>
                    <p class="flex-row middle"><span class='icon-tick'></span>Support Organization</p>
                </div>

            </div>

            <iframe id="image-cover" src="/assets/image/index_image.svg" title="logo"></iframe>

        </div>

        <section id="world-map" class="flex-col middle" style="background-color: var(--color-c1);">
            <h1 class="c3 text-title margin-0">Server Colocation</h1>
            <iframe id="image-2" src="/assets/image/world_map.svg" title="logo"></iframe>
        </section>

        <section id="hosting-type-layout">

            <h1 class="c1 text-title margin-0">Our Hosting Services</h1>

            <div id="hosting-type-grid">
                <a href="/pages/shared_hosting_pricing.php">Shared</a>
                <a href="/pages/vps_hosting_pricing.php">VPS</a>
                <a href="/pages/dedicated_hosting_pricing.php">Dedicated</a>
            </div>

        </section>

    </div>

    <?php
    require_once($_SERVER['DOCUMENT_ROOT'] . "/includes/footer.php");
    ?>

</body>

</html>