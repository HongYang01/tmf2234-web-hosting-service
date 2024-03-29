<script src="/js/mobile_menu.js"></script>

<nav id="nav-bar" class="w-100 flex-row between" role="navigation">

    <!-- logo -->
    <?php
    require_once($_SERVER['DOCUMENT_ROOT'] . "/auth/auth_session.php");

    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin']) {

        if ($_SESSION['role'] == "admin") {
            echo "<a id='logo' href='/admin/dashboard.php'>";
        } else {
            echo "<a id='logo' href='/index.php'>";
        }
    } else {
        echo "<a id='logo' href='/index.php'>";
    }

    ?>

    <div class="flex-row middle" id='mobile-nav'>

        <svg class="logo" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="71 71 358 358" shape-rendering="geometricPrecision" text-rendering="geometricPrecision">

            <path d="M86.62828,142.84c-8.3993,0-15.20828-7.93-15.20828-17.71216v-35.99568C71.42,79.35,78.22898,71.42,86.62828,71.42h326.74344c8.3993,0,15.20828,7.93,15.20828,17.71216v35.99568c0,9.78216-6.80898,17.71216-15.20828,17.71216h-326.74344ZM110,117.13c5.52285,0,10-4.47715,10-10s-4.47715-10-10-10-10,4.47715-10,10s4.47715,10,10,10Zm32.03384,0c5.52285,0,10-4.47715,10-10s-4.47715-10-10-10-10,4.47715-10,10s4.47715,10,10,10Zm247.70847,0c5.66517,0,10.25769-4.47606,10.25769-9.99756v-.00488c0-5.5215-4.59253-9.99756-10.25769-9.99756h-129.48461c-5.66517,0-10.25769,4.47606-10.25769,9.99756v.00488c0,5.5215,4.59253,9.99756,10.25769,9.99756h129.48461Z" stroke-width="0" stroke-linejoin="round" />

            <path d="M86.62828,428.52c-8.3993,0-15.20828-7.93-15.20828-17.71216v-35.99568C71.42,365.03,78.22898,357.1,86.62828,357.1h255.32575c8.39824-.00145,15.20597-7.9309,15.20597-17.71216v-35.99568c0-9.78085-6.80715-17.71003-15.2049-17.71216h-255.32682c-8.3993,0-15.20828-7.93-15.20828-17.71216v-35.99568C71.42,222.19,78.22898,214.26,86.62828,214.26h326.74344c8.3993,0,15.20828,7.93,15.20828,17.71216v4.58275v0v169.67019v0v4.58274c0,9.78216-6.80898,17.71216-15.20828,17.71216h-326.74344Z" stroke-width="0" stroke-linejoin="round" />

        </svg>

        <h1 class="black font-w-400 text-title margin-0" id='home'>Semicolonix</h1>

    </div>

    </a> <!-- close logo tag -->

    <div class="logo" id="navSwitch">
        <img class="nav-toggle" id='menu' src="/assets/icon/menu.svg" alt="">
        <img class="nav-toggle hidden" src="/assets/icon/close.svg" alt="">
    </div>

    <!-- nav -->
    <div class="flex-row" id='nav-bar2'>

        <?php
        require_once($_SERVER['DOCUMENT_ROOT'] . "/auth/auth_session.php");

        if (isset($_SESSION['loggedin']) && $_SESSION['loggedin']) {

            if ($_SESSION['role'] == "admin") { //admin
                // echo "<a class='c1 text-normal font-w-600' href='/admin/dashboard.php'>Dashboard</a>";
                echo "<div class='dropdown flex-row'>";

                echo "<div class='flex-row middle'  id='nav-admin-dashboard'>
                    <span class='c1 text-normal font-w-600'><a class='c1 text-normal font-w-600' href='/admin/dashboard.php'>Dashboard</a></span>
                    <img class='rotate-180' src='/assets/icon/drop-down.svg' alt=''>
                </div>";

                echo "<div class='dropdown-content'>
                    <a id='link-price-plan' href='/admin/manage_price_plan.php'>Manage Price Plan</a>
                    <a id='link-sales' href='/admin/sales_analytics.php'>Sales Analytics</a>
                    <a id='link-trans-history' href='/admin/transaction_history.php'>Transaction History</a>
                    <a id='link-trans-history' href='/admin/customer_info.php'>Customer Info</a>
                </div>";

                echo "</div>";
            } else { // user
                echo "<div class='dropdown flex-row'>";

                echo "<div class='flex-row middle' id='nav-price'>
                    <span class='c1 text-normal font-w-600'>Pricing</span>
                    <img class='rotate-180' src='/assets/icon/drop-down.svg' alt=''>
                </div>";

                echo "<div class='dropdown-content'>
                    <a id='link-sh' href='/pages/shared_hosting_pricing.php'>Shared Hosting</a>
                    <a id='link-vps' href='/pages/vps_hosting_pricing.php'>VPS Hosting</a>
                    <a id='link-dc' href='/pages/dedicated_hosting_pricing.php'>Dedicated Hosting</a>
                </div>";

                echo "</div>";

                echo "<a class='c1 text-normal font-w-600' href='/pages/about.php'>About</a>";

                // echo "<a class='c1 text-normal font-w-600' href='/pages/cart.php'>Cart</a>";
            }

            echo "<a class='c1 text-normal font-w-600' href='/pages/myprofile.php'>My Profile</a>";
        } else { //not logged in

            echo "<div class='dropdown flex-row'>";

            echo "<div class='flex-row middle' id='nav-price'>
                    <span class='c1 text-normal font-w-600'>Pricing</span>
                    <img class='rotate-180' src='/assets/icon/drop-down.svg' alt=''>
                </div>";

            echo "<div class='dropdown-content'>
                    <a id='link-sh' href='/pages/shared_hosting_pricing.php'>Shared Hosting</a>
                    <a id='link-vps' href='/pages/vps_hosting_pricing.php'>VPS Hosting</a>
                    <a id='link-dc' href='/pages/dedicated_hosting_pricing.php'>Dedicated Hosting</a>
                </div>";

            echo "</div>";

            echo "<a class='c1 text-normal font-w-600' href='/pages/about.php'>About</a>";

            echo "<a class='c1 text-normal font-w-600' href='/pages/login_form.php'>Login</a>";
        }
        ?>

    </div>

</nav>