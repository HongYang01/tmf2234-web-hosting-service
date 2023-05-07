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
    <script src="/js/function.js" async defer></script>
    <script src="/js/confirm_logout.js" async defer></script>
    <title>My Profile</title>
</head>

<body class="flex-col">

    <div id="loader">
        <iframe src="/assets/loading.svg" title="logo"></iframe>
    </div>

    <div id="popup-fade-msg"></div>

    <?php
    require_once($_SERVER['DOCUMENT_ROOT'] . "/auth/auth_session.php");

    if (!isset($_SESSION['loggedin']) || !$_SESSION['loggedin']) {
        header("Location: /pages/login_form.php");
        exit;
    }

    require_once($_SERVER['DOCUMENT_ROOT'] . "/includes/nav.php");
    require_once($_SERVER['DOCUMENT_ROOT'] . "/config/conn.php");

    //query without sanitization
    if ($_SESSION['role'] == "user") {
        $query = "SELECT * FROM user WHERE u_email = '" . $_SESSION['email'] . "'";
    } elseif ($_SESSION['role'] == "admin") {
        $query = "SELECT * FROM admin WHERE a_email = '" . $_SESSION['email'] . "'";
    }

    $result = $conn->query($query);

    if (mysqli_num_rows($result) == 1) {

        $row = mysqli_fetch_array($result);

        if ($_SESSION['role'] == "user") {
            $_SESSION['fname'] = $row['u_firstName'];
            $_SESSION['lname'] = $row['u_lastName'];
        } elseif ($_SESSION['role'] == "admin") {
            $_SESSION['fname'] = $row['a_firstName'];
            $_SESSION['lname'] = $row['a_lastName'];
        }
    }

    ?>

    <div class="main-container">

        <div class="flex-grow-1 flex-row">

            <section class="left-container">

                <div class="flex-grow-1">
                    <h1 class="c1 text-h1">My Profile</h1>

                    <form id="myprofile-form" method="post">
                        <label for="email">Registered Email</label>
                        <input type="email" name="email" value="<?php echo $_SESSION['email']; ?>" readonly>

                        <label for="fname">Firstname</label>
                        <input type="text" name="fname" id="fname" value="<?php echo $_SESSION['fname']; ?>" onblur="saveChanges()" required>
                        <span id="err-msg-fname"></span>

                        <label for="lname">Lastname</label>
                        <input type="text" name="lname" id="lname" value="<?php echo $_SESSION['lname']; ?>" onblur="saveChanges()" required>
                        <span id="err-msg-lname"></span>
                    </form>

                </div>

                <button data-open-modal id="logout-btn">Logout</button>

            </section>

            <section class="right-container">
                <h1 class="c1 text-h1">Subscribed Plan</h1>
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

    <script>
        //the post query URL is hidden (effect.js)

        function saveChanges() {
            // Get form data
            var formData = new FormData(document.getElementById("myprofile-form"));
            var fnameInput = document.getElementById("fname");
            var lnameInput = document.getElementById("lname");
            var fnameErrMsg = document.getElementById("err-msg-fname");
            var lnameErrMsg = document.getElementById("err-msg-lname");
            var err_found = false;

            fnameErrMsg.style.display = "none";
            lnameErrMsg.style.display = "none";

            if (fnameInput.value === "") {
                fnameErrMsg.innerHTML = "First Name is required";
                fnameErrMsg.style.display = "block";
                err_found = true;
            }

            if (lnameInput.value === "") {
                lnameErrMsg.innerHTML = "Last Name is required";
                lnameErrMsg.style.display = "block";
                err_found = true;
            }

            // Send AJAX request, iff err_found is false
            if (!err_found) {
                var xhr = new XMLHttpRequest();

                xhr.open("POST", "/handlers/update-myprofile.php");

                xhr.onload = function() {
                    if (xhr.status === 200) {

                        showPopup(xhr.responseText);

                    } else {
                        // console.log("Error: " + xhr.statusText);
                        showPopup("AJAX status: " + xhr.statusText);
                    }
                };

                xhr.send(formData);
            }
        }
    </script>

</body>

</html>