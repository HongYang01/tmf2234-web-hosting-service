<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/main.css">
    <link rel="stylesheet" href="/css/admin-manage-price-plan.css">
    <script src="/js/effect.js"></script>
    <title>Manage Price Plan</title>
</head>

<body class="flex-col">

    <div id="loader">
        <iframe src="/assets/loading.svg" title="logo"></iframe>
    </div>

    <?php

    require_once("auth/auth_session.php");

    if (!isset($_SESSION['loggedin']) || !$_SESSION['loggedin']) { //check if signned in
        header("Location: /pages/login_form.php");
    } else {
        require_once("includes/nav.php");
    }
    ?>

    <div class="main-container">
        <h1>Price Plan Management</h1>
        <!-- //hosting type
        //plan title - plan price (click to edit)
        //add button (add plan type) -->

        <?php

        include("config/conn.php");

        $query = "SELECT DISTINCT prod_category FROM product";
        $result = $conn->query($query);

        foreach ($result as $row) {

            $category = $row['prod_category'];
            $query = "SELECT * FROM product WHERE prod_category = '" . $category . "'";
            $result2 = $conn->query($query);

            if ($result2) {
                echo "<fieldset>";
                echo "<legend class='text-h1 font-primary font-w-600'>" . $row['prod_category'] . " Hosting</legend>";
                echo "<div class='w-100 flex-col'>";
                echo "<a id-add-btn href=''>"; //to-do: set href to add new page
                echo "<span class='icon-addBtn'></span>";
                echo "<span>Add New Plan</span>";
                echo "</a>";
                echo "</div>";
                echo "<div class='price-layout'>";

                foreach ($result2 as $row) {
                    echo "<a class='w-100' target='_blank' href='/admin/edit-price-plan.php?prod_id=" . $row['prod_id'] . "'> ";
                    echo "<div class='price-component flex-row between'>";
                    echo "<div>";
                    echo "<h3>" . $row['prod_title'] . "</h3>";
                    echo "<p>id: " . $row['prod_id'] . "</p>";
                    echo "</div>";
                    echo "<p class='font-primary text-h1 margin-0'><b>$" . $row['prod_price'] . "</b></p>";
                    echo "</div>";
                    echo "</a>";
                }

                echo "</div>";
                echo "</fieldset>";
            } else {
                echo "No data found";
            }
        }

        ?>

    </div>

    <?php include("includes/footer.php"); ?>



</body>

</html>