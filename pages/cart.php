<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="/assets/image/logo.svg" type="image/x-icon">
    <link rel="stylesheet" href="/css/main.css">
    <link rel="stylesheet" href="/css/cart.css">
    <script src="/js/effect.js" async defer></script>
    <script src="/js/cart.js" defer></script>
    <title>Cart | Semicolonix</title>
</head>

<body>

    <div id="loader">
        <iframe src="/assets/loading.svg" title="logo"></iframe>
    </div>

    <?php

    require_once($_SERVER['DOCUMENT_ROOT'] . "/auth/auth_session.php");
    require_once($_SERVER['DOCUMENT_ROOT'] . "/config/conn.php");
    require_once($_SERVER['DOCUMENT_ROOT'] . "/auth/CheckLogin.php");

    if (!checkLoggedIn()) {
        header("Location: /pages/login_form.php");
        mysqli_close($conn);
        exit;
    }

    require_once($_SERVER['DOCUMENT_ROOT'] . "/includes/nav.php");

    if (!isset($_POST['prod_id']) || empty($_POST['prod_id'])) {
        // Handle the error gracefully, such as displaying an error message or redirecting
        passMsg("Oopps, Plan not found, are you trying to access using URL? Try again by selecting a plan <a href='/pages/shared_hosting_pricing.php' id='linkToPricingPlan'>here</a>");
        mysqli_close($conn);
        exit;
    } else {
        $prod_id = $_POST['prod_id'];
    }

    // to-do
    // get product info
    // confirm if quit/reload page/redirect away
    // change redirect history (to index) so that user cannot click back when redirect away

    $query = "SELECT * FROM product WHERE prod_id = $prod_id";
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $prod_id = mysqli_real_escape_string($conn, $row['prod_id']);
        $prod_title = mysqli_real_escape_string($conn, $row['prod_title']);
        $prod_subtitle = mysqli_real_escape_string($conn, $row['prod_subtitle']);
        $prod_price = mysqli_real_escape_string($conn, $row['prod_price']);
        $prod_category = mysqli_real_escape_string($conn, $row['prod_category']);
        $prod_name = "" . $prod_category . " Hosting (" . $prod_title . ")";
    } else {
        passMsg("Oopps, Plan not found");
        mysqli_close($conn);
        exit;
    }

    function passMsg(String $msg)
    {
        echo "<div class='main-container middle center'>";
        echo "<div class='middle center' style='width:30%; text-align:center;'>";
        echo "<p>" . $msg . "</p>";
        echo "</div>";
        echo "</div>";
    }

    ?>

    <div class="main-container">

        <div class="cart-container">

            <div class="left-container">

                <div class="left-component-1">
                    <h1 class="c1 text-h1">Order Summary</h1>

                    <div class="flex-row between" style="font-weight: 600; margin-bottom:15px;">
                        <p><?php echo $prod_name ?> - monthly</p>
                        <p>$<?php echo $prod_price ?></p>
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
                        <p>$<?php echo $prod_price ?></p>
                    </div>

                </div>

                <div id="checkoutBtn" data-prod-id="<?php echo $prod_id; ?>">
                    <img src="/assets/icon/paypal-logo.svg" alt=""></img>
                    <span>Checkout</span>
                </div>

                <div class="flex-row" style="margin-bottom:24px;">
                    <span class="icon-lock"></span>
                    <span>Encrypted and Secure Payments</span>
                </div>

                <div>
                    <p style="text-align: justify;">By checking out you agree with our <b>Terms of Service</b>. We will process your personal data for the fulfillment of your order and other purposes as per our Privacy Policy. This payment is one-time only, if you wish to continue the plan you may renew it after ONE month</p><br>


                    <p style="text-align: justify;">This plan is only valid for <b>ONE month (30 days)</b> as of payment date, to renew the plan you need to do a separate payment. You will receive an email a week in advance before the maturity date.</p>
                </div>

            </div>

            <div class="right-container">
                <div class="flex-grow-1">

                    <h1 class="c1 text-h1">Included Features</h1>

                    <?php

                    $query = "SELECT * FROM productdetail WHERE prod_id = " . $prod_id . " AND status = 1 ORDER BY feature ASC";
                    $result = mysqli_query($conn, $query);

                    if (mysqli_num_rows($result) == 0) {
                        echo '<p>None</p>';
                    } else {
                        while ($row = mysqli_fetch_array($result)) {

                            echo "<p id='feature-line'>" . $row['feature'] . "</p>";
                        }
                    }
                    ?>

                    <hr>
                    <h1 class="c1 text-h1">Excluded Features</h1>

                    <?php

                    $query = "SELECT * FROM productdetail WHERE prod_id = " . $prod_id . " AND status = 0 ORDER BY feature ASC";
                    $result = mysqli_query($conn, $query);

                    if (mysqli_num_rows($result) == 0) {
                        echo '<p>None</p>';
                    } else {
                        while ($row = mysqli_fetch_array($result)) {

                            echo "<p id='feature-line'>" . $row['feature'] . "</p>";
                        }
                    }

                    mysqli_close($conn);

                    ?>
                </div>
            </div>

        </div>
    </div>

    <?php
    require_once($_SERVER['DOCUMENT_ROOT'] . "/includes/footer.php");
    ?>

</body>

</html>