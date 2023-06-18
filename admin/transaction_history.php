<?php
/*######################################*
||              Includes              ||
*######################################*/

require_once($_SERVER['DOCUMENT_ROOT'] . "/config/conn.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/auth/auth_session.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/handlers/get_all_transaction.php");

/*######################################*
||           Check Identity           ||
*######################################*/

require_once($_SERVER['DOCUMENT_ROOT'] . "/auth/CheckLogin.php");
if (!checkLoggedIn() || $_SESSION['role'] != "admin") {
    mysqli_close($conn);
    header("Location: /pages/login_form.php");
    exit;
}

$allTrans = getAllTransaction();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="/assets/image/logo.svg" type="image/x-icon">
    <link rel="stylesheet" href="/css/main.css">
    <link rel="stylesheet" href="/css/admin-transaction-history.css">
    <script src="/js/effect.js"></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/moment-timezone/0.5.33/moment-timezone-with-data-10-year-range.min.js'></script>
    <script src='/js/myDateFormat.js'></script>
    <title>Transaction History</title>
</head>

<body>

    <div id="loader">
        <iframe src="/assets/loading.svg" title="logo"></iframe>
    </div>

    <?php require_once($_SERVER['DOCUMENT_ROOT'] . "/includes/nav.php"); ?>

    <div class="main-container">

        <div class="grid-layout">
            <div class="grid-1">
                <table id="transaction-detail-table">
                    <caption class="c1 font-primary text-h1 font-w-700">Transaction History</caption>
                    <tr>
                        <th>No</th>
                        <th>ID</th>
                        <th>Status</th>
                        <th>Subscription ID</th>
                        <th>Gross ($)</th>
                        <th>Paypal Fee ($)</th>
                        <th>Net ($)</th>
                        <th>Paypal Datetime</th>
                    </tr>
                    <?php

                    $count = 0;

                    foreach ($allTrans as $temp) {

                        echo "<tr>";
                        echo "<td>" . ++$count . "</td>";
                        echo "<td>" . $temp['trans_id'] . "</td>";
                        echo "<td>" . $temp['trans_status'] . "</td>";
                        echo "<td id='show-sub-detail' data-sub-id='" . $temp['trans_sub_id'] . "' title='click to show details'>" . $temp['trans_sub_id'] . "</td>";
                        echo "<td>" . $temp['trans_gross_amount'] . "</td>";
                        echo "<td>" . $temp['trans_fee_amount'] . "</td>";
                        echo "<td>" . $temp['trans_net_amount'] . "</td>";
                        echo "<td>" . $temp['trans_datetime'] . "</td>";
                        echo "</tr>";
                    }

                    ?>
                </table>
            </div>

            <div class="grid-2">
                <h1 class="c1 font-primary text-h1 font-w-700">Details</h1>
                <div id="popup-detail"></div>
            </div>
        </div>

    </div>

    <?php require_once($_SERVER['DOCUMENT_ROOT'] . "/includes/footer.php"); ?>
    <script src="/js/admin_transaction_history.js"></script>
</body>

</html>