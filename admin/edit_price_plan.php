<?php

/*######################################*
||             Guideline              ||
*######################################*

Pre-requisite: $_POST['plan_id']

Workflow:
1. Check identity
2. Check if $_POST['plan_id'] is set or empty (from: /admin/manage-price-plan.php)
3. Get plan details from getAllPlanDetails()
4. Send NEW plan details to handler (to: handlers/admin_edit_price_plan_handler.php)

*/


/*######################################*
||              Includes              ||
*######################################*/

require_once($_SERVER['DOCUMENT_ROOT'] . "/config/conn.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/auth/auth_session.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/handlers/get_plan_details.php");

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

if (!isset($_POST['plan_id']) || empty($_POST['plan_id'])) { // check if plan_id is set or is empty
    header("Location: /admin/manage_price_plan.php");
    exit;
}

$plan_info = array();
$plan_info = getAllPlanDetails($_POST['plan_id']);

$plan_id = $plan_info['plan_id'];
$prod_id = $plan_info['prod_id'];
$prod_name = $plan_info['prod_name'];
$plan_name = $plan_info['plan_name'];
$plan_desc = $plan_info['plan_desc'];
$plan_price = $plan_info['plan_price'];
$plan_status = $plan_info['plan_status'];
$plan_detail = $plan_info['plan_detail'];

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
    <title>Edit Price Plan</title>
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

        <form id="edit-form" action="" method="post" class="flex-col">

            <div class="grid-layout">

                <div class="left-container">
                    <h2 class="margin-0">Edit Plan Details</h2>

                    <h2>Plan ID: <i class="red"><?php echo $plan_id; ?></i></h2>
                    <input type="hidden" name="plan_id" value="<?php echo $plan_id; ?>">

                    <label for="plan_status">Current Status:</label>
                    <input type="text" name="plan_status" id="plan_status" value="<?php echo $plan_status; ?>" readonly>

                    <label for="prod_name">Hosting Type (Not allow to migrate):</label>
                    <input type="text" name="prod_name" id="prod_name" value="<?php echo $prod_name; ?>" readonly>

                    <label for="plan_name">Name:</label>
                    <input type="text" name="plan_name" id="plan_name" value="<?php echo $plan_name; ?>" required>

                    <label for="plan_desc">Description:</label>
                    <input type="text" name="plan_desc" id="plan_desc" value="<?php echo $plan_desc; ?>" required>

                    <label for="plan_price">Price:</label>
                    <input type="number" step="0.01" prefix="$" name="plan_price" id="plan_price" value="<?php echo $plan_price; ?>" required>

                    <div class="flex-row">
                        <button type="submit" id="deactivateBtn">Deactivate Plan</button>
                        <button type="submit" id="submitBtn">Save Changes</button>
                        <button type="button" id="abortBtn" onclick="window.location.replace('/admin/manage_price_plan.php')">Abort</button>
                    </div>

                </div>


                <div class="right-container">

                    <h2>Product Features</h2>

                    <div id="feature-container"></div>
                    <button type="button" id="add-feature" onclick="addFeature()"><span class="icon-addBtn"></span>Add Feature</button>

                </div>

            </div>

        </form>
    </div>

    <?php
    require_once($_SERVER['DOCUMENT_ROOT'] . "/includes/footer.php");
    ?>

    <script src="/js/admin_edit_price_plan.js"></script>
    <script>
        <?php

        for ($i = 0; $i < count($plan_detail); $i++) {
            echo "addFeature('" . $plan_detail[$i]['auto_num'] . "', '" . $plan_detail[$i]['feature'] . "','" . $plan_detail[$i]['status'] . "');";
        }
        echo "checkDirty();";

        ?>
    </script>

</body>

</html>