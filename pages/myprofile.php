<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="/assets/image/logo.svg" type="image/x-icon">
    <link rel="stylesheet" href="/css/main.css">
    <link rel="stylesheet" href="/css/myprofile.css">
    <script src="/js/effect.js"></script>
    <script src="/js/confirm_logout.js" async defer></script>
    <title>My Profile</title>
</head>

<body class="flex-col">

    <div id="loader">
        <iframe src="/assets/loading.svg" title="logo"></iframe>
    </div>

    <?php
    require_once("auth/auth_session.php");

    if (!isset($_SESSION['loggedin']) || !$_SESSION['loggedin']) {
        header("Location: /pages/login_form.php");
    } else {
        require_once("includes/nav.php");
    }
    ?>


    <div class="flex-grow-1 flex-col center middle font-second">

        <?php
        require_once("auth/auth_session.php");
        echo "<p>" . $_SESSION['role'] . "</p>";
        echo "<p>" . $_SESSION['email'] . "</p>";
        echo "<p>" . $_SESSION['fname'] . "</p>";
        echo "<p>" . $_SESSION['lname'] . "</p>";
        ?>

        <button data-open-modal id="logout-btn">Logout</button>

        <?php
        require_once("auth/auth_session.php");
        if ($_SESSION['role'] == "admin") {
            echo "<a href='/admin/dashboard.php'>Goto Dashboard</a>";
        }
        ?>

    </div>

    <dialog data-modal>

        <h1>Confirm Logout</h1>
        <p>Are you sure you want to log out?</p>

        <div class="w-100 flex-row around center middle">
            <button id="confirm-btn">Yes, Logout</button>
            <button data-close-modal id="cancel-btn">Cancel</button>
        </div>

    </dialog>

    <?php
    include("includes/footer.php");
    ?>

</body>

</html>