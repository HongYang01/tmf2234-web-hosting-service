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
    <link rel="stylesheet" href="/css/admin-manage-price-plan.css">
    <script src="/js/effect.js"></script>
    <title>Manage Price Plan</title>
</head>

<body>

    <div id="loader">
        <iframe src="/assets/loading.svg" title="logo"></iframe>
    </div>

    <div id="popup-fade-msg"></div>

    <?php require_once($_SERVER['DOCUMENT_ROOT'] . "/includes/nav.php"); ?>

    <div class="main-container">
        <h1>Price Plan Management</h1>

        <div class="grid-layout">

            <div class="grid-layout-content-1">

                <h1 class="text-h1">Hosting Type</h1>

                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method='GET'>

                    <?php
                    require_once($_SERVER['DOCUMENT_ROOT'] . "/handlers/get_all_product.php");

                    try {
                        $allProduct = getAllProduct();

                        if (in_array("error", $allProduct)) {
                            throw new Exception($allProduct['error']);
                        }

                        foreach ($allProduct as $prod) {
                            echo "<button type='submit' name='prod_id' value='" . $prod['prod_id'] . "'>" . $prod['prod_name'] . "</button>";
                        }
                    } catch (Exception $e) {
                        echo $e->getMessage();
                    }
                    ?>

                </form>
            </div>

            <div class="grid-layout-content-2">

                <?php

                try {

                    if (!isset($_GET['prod_id']) || empty($_GET['prod_id'])) {
                        throw new Exception("Choose a hosting type");
                    }

                    require_once($_SERVER['DOCUMENT_ROOT'] . "/handlers/get_all_plan.php");

                    $prodInfo = getAllProduct($_GET['prod_id'])[0]; // [0] to access the first index of the object array
                    $prod_id = $prodInfo['prod_id'];
                    $prod_name = $prodInfo['prod_name'];
                    $planInfo = json_decode(getAllPlan($prod_name), true);

                    if (array_key_exists('error', $planInfo)) {
                        throw new Exception($planInfo['error']);
                    }

                    echo "<h1 class='text-h1'>" . $prod_name . " Hosting</h1>";
                    echo "<form action='/admin/add_price_plan.php' method='POST'>";
                    echo "<button type='submit' name='prod_id' value='" . $prod_id . "'><span class='icon-addBtn'></span> Add New Plan</button>";
                    echo "</form>";

                    echo "<table id='plan-table'>";
                    echo "<colgroup>";
                    echo "<col span='1' style='width: 40%;'>";
                    echo "<col span='1' style='width: 20%;'>";
                    echo "<col span='1' style='width: 20%;'>";
                    echo "<col span='1' style='width: 20%;'>";
                    echo "</colgroup>";

                    // header
                    echo "<tr>";
                    echo "<th>Plan ID</th>";
                    echo "<th>Plan Name</th>";
                    echo "<th>Monthly Price ($)</th>";
                    echo "<th>Plan Status</th>";
                    echo "</tr>";

                    // data
                    foreach ($planInfo as $plan) {
                        echo "<tr id='plan-row' data-plan-id='" . $plan['plan_id'] . "' data-plan-status='" . $plan['plan_status'] . "' title='click to edit'>";
                        echo "<td>" . $plan['plan_id'] . "</td>";
                        echo "<td>" . $plan['plan_name'] . "</td>";
                        echo "<td>" . $plan['plan_price'] . "</td>";
                        if ($plan['plan_status'] == "ACTIVE") {
                            echo "<td class='green font-w-600'>" . $plan['plan_status'] . "</td>";
                        } else {
                            echo "<td class='red font-w-600'>" . $plan['plan_status'] . "</td>";
                        }
                        echo "<tr>";
                    }
                    echo "</table>";
                } catch (Exception $e) {
                    echo $e->getMessage();
                }
                ?>

            </div>

        </div>

    </div>

    <?php require_once($_SERVER['DOCUMENT_ROOT'] . "/includes/footer.php"); ?>
    <script src="/js/admin_manage_price_plan.js"></script>
</body>

</html>