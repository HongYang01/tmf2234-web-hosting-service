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
    <script src="/js/add_price_plan.js" defer></script>
    <title>Adding Price Plan</title>
</head>

<body>

    <div id="loader">
        <iframe src="/assets/loading.svg" title="logo"></iframe>
    </div>

    <div id="popup-fade-msg"></div>

    <?php
    require_once($_SERVER['DOCUMENT_ROOT'] . "/auth/auth_session.php");
    require_once($_SERVER['DOCUMENT_ROOT'] . "/config/conn.php");

    require_once($_SERVER['DOCUMENT_ROOT'] . "/auth/CheckLogin.php");
    if (!checkLoggedIn() || $_SESSION['role'] != "admin") {
        header("Location: /pages/login_form.php");
        exit;
    }
    require_once($_SERVER['DOCUMENT_ROOT'] . "/includes/nav.php");
    ?>

    <div class="main-container">

        <form action="/handlers/add_price_plan_handler.php" method="post" class="flex-col">

            <div class="grid-layout">

                <div class="left-container">
                    <h2>Add New Hosting Plan</h2>

                    <label for="prod_status">Status:</label>
                    <select name="prod_status" id="prod_status" tabindex="1">
                        <?php
                        //get the enum value
                        require_once($_SERVER['DOCUMENT_ROOT'] . "/handlers/EnumSelector.php");
                        $EnumSelector = new EnumSelector("product", "prod_status", $conn);
                        $EnumSelector->render("");
                        ?>
                    </select>

                    <label for="prod_category">Hosting Type:</label>
                    <select name="prod_category" id="prod_category">
                        <?php
                        //get the enum value
                        require_once($_SERVER['DOCUMENT_ROOT'] . "/handlers/EnumSelector.php");
                        $EnumSelector = new EnumSelector("product", "prod_category", $conn);
                        $EnumSelector->render($_POST['prod_category']); //pass in the selected category for pre-selection purpose
                        ?>
                    </select>

                    <label for="prod_title">Title:</label>
                    <input type="text" name="prod_title" id="prod_title" tabindex="3" placeholder="Basic, Popular, Premium" require autocomplete="false">

                    <label for="prod_subtitle">Subtitle:</label>
                    <input type="text" name="prod_subtitle" id="prod_subtitle" tabindex="4" placeholder="Best for rookie" require autocomplete="false">

                    <label for="prod_price">Monthly Price ($):</label>
                    <input type="number" name="prod_price" id="prod_price" tabindex="5" step="0.01" placeholder="1.00" require autocomplete="false">

                    <button type="submit" tabindex="6" id="submitBtn">Submit</button>

                </div>


                <div class="right-container">

                    <h2>Product Features</h2>

                    <div id="feature-container">
                        <!-- Existing textboxes will be appended here dynamically -->
                    </div>

                    <button type="button" id="add-feature">Add Feature</button>
                </div>

            </div>

        </form>

    </div>

    <?php
    require_once($_SERVER['DOCUMENT_ROOT'] . "/includes/footer.php");
    ?>

</body>

</html>