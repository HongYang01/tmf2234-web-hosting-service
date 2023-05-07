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
    <script src="/js/signup_form.js" defer></script>
    <title>Sign Up Semicolonix</title>
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

        <div id="form-layout">

            <h1 class="c1 text-h1">Sign Up Now</h1>

            <form id="form-component" method="post">

                <input type="text" name="fname" id="fname" placeholder="Firstname" required>
                <input type="text" name="lname" id="lname" placeholder="Lastname" required>
                <input type="email" name="email" id="email" placeholder="Email" onblur="checkEmailValidity(this.value)" required>
                <span id="err-msg-1"></span>
                <input type="password" name="password" id="password" placeholder="Password" required>
                <span id="err-msg-2"></span>
                <input type="password" name="confirm_password" id="confirm_password" placeholder="Confirm password" required>
                <span id="err-msg-3"></span>

                <input type="submit" name="submit" id="submit" value="Signup">

            </form>

            <div class="flex-col center middle text-normal">
                <p>Already have an account?</p>
                <a href="/pages/login_form.php" class="underline">Login</a>
            </div>

        </div>
    </div>

    <?php
    require_once($_SERVER['DOCUMENT_ROOT'] . "/includes/footer.php");
    ?>

</body>

</html>