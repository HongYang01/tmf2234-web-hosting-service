<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="/assets/image/logo.svg" type="image/x-icon">
    <link rel="stylesheet" href="/css/main.css">
    <link rel="stylesheet" href="/css/signup.css">
    <script src="/js/effect.js"></script>
    <title>Login Semicolonix</title>
</head>

<body class="flex-col">

    <div id="loader">
        <iframe src="/assets/loading.svg" title="logo"></iframe>
    </div>

    <?php
    require_once("includes/nav.php");
    ?>

    <div class="flex-grow-1 header-container">

        <div id="signup">
            <p class="text-h1">Login</p>

            <form class="flex-col center" action="/auth/login_handler.php" method="post">
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Password" required>
                <input type="submit" name="submit" value="Login">
            </form>

            <div class="flex-col font-second black font-w-400 center">
                <p>Not yet have an account?</p>
                <a href="/pages/signup_form.php">Sign Up Now</a>
            </div>

        </div>
    </div>

    <?php
    include("includes/footer.php");
    ?>

</body>

</html>