<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="/assets/image/logo.svg" type="image/x-icon">
    <link rel="stylesheet" href="/css/main.css">
    <link rel="stylesheet" href="/css/myprofile.css">
    <script src="/js/effect.js"></script>
    <script src="/js/confirm_logout.js" defer></script>
    <script src="/js/myprofile.js"></script>
    <title>My Profile</title>
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

    if (!checkLoggedIn()) {
        header("Location: /pages/login_form.php");
        exit;
    }

    require_once($_SERVER['DOCUMENT_ROOT'] . "/includes/nav.php");

    //query without sanitization
    if ($_SESSION['role'] == "user") {
        $query = "SELECT * FROM user WHERE u_email = '" . $_SESSION['email'] . "'";
    } elseif ($_SESSION['role'] == "admin") {
        $query = "SELECT * FROM admin WHERE a_email = '" . $_SESSION['email'] . "'";
    }

    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) == 1) {

        $row = mysqli_fetch_array($result);

        if ($_SESSION['role'] == "user") {
            $_SESSION['fname'] = $row['u_firstName'];
            $_SESSION['lname'] = $row['u_lastName'];
        } elseif ($_SESSION['role'] == "admin") {
            $_SESSION['fname'] = $row['a_firstName'];
            $_SESSION['lname'] = $row['a_lastName'];
        }
    }

    mysqli_close($conn);

    ?>

    <div class="main-container">

        <div class="grid-container">

            <section class="left-container">

                <div class="flex-grow-1">
                    <h1 class="c1 text-h1">My Profile</h1>

                    <form id="myprofile-form" method="post">
                        <label for="email">Registered Email</label>
                        <input type="email" name="email" id="email" value="<?php echo $_SESSION['email']; ?>" readonly>

                        <label for="fname">Firstname</label>
                        <input type="text" autocomplete="off" name="fname" id="fname" value="<?php echo $_SESSION['fname']; ?>" onblur="saveChanges()" required>
                        <span id="err-msg-fname"></span>

                        <label for="lname">Lastname</label>
                        <input type="text" autocomplete="off" name="lname" id="lname" value="<?php echo $_SESSION['lname']; ?>" onblur="saveChanges()" required>
                        <span id="err-msg-lname"></span>
                    </form>

                </div>

                <button data-open-modal id="logout-btn">Logout</button>

            </section>

            <section class="right-container">

                <div class="filter">
                    <h1 class="c1 text-h1">Subscribed Plan</h1>
                    <div class="filter-content">
                        <span>Sort by:</span>
                        <button onclick="sortPlan('default')">Default</button>
                        <button onclick="sortPlan('name')">Plan</button>
                        <button onclick="sortPlan('date')">Maturity Date</button>
                    </div>
                </div>

                <div class="right-container-bottom">

                    <div id="render-plan">
                        <!-- Dynamic sub plan element here -->
                    </div>

                </div>

                <div id="popup-details">
                    <button id="escBtn" onclick="closePopupDetail()">ESC</button>
                    <h1>Plan Details</h1>
                    <div id="popup-content-1">
                        <div id="popup-content-1-header">
                            <p>Plan Name</p>
                            <p>Invoice ID</p>
                            <p>Payment Date</p>
                            <p>Maturity Date</p>
                            <p>Countdown</p>
                            <p>Status</p>
                        </div>
                        <div id="popup-content-1-value">
                        </div>
                    </div>

                    <h1>Features</h1>

                    <div id="popup-content-2">
                        <div id="popup-content-2-include"></div>
                        <div id="popup-content-2-exclude"></div>
                    </div>
                </div>

            </section>

        </div>

    </div>

    <!-- logout model -->
    <dialog data-modal>

        <h1>Confirm Logout</h1>
        <p>Are you sure you want to log out?</p>

        <div class="w-100 flex-row around center middle">
            <button id="confirm-btn">Yes, Logout</button>
            <button data-close-modal id="cancel-btn">Cancel</button>
        </div>

    </dialog>

    <?php
    require_once($_SERVER['DOCUMENT_ROOT'] . "/includes/footer.php");
    ?>

</body>

</html>