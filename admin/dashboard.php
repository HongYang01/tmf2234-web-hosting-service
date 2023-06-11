<?php
/*######################################*
||              Includes              ||
*######################################*/

require_once($_SERVER['DOCUMENT_ROOT'] . "/auth/auth_session.php");

/*######################################*
||           Check Identity           ||
*######################################*/

require_once($_SERVER['DOCUMENT_ROOT'] . "/auth/CheckLogin.php");
if (!checkLoggedIn() || $_SESSION['role'] != "admin") {
    header("Location: /pages/login_form.php");
    exit;
}
?>

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

<body>

    <div id="loader">
        <iframe src="/assets/loading.svg" title="logo"></iframe>
    </div>

    <?php
    require_once($_SERVER['DOCUMENT_ROOT'] . "/includes/nav.php");
    ?>

    <div class="main-container">

        <div class="head">
            <span class="icon-dashboard"></span>
            <h1 class="text-title font-w-300">Admin Dashboard</h1>
        </div>

        <div class="dashboard-layout">

            <div class="dashboard-component">
                <span></span>
                <a href="/admin/manage_price_plan.php">Manage <br> Pricing Plan</a>
            </div>

            <div class="dashboard-component">
                <span></span>
                <a href="/admin/sales_analytics.php">Sales Analytics</a>
            </div>

            <div class="dashboard-component">
                <span></span>
                <a href="/admin/transaction_history.php">Transaction History</a>
            </div>

            <div class="dashboard-component">
                <span></span>
                <a href="/admin/customer_info.php">Customer Info</a>
            </div>

        </div>

    </div>


    <?php require_once($_SERVER['DOCUMENT_ROOT'] . "/includes/footer.php"); ?>

</body>

</html>