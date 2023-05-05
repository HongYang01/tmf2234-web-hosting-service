<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/main.css">
    <link rel="stylesheet" href="/css/admin-edit-price-plan.css">
    <script src="/js/effect.js"></script>
    <script src="/js/function.js" defer></script>
    <title>Edit Price Plan</title>
</head>

<body class="flex-col">

    <div id="loader">
        <iframe src="/assets/loading.svg" title="logo"></iframe>
    </div>

    <?php

    require_once($_SERVER['DOCUMENT_ROOT'] . "/auth/auth_session.php");


    if (!isset($_SESSION['loggedin']) || !$_SESSION['loggedin']) { //check if signned in
        header("Location: /pages/login_form.php");
    } else {

        // require_once($_SERVER['DOCUMENT_ROOT'] . "/includes/nav.php");

        $prod_id = $_GET['prod_id'];

        require_once($_SERVER['DOCUMENT_ROOT'] . "/config/conn.php");

        $query = "SELECT * FROM product WHERE prod_id ='" . $prod_id . "'";

        $result = $conn->query($query);

        if ($result) {

            $row = mysqli_fetch_array($result);

            $prod_name = $row['prod_name'];
            $prod_title = $row['prod_title'];
            $prod_subtitle = $row['prod_subtitle'];
            $prod_category = $row['prod_category'];
            $prod_price = $row['prod_price'];
        } else {
            echo "Nothing was found.";
        }
    }

    ?>

    <div class="main-container">

        <h1>Edit <i class="red"><?php echo $prod_id ?></i> Price Plan</h1>

        <p>⚠️still cannot update to database (IN PROGRESS)</p>

        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="get">

            <div class="flex-row middle">
                <span>View</span>
                <label class="switch">
                    <input type="checkbox" id="toggle-btn">
                    <span class="slider round"></span>
                </label>
                <span>Edit</span>
            </div>

            <input type="hidden" name="prod_id" value="<?php echo $prod_id; ?>" readonly>

            <label for="prod_title">Name:</label>
            <input type="text" name="prod_name" value="<?php echo $prod_name; ?>" readonly><br>

            <label for="prod_title">Title:</label>
            <input type="text" name="prod_title" value="<?php echo $prod_title; ?>" readonly><br>

            <label for="prod_subtitle">Subtitle:</label>
            <input type="text" name="prod_subtitle" value="<?php echo $prod_subtitle; ?>" readonly><br>

            <label for="prod_price">Price:</label>
            <input type="number" step="0.01" name="prod_price" value="<?php echo $prod_price; ?>" readonly><br>

            <label for="prod_category">Category:</label>
            <input type="text" name="prod_category" value="<?php echo $prod_category; ?>" readonly><br>

            <input type="submit" name="update" id="update" value="Update Changes" style="
            display: none;">
        </form>

    </div>

</body>

</html>

<?php

include($_SERVER['DOCUMENT_ROOT'] . "/config/conn.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/auth/auth_session.php");

if (isset($_GET['update'])) {
    echo "ok";
} else {
    echo "Not submitted";
}
mysqli_close($conn);

?>