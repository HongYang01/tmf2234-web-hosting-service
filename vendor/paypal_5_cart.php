<?php

/*######################################*
||              Includes              ||
*######################################*/
require_once($_SERVER['DOCUMENT_ROOT'] . "/config/conn.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/auth/auth_session.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/vendor/paypal_1_config.php");

$planInfo = array();

/*######################################*
||           Check Identity           ||
*######################################*/

require_once($_SERVER['DOCUMENT_ROOT'] . "/auth/CheckLogin.php");

if (!checkLoggedIn() || $_SESSION['role'] != "user") {
    header("Location: /pages/login_form.php");
    mysqli_close($conn);
    exit;
}

/*######################################*
||          Check POST array          ||
*######################################*/
// planInfo come from /pages/<all plan pages>.php

if (!isset($_POST['planInfo']) || empty($_POST['planInfo'])) { // check if plan_id is set or is empty
    header("Location: /index.php");
    mysqli_close($conn);
    exit;
}

$planInfo = json_decode($_POST['planInfo'], true);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="/assets/image/logo.svg" type="image/x-icon">
    <link rel="stylesheet" href="/css/main.css">
    <link rel="stylesheet" href="/css/cart.css">
    <script src="/js/effect.js"></script>
    <title>Cart | Semicolonix</title>
</head>

<body>

    <div id="loader">
        <iframe src="/assets/loading.svg" title="logo"></iframe>
    </div>

    <div id="popup-fade-msg"></div>

    <?php
    require_once($_SERVER['DOCUMENT_ROOT'] . "/includes/nav.php");
    ?>

    <div class="main-container">

        <div class="cart-container">

            <div class="left-container">

                <div class="left-component-1">
                    <h1 class="c1 text-h1">Order Summary</h1>

                    <div class="flex-row between" style="font-weight: 600; margin-bottom:15px;">
                        <p><?php echo $planInfo['plan_full_name']; ?> - monthly</p>
                        <p>$<?php echo $planInfo['plan_price']; ?></p>
                    </div>

                    <div class="flex-row between">
                        <div class="flex-row middle">
                            <span class="icon-tick"></span>
                            <p>Domain</p>
                        </div>
                        <p><s>$6.00</s></p>
                    </div>

                    <div class="flex-row between">
                        <div class="flex-row middle">
                            <span class="icon-tick"></span>
                            <p>Setup</p>
                        </div>
                        <p><s>$12.00</s></p>
                    </div>

                    <hr>

                    <div class="flex-row between" style="font-weight: 600;">
                        <p>Total</p>
                        <p>$<?php echo $planInfo['plan_price']; ?></p>
                    </div>

                </div>

                <!-- Render Paypal Button -->
                <div id="paypal-button-container"></div>

                <div class="flex-row" style="margin-bottom:24px;">
                    <span class="icon-lock"></span>
                    <span>Encrypted and Secure Payments</span>
                </div>

                <div>
                    <p style="text-align: justify;">By checking out you agree with our <b>Terms of Service</b>. We will process your personal data for the fulfillment of your order and other purposes as per our Privacy Policy. There is no trial period. This plan is only valid for <b>ONE month</b> as of payment date.</p><br>
                </div>

            </div>

            <div class="right-container">
                <div class="flex-grow-1">

                    <h1 class="c1 text-h1">Included Features</h1>

                    <?php
                    foreach ($planInfo['plan_detail'] as $detail) {
                        if ($detail['status'] == "1") {
                            echo "<p id='feature-line'>" . $detail['feature'] . "</p>";
                        }
                    }
                    ?>

                    <hr>
                    <h1 class="c1 text-h1">Excluded Features</h1>

                    <?php
                    foreach ($planInfo['plan_detail'] as $detail) {
                        if ($detail['status'] == "0") {
                            echo "<p id='feature-line'>" . $detail['feature'] . "</p>";
                        }
                    }
                    ?>
                </div>
            </div>

        </div>
    </div>

    <?php
    require_once($_SERVER['DOCUMENT_ROOT'] . "/includes/footer.php");
    ?>

    <script src="https://www.paypal.com/sdk/js?client-id=<?php echo CLIENT_ID ?>&vault=true&intent=subscription" data-sdk-integration-source="button-factory"></script>
    <script>
        let planId = "<?php echo $planInfo['plan_id']; ?>";
        let successURL = "<?php echo SUCCESS_URL; ?>";
    </script>
    <script src="/vendor/paypalButton.js"></script>

</body>

</html>