<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="/assets/image/logo.svg" type="image/x-icon">
    <link rel="stylesheet" href="/css/main.css">
    <link rel="stylesheet" href="/css/admin-add-price-plan.css">
    <script src="/js/effect.js"></script>
    <script src="/js/edit_price_plan.js" defer></script>
    <title>Edit Price Plan</title>
</head>

<body>

    <div id="loader">
        <iframe src="/assets/loading.svg" title="logo"></iframe>
    </div>

    <div id="popup-fade-msg"></div>

    <?php

    require_once($_SERVER['DOCUMENT_ROOT'] . "/auth/auth_session.php");

    require_once($_SERVER['DOCUMENT_ROOT'] . "/auth/CheckLogin.php");
    if (!checkLoggedIn() || $_SESSION['role'] != "admin") {
        header("Location: /pages/login_form.php");
        exit;
    }

    require_once($_SERVER['DOCUMENT_ROOT'] . "/includes/nav.php");

    if (!isset($_GET['prod_id']) || empty($_GET['prod_id'])) { // check if prod_id is set & is not empty
        header("Location: /admin/manage_price_plan.php");
        exit;
    } else {

        $prod_id = $_GET['prod_id'];

        require_once($_SERVER['DOCUMENT_ROOT'] . "/config/conn.php");

        $query = "SELECT * FROM  product  WHERE prod_id ='" . $prod_id . "'";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) > 0) {

            $row = mysqli_fetch_array($result);

            $prod_title = $row['prod_title'];
            $prod_subtitle = $row['prod_subtitle'];
            $prod_category = $row['prod_category'];
            $prod_price = $row['prod_price'];
            $prod_status = $row['prod_status'];
        } else {
            echo "<div class='flex-grow-1 center middle'>";
            echo "<p>Product not found for: " . $prod_id . "</p>";
            echo "</div>";
            exit;
        }
    }

    ?>

    <div class="main-container">

        <form id="edit-form" action="" method="post" class="flex-col">

            <div class="grid-layout">

                <div class="left-container">
                    <h2 class="margin-0">Edit Product Details</h2>

                    <h2>Product ID: <i class="red"><?php echo $prod_id ?></i></h2>

                    <input type="hidden" name="prod_id" value="<?php echo $prod_id; ?>">

                    <label for="prod_status">Status:</label>
                    <select name="prod_status" id="prod_status">
                        <?php
                        //get the enum value
                        require_once($_SERVER['DOCUMENT_ROOT'] . "/handlers/EnumSelector.php");
                        $EnumSelector = new EnumSelector("product", "prod_status", $conn);
                        $EnumSelector->render($prod_status); //pass in the selected category for pre-selection purpose
                        ?>
                    </select>

                    <label for="prod_title">Title:</label>
                    <input type="text" name="prod_title" id="prod_title" value="<?php echo $prod_title; ?>" required>

                    <label for="prod_subtitle">Subtitle:</label>
                    <input type="text" name="prod_subtitle" id="prod_subtitle" value="<?php echo $prod_subtitle; ?>" required>

                    <label for="prod_price">Price:</label>
                    <input type="number" step="0.01" prefix="$" name="prod_price" id="prod_price" value="<?php echo $prod_price; ?>" required>

                    <label for="prod_category">Hosting Type:</label>

                    <select name="prod_category" id="prod_category">
                        <?php
                        //get the enum value
                        require_once($_SERVER['DOCUMENT_ROOT'] . "/handlers/EnumSelector.php");
                        $EnumSelector = new EnumSelector("product", "prod_category", $conn);
                        $EnumSelector->render($prod_category); //pass in the selected category for pre-selection purpose
                        ?>
                    </select>

                    <div class="flex-row">
                        <button type="submit" id="deleteBtn">Delete Plan</button>
                        <button type="submit" id="submitBtn">Save Changes</button>
                    </div>

                </div>


                <div class="right-container">

                    <h2>Product Features</h2>

                    <div id="feature-container"> </div>
                    <button type="button" id="add-feature">Add Feature</button>

                </div>

            </div>

        </form>

    </div>

    <?php
    require_once($_SERVER['DOCUMENT_ROOT'] . "/includes/footer.php");
    ?>

    <!-- make sure it run after every js file is loaded -->
    <script>
        function executePHPAfterScriptLoad() {
            <?php
            // SQL SELECT statement
            // sort by status first
            // then sort by feature
            $query = "SELECT * FROM productDetail WHERE prod_id = '" . $prod_id . "' ORDER BY status DESC, feature ASC";

            $result = mysqli_query($conn, $query);

            if (mysqli_num_rows($result) > 0) {

                while ($row = mysqli_fetch_assoc($result)) {
                    // Add the feature to the page
                    echo "addFeature('" . $row["auto_num"] . "','" . $row["feature"] . "','" . $row["status"] . "');";
                }
                echo "checkDirty()"; // run once to get all the form element
            } else {
                echo "showPopup('0 feature found')";
            }

            mysqli_close($conn);
            ?>
        }
        window.onload = executePHPAfterScriptLoad;
    </script>

</body>

</html>