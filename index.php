<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/main.css">
    <link rel="stylesheet" href="/css/colour-palette.css">
    <link rel="stylesheet" href="/css/nav-bar.css">
    <title>Semicolonix</title>
</head>

<body>

    <div class="flex-row">
        <p>Color Palette</p>
        <div class="color-palette flex-row">
            <span class="gray" title="Gray"></span>
            <span class="black" title="White"></span>
            <span class="orange" title="Orange"></span>
            <span class="paleOrange" title="Pale Orange"></span>
            <span class="peach" title="Peach"></span>
        </div>
    </div>

    <p class="text-title black">Semicolonix Web Host Service</p>

    <?php
    $ds = DIRECTORY_SEPARATOR;
    $base_dir = "C:{$ds}Users{$ds}Administrator{$ds}Desktop{$ds}tmf2234-web-based-assignment{$ds}";
    include_once("{$base_dir}pages{$ds}nav.php");
    ?>

</body>

</html>