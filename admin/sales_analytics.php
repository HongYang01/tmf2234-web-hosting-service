<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="/assets/image/logo.svg" type="image/x-icon">
    <link rel="stylesheet" href="/css/main.css">
    <link rel="stylesheet" href="/css/sales-analytics.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="/js/effect.js"></script>
    <script src="/js/sales_analytics.js"></script>
    <title>Sales Analytics</title>
</head>
<body> 

    <div id="loader">
        <iframe src="/assets/loading.svg" title="logo"></iframe>
    </div>

    <?php

        require_once($_SERVER['DOCUMENT_ROOT'] . "/config/conn.php");
        require_once($_SERVER['DOCUMENT_ROOT'] . "/auth/auth_session.php");
        require_once($_SERVER['DOCUMENT_ROOT'] . "/auth/CheckLogin.php");

        if (!checkLoggedIn()) {
            header("Location: /pages/login_form.php");
            exit;
        }

        require_once($_SERVER['DOCUMENT_ROOT'] . "/includes/nav.php");

        try {
            /* --------------- Line Chart ---------------*/
            $query = "SELECT YEAR(bill_date) AS year, 
                        MONTHNAME(bill_date) AS month, 
                        SUM(payment_amount) AS total_sales 
                        FROM payments 
                        GROUP BY year, month 
                        ORDER BY year, MONTH(bill_date)";
            $result = mysqli_query($conn, $query);

            //initialize empty array
            $labels = [];
            $data = [];

            if(mysqli_num_rows($result) > 0){
                while ($row = $result->fetch_array()) {
                $year = $row['year'];
                $month = $row['month'];
                $labels[] = $year . "-" . $month; // Example format: 2023-January
                $data[] = $row['total_sales'];
                }
            }

            $encodedLabels = json_encode($labels);
            $encodedData = json_encode($data);
            echo "<script>var labels = $encodedLabels; var data = $encodedData; </script>";
            
            /* --------------- Pie Chart ---------------*/
            $query1 = "SELECT product_name AS ProductName, 
                        COUNT(product_id) AS Quantity 
                        FROM payments 
                        GROUP BY product_name";
            $result1 = mysqli_query($conn, $query1);

            $pieLabels = [];
            $pieData = [];

            if(mysqli_num_rows($result1) > 0){
                while ($row = $result1->fetch_array()) {
                    $category = $row['ProductName'];
                    $pieLabels[] = $category;
                    $pieData[] = $row['Quantity'];
                }
            }

            $encodedPieLabels = json_encode($pieLabels);
            $encodedPieData = json_encode($pieData);
            echo "<script>var pieLabels = $encodedPieLabels; var pieData = $encodedPieData; </script>";


        } catch (Exception $e) {
            $errorMessage = "Error: " . $e->getMessage();
            $encodedMessage = json_encode($errorMessage);
            echo "<script>showPopup($encodedMessage);</script>";
        }

        $conn->close();

    ?>

    <main class="flex-grow-1 flex-col center middle">
        
        <div class="header-container flex-row middle">
            <h1 class="c1 text-title">Sales Analytics</h1>
        </div>

        <div class="charts">

            <div class="charts-card">
                <div class="chartBox">
                    <canvas id="lineChart"></canvas>
                </div>
            </div>

            <div class="charts-card">
                <div class="chartBox">
                    <canvas id="pieChart"></canvas>
                </div>
            </div>
            
        </div>
        
    </main>
    
    <?php require_once($_SERVER['DOCUMENT_ROOT'] . "/includes/footer.php"); ?>

</body>
</html>
