<?php

/*######################################*
||              Includes              ||
*######################################*/

require_once($_SERVER['DOCUMENT_ROOT'] . "/config/conn.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/auth/auth_session.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/handlers/get_all_product.php");

/*######################################*
||           Check Identity           ||
*######################################*/

require_once($_SERVER['DOCUMENT_ROOT'] . "/auth/CheckLogin.php");
if (!checkLoggedIn() || $_SESSION['role'] != "admin") {
    mysqli_close($conn);
    header("Location: /pages/login_form.php");
    exit;
}

/*######################################*
||          Check POST array          ||
*######################################*/

if (!isset($_POST['prod_id']) || empty($_POST['prod_id'])) {
    mysqli_close($conn);
    exit;
}
$prod_id = mysqli_real_escape_string($conn, $_POST['prod_id']);
$prodInfo = getAllProduct($prod_id)[0]; // use [0] to access the first key of the object, because only one product

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="/assets/image/logo.svg" type="image/x-icon">
    <link rel="stylesheet" href="/css/main.css">
    <link rel="stylesheet" href="/css/admin-add-edit-price-plan.css">
    <script src="/js/effect.js"></script>
    <title>Adding Price Plan</title>
</head>

<body>

    <div id="loader">
        <iframe src="/assets/loading.svg" title="logo"></iframe>
    </div>

    <div id="popup-fade-msg"></div>

    <?php require_once($_SERVER['DOCUMENT_ROOT'] . "/includes/nav.php"); ?>

    <div class="main-container">

        <form id="add-plan-form" class="flex-col">

            <div class="grid-layout">

                <div class="left-container">
                    <h2>Add New <?php echo $prodInfo['prod_name']; ?> Hosting Plan</h2>

                    <label for="prod_id">Product ID:</label>
                    <input type="text" name="prod_id" id="prod_id" tabindex="1" value="<?php echo $prodInfo['prod_id']; ?>" readonly>

                    <label for="prod_name">Hosting Type:</label>
                    <input type="text" name="prod_name" id="prod_name" tabindex="2" value="<?php echo $prodInfo['prod_name']; ?>" readonly>

                    <label for="plan_name">Plan Name:</label>
                    <input type="text" name="plan_name" id="plan_name" tabindex="3" placeholder="Basic, Popular, Premium" require autocomplete="false">

                    <label for="plan_desc">Plan Description:</label>
                    <input type="text" name="plan_desc" id="plan_desc" tabindex="4" placeholder="Best for rookie" require autocomplete="false">

                    <label for="plan_price">Monthly Price ($):</label>
                    <input type="number" name="plan_price" id="plan_price" tabindex="5" step="0.01" placeholder="1.00" require autocomplete="false">

                    <button type="submit" id="submitBtn">Submit</button>
                    <p class="text-small">Note: Plan <span class="red"> cannot </span> be migrated/deleted once created (for tracking purpose).</p>

                </div>

                <div class="right-container">

                    <h2>Plan Features</h2>

                    <div id="feature-container">
                        <!-- New product details will be appended here dynamically -->
                    </div>

                    <button type="button" id="add-feature"><span class="icon-addBtn"></span>Add Feature</button>
                </div>

            </div>

        </form>

    </div>

    <?php
    require_once($_SERVER['DOCUMENT_ROOT'] . "/includes/footer.php");
    ?>
    <script src="/js/admin_add_price_plan.js"></script>
</body>

</html>