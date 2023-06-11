<?php
/*######################################*
||              Includes              ||
*######################################*/

require_once($_SERVER['DOCUMENT_ROOT'] . "/auth/auth_session.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/handlers/admin_get_all_customer.php");

/*######################################*
||           Check Identity           ||
*######################################*/

require_once($_SERVER['DOCUMENT_ROOT'] . "/auth/CheckLogin.php");
if (!checkLoggedIn() || $_SESSION['role'] != "admin") {
    mysqli_close($conn);
    header("Location: /pages/login_form.php");
    exit;
}

$allCustomer = getAllCustomer();

// echo "<pre>";
// print_r($allCustomer);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="/assets/image/logo.svg" type="image/x-icon">
    <link rel="stylesheet" href="/css/main.css">
    <link rel="stylesheet" href="/css/admin-customer-info.css">
    <script src="/js/effect.js"></script>
    <title>Semicolonix | Customer Info</title>
</head>

<body>

    <div id="loader">
        <iframe src="/assets/loading.svg" title="logo"></iframe>
    </div>

    <?php require_once($_SERVER['DOCUMENT_ROOT'] . "/includes/nav.php"); ?>

    <div class="main-container">
        <table>
            <caption class="c1 font-primary text-h1 font-w-700">All Customer Info</caption>
            <tr>
                <th>No</th>
                <th>Email</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Signup Date</th>
            </tr>
            <?php

            $count = 0;

            foreach ($allCustomer as $temp) {

                echo "<tr>";
                echo "<td>" . ++$count . "</td>";
                echo "<td>" . $temp['u_email'] . "</td>";
                echo "<td>" . $temp['u_firstname'] . "</td>";
                echo "<td>" . $temp['u_lastname'] . "</td>";
                echo "<td>" . $temp['signupDate'] . "</td>";
                echo "</tr>";
            }

            ?>
        </table>
    </div>

    <?php require_once($_SERVER['DOCUMENT_ROOT'] . "/includes/footer.php"); ?>

</body>

</html>