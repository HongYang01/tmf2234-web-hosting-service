<?php
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
    <link rel="stylesheet" href="/css/pricing.css">
    <script src="/js/effect.js"></script>
    <script src="/js/add_to_cart.js" defer></script>
    <title>VPS Hosting</title>
</head>

<body>

    <div id="loader">
        <iframe src="/assets/loading.svg" title="logo"></iframe>
    </div>

    <?php
    require_once($_SERVER['DOCUMENT_ROOT'] . "/includes/nav.php");
    ?>

    <div class="flex-grow-1 flex-col center middle">

        <header class="header-container flex-row middle">

            <div class="header-left flex-col">
                <h1 class="c1 text-title">VPS Hosting</h1>
                <p class="black text-normal font-w-400">Power up your website with reliable and affordable shared hosting that delivers exceptional performance.</p>

                <div class="flex-row middle" style="margin-top:30px;">
                    <span class="icon-tick"></span>
                    <p class="black text-normal font-w-400">30-Day Money-Back Guarantee</p>
                </div>

            </div>

            <iframe id="image-cover" src="/assets/image/vps-hosting-server-icon.svg" title="cover"></iframe>

        </header>


        <div class="pricing-layout font-second">

            <?php

            $query = "SELECT * FROM product WHERE prod_category='vps' AND prod_status='Active'";
            $result = mysqli_query($conn, $query);

            if (mysqli_num_rows($result) > 0) {

                while ($row = $result->fetch_array()) {

                    echo "<div class='pricing-card'>";
                    echo "<div class='flex-grow-1'>";

                    echo "<h1 class='font-primary text-h1'>" . $row['prod_title'] . "</h1>";
                    echo "<span class='text-small'>" . $row['prod_subtitle'] . "</span>";

                    echo "<div class='flex-row middle center' style='margin-top:30px;'>";
                    echo "<span class='text-normal'>$</span>";
                    echo "<h1 class='text-title font-w-600'>" . $row['prod_price'] . "</h1>";
                    echo "</div>";

                    echo "<span>USD/month</span>";
                    echo "<button class='text-h1' type='submit' id='addToCartBtn' data-prod-id='" . $row['prod_id'] . "'>Add to cart</button>";
                    echo "<hr style='width: 100%; margin: 20px 0;'>";

                    echo "<div class='pricing-feature-line'>";
                    echo "<p class='font-w-600'>Features</p>";
                    echo "</div>";

                    $query2 = "SELECT * FROM productdetail WHERE prod_id='" . $row['prod_id'] . "' ORDER BY status DESC";
                    $result2 = mysqli_query($conn, $query2);
                    $total_row = mysqli_num_rows($result2);

                    if ($total_row > 0) {

                        $counter = 0;

                        while ($row2 = $result2->fetch_array()) {

                            $counter++;

                            echo "<div class='pricing-feature-line'>";

                            if ($row2['status'] == 1) {
                                echo "<span class='icon-tick'></span>";
                            } else {
                                echo "<span class='icon-cross'></span>";
                            }

                            echo "<p>" . $row2['feature'] . "</p>";
                            echo "</div>";

                            if ($counter % 6 == 0 && $total_row != $counter) {
                                echo "<hr style='width: 100%; margin: 20px 0;'>";
                            }
                        }
                    }
                    echo "</div>"; // close flex-grow-1
                    echo "<button class='text-h1' type='submit' id='addToCartBtn' data-prod-id='" . $row['prod_id'] . "'>Select</button>";
                    echo "</div>";
                }
            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            }

            mysqli_close($conn);

            ?>

        </div>

    </div>

    <?php
    require_once($_SERVER['DOCUMENT_ROOT'] . "/includes/footer.php");
    ?>


</body>

</html>

<?php
mysqli_close($conn);
?>