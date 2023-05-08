<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="/assets/image/logo.svg" type="image/x-icon">
    <link rel="stylesheet" href="/css/main.css">
    <link rel="stylesheet" href="/css/login_singup_form.css">
    <script src="/js/effect.js"></script>
    <script src="/js/login_form.js" defer></script>
    <title>Login Semicolonix</title>
</head>

<body class="flex-col">

    <div id="loader">
        <iframe src="/assets/loading.svg" title="logo"></iframe>
    </div>

    <div id="popup-fade-msg"></div>

    <?php
    require_once($_SERVER['DOCUMENT_ROOT'] . "/includes/nav.php");
    ?>

    <div class="main-container center middle">

        <div class="w-100 flex-row around ">

            <iframe id="image-cover" src="/assets/image/login-cover.svg" title="cover"></iframe>

            <div id="form-layout">

                <h1 class="c1 text-h1">Login</h1>

                <form id="form-component" method="post">
                    <input type="email" name="email" id="email" placeholder="Email" required>
                    <span id="err-msg-1"></span>
                    <input type="password" name="password" id="password" placeholder="Password" required>
                    <span id="err-msg-2"></span>
                    <input type="submit" name="submit" id="submit" value="Login">
                </form>

                <div class="flex-col center middle text-normal">
                    <p>Not yet have an account?</p>
                    <a href="/pages/signup_form.php" class="underline">Sign Up Now</a>
                </div>

            </div>

        </div>


    </div>

    <?php
    require_once($_SERVER['DOCUMENT_ROOT'] . "/includes/footer.php");
    ?>

</body>

</html>