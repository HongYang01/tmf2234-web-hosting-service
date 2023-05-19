<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="/assets/image/logo.svg" type="image/x-icon">
    <link rel="stylesheet" href="/css/main.css">
    <link rel="stylesheet" href="/css/admin-dashboard.css">
    <script src="/js/effect.js"></script>
    <title>Semicolonix Admin</title>
</head>

<body class="flex-col">

    <!-- 
        show admin
        show name
        show email
        show section 1 (product)
        show section 2 (analytics)
        show section 3 (transaction history)
        show section 4 (registered customer - show registered date)
    -->

    <div id="loader">
        <iframe src="/assets/loading.svg" title="logo"></iframe>
    </div>

    <?php

    require_once($_SERVER['DOCUMENT_ROOT'] . "/auth/auth_session.php");
    require_once($_SERVER['DOCUMENT_ROOT'] . "/auth/CheckLogin.php");

    if (!checkLoggedIn()) {
        header("Location: /pages/login_form.php");
        exit;
    }

    require_once($_SERVER['DOCUMENT_ROOT'] . "/includes/nav.php");

    ?>

    <div class="main-container">

        <div class="head">
            <span class="icon-dashboard"></span>
            <h1 class="text-title font-w-300">Admin Dashboard</h1>
        </div>

        <div class="dashboard-layout">

            <div class="dashboard-component">
                <a href="/admin/manage_price_plan.php">Manage <br> Pricing Plan</a>
            </div>

            <div class="dashboard-component">
                <span></span>
                <a href="">Sales Analytics</a>
            </div>

            <div class="dashboard-component">
                <span></span>
                <a href="">Transaction History</a>
            </div>

            <div class="dashboard-component">
                <span></span>
                <a href="">Customer Info</a>
            </div>

        </div>

    </div>


    <?php require_once($_SERVER['DOCUMENT_ROOT'] . "/includes/footer.php"); ?>

</body>

</html>