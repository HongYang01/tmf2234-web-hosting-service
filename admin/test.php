<?php
// Define the data for your pie chart
$data = [
    ['Category 1', 30, 'red'],
    ['Category 2', 20, 'blue'],
    ['Category 3', 50, 'green']
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Generate new data or fetch the latest analytics data
    // Replace this code with your logic to update the data dynamically
    // $data = generateNewData();
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Pie Chart Example</title>
</head>

<body>
    <canvas id="chartCanvas" width="400" height="400"></canvas>

    <form method="post">
        <button type="submit">Refresh</button>
    </form>

    <script>
        // Get a reference to the canvas element
        const canvas = document.getElementById('chartCanvas');
        const context = canvas.getContext('2d');

        // Retrieve the data from PHP
        const data = <?php echo json_encode($data); ?>;

        // Calculate the total value of all data points
        const totalValue = data.reduce((total, item) => total + item[1], 0);

        // Set the starting angle for the first slice
        let startAngle = 0;

        // Iterate over the data and draw each slice of the pie chart
        data.forEach(item => {
            // Calculate the slice angle based on the item value and the total value
            const sliceAngle = (item[1] / totalValue) * 2 * Math.PI;

            // Set the fill color for the slice
            context.fillStyle = item[2];

            // Start a new path
            context.beginPath();

            // Move the starting point to the center of the canvas
            context.moveTo(canvas.width / 2, canvas.height / 2);

            // Draw the arc representing the slice
            context.arc(
                canvas.width / 2,
                canvas.height / 2,
                canvas.width / 2,
                startAngle,
                startAngle + sliceAngle
            );

            // Connect the last point of the arc back to the center
            context.lineTo(canvas.width / 2, canvas.height / 2);

            // Fill the slice with the specified color
            context.fill();

            // Update the starting angle for the next slice
            startAngle += sliceAngle;
        });
    </script>
</body>

</html>