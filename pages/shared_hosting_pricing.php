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
    <script src="/js/add_to_cart.js"></script>
    <title>Shared Hosting</title>
</head>

<body>

    <div id="loader">
        <iframe src="/assets/loading.svg" title="logo"></iframe>
    </div>

    <div id="popup-fade-msg"></div>

    <?php
    require_once($_SERVER['DOCUMENT_ROOT'] . "/includes/nav.php");
    ?>

    <div class="main-pricing-container">

        <div class="title flex-row middle around">

            <div class="title-content">
                <h1 class="c1 text-title">Shared Hosting</h1>
                <p class="black text-normal font-w-400">Power up your website with reliable and affordable shared hosting that delivers exceptional performance for your small business and medium website.</p>

                <div class="black text-normal" style="margin-top:30px;">
                    <p class="flex-row middle"><span class='icon-tick'></span> Secured and enclosed system</p>
                    <p class="flex-row middle"><span class='icon-tick'></span> Great for small business and moderate website</p>
                </div>

            </div>

            <iframe id="image-cover" src="/assets/image/shared-hosting-server-icon.svg" title="cover"></iframe>

        </div>


        <div class="pricing-layout font-second">

            <?php

            require_once($_SERVER['DOCUMENT_ROOT'] . "/handlers/get_all_plan.php");
            $allPlans = json_decode(getAllPlan("Shared"), true);

            foreach ($allPlans as $plan) {

                if ($plan['plan_status'] == "INACTIVE") {
                    continue;
                }

                echo "<div class='pricing-card'>";
                echo "<div class='flex-grow-1'>";

                echo "<h1 class='font-primary text-h1'>" . $plan['plan_name'] . "</h1>";
                echo "<span class='text-small'>" . $plan['plan_desc'] . "</span>";

                echo "<div class='flex-row middle center' style='margin-top:30px;'>";
                echo "<span class='text-normal'>$</span>";
                echo "<h1 class='text-title font-w-600'>" . $plan['plan_price'] . "</h1>";
                echo "</div>";

                echo "<span>USD/month</span>";
                echo "<button class='text-h1' type='submit' id='addToCartBtn' data-plan-id='" . $plan['plan_id'] . "'>Add to cart</button>";
                echo "<hr style='width: 100%; margin: 20px 0;'>";

                echo "<div class='pricing-feature-line'>";
                echo "<p class='font-w-600'>Features</p>";
                echo "</div>";

                $counter = 0;

                foreach ($plan['include_feature'] as $feature) {

                    $counter++;

                    echo "<div class='pricing-feature-line'>";
                    echo "<span class='icon-tick'></span>";
                    echo "<p>" . $feature . "</p>";
                    echo "</div>";

                    if ($counter % 6 == 0) {
                        echo "<hr style='width: 100%; margin: 20px 0;'>";
                    }
                }

                foreach ($plan['exclude_feature'] as $feature) {

                    $counter++;

                    echo "<div class='pricing-feature-line'>";
                    echo "<span class='icon-cross'></span>";
                    echo "<p>" . $feature . "</p>";
                    echo "</div>";

                    if ($counter % 6 == 0) {
                        echo "<hr style='width: 100%; margin: 20px 0;'>";
                    }
                }

                echo "</div>"; // close flex-grow-1
                echo "<button class='text-h1' type='submit' id='addToCartBtn' data-plan-id='" . $plan['plan_id'] . "'>Select</button>";

                echo "</div>";
            }
            ?>

        </div>

    </div>

    <?php
    require_once($_SERVER['DOCUMENT_ROOT'] . "/includes/footer.php");
    ?>

</body>

</html>