<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/main.css">
    <script src="/js/effect.js"></script>
    <title>About Semicolonix</title>
</head>

<body class="flex-col between">

    <div id="loader">
        <iframe src="/assets/loading.svg" title="logo"></iframe>
    </div>

    <?php
    require_once($_SERVER['DOCUMENT_ROOT'] . "/includes/nav.php");
    ?>

    <div class="flex-grow-1">


        <header class="header-container middle">
            <div class="flex-col middle center">

                <h1 style="margin: 24px 0;">About Us</h1>

                <p class="font-second text-normal" style="width: 45%;text-align: center;"><b>Semicolonix</b>, a web hosting company offering beginner-friendly services to individuals, organizations, and public or private institutions in Malaysia and globally. Our web hosting services include <b>shared, VPS and dedicated</b> server hosting, all with privacy and security. We provide 24/7 advisory and consultancy support to ensure the best client experience. We aim to address common challenges such as lack of knowledge, inefficient servers, and poor technical support that hinder people from adopting web hosting services.</p>

                <div class="flex-col middle">
                    <h1 style="margin: 24px 0;">Organizational Chart</h1>
                    <img src="https://img.freepik.com/premium-vector/corporate-organizational-chart-with-business-avatar-icons_122818-1311.jpg?w=2000" alt="Organizational Chart" width="500px">
                </div>

            </div>
        </header>

    </div>

    <?php
    include($_SERVER['DOCUMENT_ROOT'] . "/includes/footer.php");
    ?>
</body>

</html>