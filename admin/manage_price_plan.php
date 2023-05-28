<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/auth/auth_session.php");
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
    <link rel="stylesheet" href="/css/admin-manage-price-plan.css">
    <script src="/js/effect.js"></script>
    <title>Manage Price Plan</title>
</head>

<body>

    <div id="loader">
        <iframe src="/assets/loading.svg" title="logo"></iframe>
    </div>

    <div id="popup-fade-msg"></div>

    <?php

    require_once($_SERVER['DOCUMENT_ROOT'] . "/auth/CheckLogin.php");

    if (!checkLoggedIn() || $_SESSION['role'] != "admin") {
        header("Location: /pages/login_form.php");
        exit;
    }

    require_once($_SERVER['DOCUMENT_ROOT'] . "/includes/nav.php");

    ?>

    <div class="main-container">
        <h1>Price Plan Management</h1>
        <!-- //hosting type
        //plan title - plan price (click to edit)
        //add button (add plan type) -->

        <?php

        try {
            $query = "SELECT DISTINCT prod_category FROM product";
            $result = mysqli_query($conn, $query);

            if (mysqli_num_rows($result) == 0) {
                echo "<p class='black text-title'>0 Result</p>";
            } else {
                foreach ($result as $row) {

                    echo "<fieldset>";
                    echo "<legend class='text-h1 font-primary font-w-600'>" . $row['prod_category'] . " Hosting</legend>";

                    echo "<div class='w-100 flex-col'>";
                    echo "<form action='/admin/add_price_plan.php' method='post'>";
                    echo "<input type='hidden' name='prod_category' value='" . $row['prod_category'] . "'>";
                    echo "<button id-add-btn type='submit'><span class='icon-addBtn'></span> Add New Plan</button>";
                    echo "</form>";
                    echo "</div>";

                    $query = "SELECT * FROM product WHERE prod_category = '" . $row['prod_category'] . "'";
                    $result2 = mysqli_query($conn, $query);

                    if (mysqli_num_rows($result) == 0) {
                        echo "<p class='black text-title'>0 Result</p>";
                    } else {

                        echo "<div class='price-layout'>";

                        foreach ($result2 as $row) {

                            echo "<a class='w-100' href='/admin/edit_price_plan.php?prod_id=" . $row['prod_id'] . "'> ";
                            echo "<div class='price-component flex-row between'>";
                            echo "<div>";
                            echo "<h3>" . $row['prod_title'] . "</h3>";
                            echo "<p>id: " . $row['prod_id'] . "</p>";
                            echo "</div>";
                            echo "<p class='font-primary text-h1 margin-0'><b>$" . $row['prod_price'] . "</b></p>";
                            echo "</div>";
                            echo "<span class='text-small'>" . $row['prod_status'] . "</span>";
                            echo "</a>";
                        }

                        echo "</div>"; //price-layout
                    }

                    echo "</fieldset>";
                }
            }
        } catch (Exception $e) {
            $errorMessage = "Error: " . $e->getMessage();
            $encodedMessage = json_encode($errorMessage);
            echo "<script>showPopup($encodedMessage);</script>";
        }
        ?>

    </div>

    <?php require_once($_SERVER['DOCUMENT_ROOT'] . "/includes/footer.php"); ?>



</body>

</html>