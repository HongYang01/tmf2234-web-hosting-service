<?php
/*######################################*
||              Includes              ||
*######################################*/

require_once($_SERVER['DOCUMENT_ROOT'] . "/config/conn.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/auth/auth_session.php");

/*######################################*
||           Check Identity           ||
*######################################*/

require_once($_SERVER['DOCUMENT_ROOT'] . "/auth/CheckLogin.php");
if (!checkLoggedIn() || $_SESSION['role'] != "admin") {
    mysqli_close($conn);
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
    <link rel="stylesheet" href="/css/admin-sales-analytics.css">
    <script src="/js/effect.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="/js/admin_sales_analytics.js"></script>
    <title>Sales Analytics</title>
</head>

<body>

    <div id="loader">
        <iframe src="/assets/loading.svg" title="logo"></iframe>
    </div>

    <div id="popup-fade-msg"></div>

    <?php require_once($_SERVER['DOCUMENT_ROOT'] . "/includes/nav.php"); ?>

    <div class="main-container middle">
        <h1 class="c1 text-title" style="margin-bottom: 30px;">Sales Analytics</h1>

        <div class="charts flex-col">
            <div class="charts-card">
                <div class="chartBox">
                    <canvas id="lineChart"></canvas>
                </div>
            </div>
            <div class="charts-card">
                <div class="chartBox">
                    <canvas id="pieChart"></canvas>
                </div>
            </div>
        </div>

    </div>

    <?php require_once($_SERVER['DOCUMENT_ROOT'] . "/includes/footer.php"); ?>

</body>

</html>