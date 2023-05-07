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
    <title>Sign Up Semicolonix</title>
</head>

<body class="flex-col">

    <div id="loader">
        <iframe src="/assets/loading.svg" title="logo"></iframe>
    </div>

    <?php
    require_once($_SERVER['DOCUMENT_ROOT'] . "/includes/nav.php");
    ?>

    <div class="flex-grow-1 header-container">

        <div id="signup">
            <p class="text-h1">Sign Up Now</p>

            <?php
            require_once($_SERVER['DOCUMENT_ROOT'] . "/auth/auth_session.php");
            if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == false) {
                echo "<p>Check Input</p>";
            }
            ?>

            <form action="/handlers/signup_handler.php" method="post">
                <input type="text" name="fname" placeholder="Firstname"><br><br>
                <input type="text" name="lname" placeholder="Lastname"><br><br>
                <input type="email" name="email" placeholder="Your email"><br><br>
                <input type="password" name="password" placeholder="Password"><br><br>
                <input type="password" name="confirm_password" placeholder="Confirm password"><br><br>
                <input type="submit" name="submit" value="Signup">
                <input type="reset" value="Cancel">
            </form>

            <div class="flex-row font-second black font-w-400 center">
                <p>Already have an account?</p>
                <a href="/pages/login_form.php">Login</a>
            </div>

        </div>
    </div>

    <?php
    require_once($_SERVER['DOCUMENT_ROOT'] . "/includes/footer.php");
    ?>


</body>

</html>