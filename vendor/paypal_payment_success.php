<?php

$sub_id;
$sub_info = array();
$trans_info = array();

/*######################################*
||          Check POST array          ||
*######################################*/
// must use post method

try {
    if ($_SERVER['REQUEST_METHOD'] === "POST") {
        if (!isset($_POST['sub_id']) || empty($_POST['sub_id'])) {
            throw new Exception("Subscription ID is not set");
        } else {
            $sub_id = $_POST['sub_id'];
        }
    }
} catch (Exception $e) {
    $response['error'] = $e->getMessage();
}

/*######################################*
||      Get Subscription Details      ||
*######################################*/

try {
    require_once($_SERVER['DOCUMENT_ROOT'] . "/handlers/get_sub_details.php");
    $sub_info = getSubDetail($sub_id);

    if (key_exists("error", $sub_info)) {
        throw new Exception($sub_info['error']);
    }
} catch (Exception $e) {
    $response['error'] = $e->getMessage();
}

// assign value
$sub_status = $sub_info['sub_status'];
$sub_id = $sub_info['sub_id'];
$plan_id = $sub_info['plan_id'];
$paypal_email = $sub_info['paypal_email'];
$paypal_name = $sub_info['paypal_name'];
$payer_id = $sub_info['payer_id'];
$amount = $sub_info['amount'];
$currency_code = $sub_info['currency_code'];
$bill_date = $sub_info['bill_date'];
$next_bill_date = $sub_info['next_bill_date'];
$prod_id = $sub_info['prod_id'];
$plan_name = $sub_info['plan_name'];
$plan_desc = $sub_info['plan_desc'];
$plan_price = $sub_info['plan_price'];
$plan_status = $sub_info['plan_status'];
$prod_name = $sub_info['prod_name'];
$prod_status = $sub_info['prod_status'];


/*######################################*
||      Get Transaction Details       ||
*######################################*/

try {
    require_once($_SERVER['DOCUMENT_ROOT'] . "/handlers/get_all_transaction.php");
    $trans_info = getAllTransaction($sub_id)[0]; // get the first payment only

    if (key_exists("error", $trans_info)) {
        throw new Exception($trans_info['error']);
    }
} catch (Exception $e) {
    $response['error'] = $e->getMessage();
}

// assign value
$trans_id = $trans_info['trans_id']; // get transaction id only

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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment-timezone/0.5.33/moment-timezone-with-data-10-year-range.min.js"></script>
    <script src="/js/myDateFormat.js"></script>
    <title>Payment Successful</title>
</head>

<body>

    <div id="loader">
        <iframe src="/assets/loading.svg" title="logo"></iframe>
    </div>

    <?php
    require_once($_SERVER['DOCUMENT_ROOT'] . "/includes/nav.php");
    ?>

    <div class="flex-grow-1 flex-col center middle">
        <div>

            <h1>Thank you for your payment</h1>
            <div class='info-card'>
                <h4>Payment Information</h4>

                <table style="text-align:left;">
                    <tr>
                        <th>Receip Sent to:</th>
                        <td><?php echo $paypal_email; ?></td>
                    </tr>
                    <tr>
                        <th>Transaction ID</th>
                        <td><?php echo $trans_id; ?></td>
                    </tr>
                    <tr>
                        <th>Total Paid Amount</th>
                        <td><?php echo $amount . " " . $currency_code; ?></td>
                    </tr>
                    <tr>
                        <th>Subcription ID</th>
                        <td><?php echo $sub_id; ?></td>
                    </tr>
                    <tr>
                        <th>Plan ID</th>
                        <td><?php echo $plan_id; ?></td>
                    </tr>
                    <tr>
                        <th>Plan Name</th>
                        <td><?php echo $prod_name . " Hosting (" . $plan_name . ")"; ?></td>
                    </tr>
                    <tr>
                        <th>Bill Date</th>
                        <td>
                            <?php echo $bill_date; ?>
                        </td>
                    </tr>
                    <tr>
                        <th>Next Bill Date</th>
                        <td>
                            <?php echo $next_bill_date; ?>
                        </td>
                    </tr>
                </table>

                <a id="home" href="/pages/myprofile.php">Back</a>
            </div>
        </div>
    </div>

    <?php
    require_once($_SERVER['DOCUMENT_ROOT'] . "/includes/footer.php");
    ?>

    <script>
        window.onload = function() {
            // Use pushState to update the URL and remove form data from history
            let newURL = '/pages/myprofile.php';
            window.history.pushState({}, newURL, window.location.href);
        };
    </script>
</body>

</html>