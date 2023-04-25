<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="/asset/image/logo.svg" type="image/x-icon">
    <link rel="stylesheet" href="/css/main.css">
    <script src="/js/effect.js"></script>
    <title>Sign Up Semicolonix</title>
</head>

<body>

    <div id="loader">
        <iframe src="/asset/loading.svg" title="logo"></iframe>
    </div>

    <?php
    $ds = DIRECTORY_SEPARATOR;
    require_once(__DIR__ . "{$ds}..{$ds}php{$ds}nav.php");
    ?>


    <div id="signup">
        <p class="text-h1">Sign Up</p>

        <form action="/php/register.php" method="post">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email"><br><br>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password"><br><br>
            <label for="confirm_password">Confirm Password:</label>
            <input type="password" id="confirm_password" name="confirm_password"><br><br>
            <input type="submit" value="Submit">
            <input type="reset" value="Cancel">
        </form>
    </div>

</body>

</html>