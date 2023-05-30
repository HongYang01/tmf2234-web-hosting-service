<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="/assets/image/logo.svg" type="image/x-icon">
    <link rel="stylesheet" href="/css/main.css">
    <link rel="stylesheet" href="/css/paypal_4_failed.css">
    <script src="/js/effect.js"></script>
    <title>Payment Failed</title>
</head>

<body>

    <div id="loader">
        <iframe src="/assets/loading.svg" title="logo"></iframe>
    </div>

    <?php
    require_once($_SERVER['DOCUMENT_ROOT'] . "/auth/auth_session.php");
    require_once($_SERVER['DOCUMENT_ROOT'] . "/includes/nav.php");

    if (!isset($_SESSION['payment_status']) || empty($_SESSION['payment_status'])) {
        header("Location: /index.php");
        exit;
    } else {
        unset($_SESSION['payment_status']);
    }
    ?>

    <div class="main-container center middle">
        <h1>Payment Failed / Cancelled</h1>
        <a id="home" href="/pages/myprofile.php">Back</a>
    </div>

    <?php
    require_once($_SERVER['DOCUMENT_ROOT'] . "/includes/footer.php");
    ?>

    </script>

</body>

</html>