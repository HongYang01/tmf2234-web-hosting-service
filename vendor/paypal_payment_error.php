<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="/assets/image/logo.svg" type="image/x-icon">
    <link rel="stylesheet" href="/css/main.css">
    <script src="/js/effect.js"></script>
    <title>Error Subscribe</title>
</head>

<body>

    <div class="flex-col h-100 center middle">
        <?php
        require_once($_SERVER['DOCUMENT_ROOT'] . "/auth/auth_session.php");
        ?>
        <h1>Something went wrong with your payment</h1>
        <a id="home" href="/pages/myprofile.php">Back</a>
    </div>


</body>

</html>