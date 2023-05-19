<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/config/conn.php");
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="/assets/image/logo.svg" type="image/x-icon">
    <link rel="stylesheet" href="/css/main.css">
    <link rel="stylesheet" href="/css/paypal_4_success.css">
    <script src="/js/effect.js"></script>
    <title>Payment Successful</title>
</head>

<body class="flex-col">

    <div id="loader">
        <iframe src="/assets/loading.svg" title="logo"></iframe>
    </div>

    <?php
    require_once($_SERVER['DOCUMENT_ROOT'] . "/includes/nav.php");
    require_once($_SERVER['DOCUMENT_ROOT'] . "/auth/auth_session.php");

    if (!isset($_SESSION['payment_status']) || empty($_SESSION['payment_status'])) {
        header("Location: /index.php");
        exit;
    } else {
        unset($_SESSION['payment_status']);
    }

    ?>

    <div class="flex-grow-1 flex-col center middle">
        <div>

            <p>- add plan countdown</p>

            <?php
            $paymentid = $_GET['payid'];
            $results = mysqli_query($conn, "SELECT * FROM payments WHERE payment_id='$paymentid'");
            if (!mysqli_num_rows($results) == 1) {
                echo "<p>Payment failed, payment history <b>not found</b></p>";
                exit;
            } else {
                $row = mysqli_fetch_array($results);
                echo "<h1>Thank you for your payment</h1>";
                echo "<div class='info-card'>";
                echo "<h4 class='flex-row middle'>Total Paid Amount: " . $row['payment_amount'] . "<span class='text-normal'> " . $row['currency_code'] . "/month</span></h4>";
                echo "<h4>Payment Information</h4>";
                echo "<p>Reference Number: " . $row['invoice_id'] . "</p>";
                echo "<p>Transaction ID: " . $row['transaction_id'] . "</p>";
                echo "<p>Payment Status: " . $row['payment_status'] . "</p>";
                echo "<h4>Product Information</h4>";
                echo "<p>Product id: " . $row['product_id'] . "</p>";
                echo "<p>Product Name: " . $row['product_name'] . "</p>";
                echo "</div>";
            }
            mysqli_close($conn);
            ?>

            <a id="home" href="/pages/myprofile.php">Back</a>
        </div>
    </div>
    <?php
    require_once($_SERVER['DOCUMENT_ROOT'] . "/includes/footer.php");
    ?>
</body>

</html>