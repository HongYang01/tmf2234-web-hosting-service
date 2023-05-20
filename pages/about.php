<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/about.css">
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

            </div>
        </header>

        <div class="flex-col middle center"> <h1>Our Team</h1></div>

        <div class="grid-container-left"><img src="https://studentphotos.unimas.my/79880.jpg" alt="79880" width="190px" height="auto">
            <div class="description">
                <h1 class="spacebar">Lim Hong Yang</h1>
                <h4 class="position spacebar">CEO and Founder</h4>
                <p class="spacebar"><br>Managing overall direction and strategy of the company.</p>
            </div> 
            
        </div>

        <div class="grid-container-right">
            <div class="description">
                <h1 class="spacebar">Annastasha Chang See May</h1>
                <h4 class="position spacebar">CFO</h4>
                <p class="spacebar"><br>Managing the company's finances, including budgeting, accounting and financial reporting.</p>
            </div> 
            <img src="https://studentphotos.unimas.my/78855.jpg" alt="78855" width="190px" height="auto">
        </div>

        <div class="grid-container-left"><img src="https://studentphotos.unimas.my/79065.jpg" alt="79065" width="190px" height="auto">
            <div class="description">
                <h1 class="spacebar">Chin Teck Yung</h1>
                <h4 class="position spacebar">Sales Manager</h4>
                <p class="spacebar"><br>Meeting sales targets and developing new business.</p>
            </div> 
            
        </div>

        <div class="grid-container-right">
            <div class="description">
                <h1 class="spacebar">Ee Chee Fat</h1>
                <h4 class="position spacebar">Technical Support Manager</h4>
                <p class="spacebar"><br>Ensures that technical issues are resolved quickly and efficiently.</p>
            </div> 
            <img src="https://studentphotos.unimas.my/79260.jpg" alt="79260" width="190px" height="auto">
        </div>

        <div class="grid-container-left"><img src="https://studentphotos.unimas.my/79027.jpg" alt="79027" width="190px" height="auto">
            <div class="description">
                <h1 class="spacebar">Chai Cheng Kang</h1>
                <h4 class="position spacebar">Product Manager</h4>
                <p class="spacebar"><br>Identification of customers’ needs and product development.</p>
            </div> 
            
        </div>

    </div>

    <div class="flex-col middle center">
        
        <a href="mailto:admin1@semicolonix.com" target="_blank">
            <h3>Contact US</h3>
        </a>
    
    </div>

    <?php
    require_once($_SERVER['DOCUMENT_ROOT'] . "/includes/footer.php");
    ?>
</body>

</html>