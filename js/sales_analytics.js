document.addEventListener("DOMContentLoaded", function() {

    /* --------------- Line Chart ---------------*/
    new Chart("lineChart", {
        type: "line",
        data: {
            labels: labels,
            datasets: [{
            fill: false,
            lineTension: 0,
            backgroundColor: "rgba(0,0,255,1.0)",
            borderColor: "rgba(0,0,255,0.1)",
            data: data
            }]
        },
        options: {
            plugins: {
                title: {
                    display: true,
                    text: 'Total Sales',
                    align: 'center',
                    font: {
                        size: 16
                    }
                },
                legend: {
                    display: false,
                }
            },
            scales: {
                x: {
                    title: {
                        display: true,
                        text: 'Month',
                        font: {
                            size: 14,
                            weight: 'bold'
                        }
                    }
                },
                y: {
                    title: {
                        display: true,
                        text: 'Sales (USD)',
                        font: {
                            size: 14,
                            weight: 'bold'
                        }
                    },
                    beginAtZero: true // Start the y-axis at 0
                }
            },
            maintainAspectRatio: false, // Respect the height previously added to the canvas
        }
    });

    /* --------------- Pie Chart ---------------*/
    // Define the number of categories
    const numCategories = pieLabels.length;

    // Generate random background colors
    const backgroundColors = generateBackgroundColors(numCategories);

    // Function to generate random background colors
    function generateBackgroundColors(numColors) {
        const colors = [];
        for (let i = 0; i < numColors; i++) {
            const color = `rgba(${getRandomNumber(0, 255)}, ${getRandomNumber(0,255)}, ${getRandomNumber(0, 255)}, 1)`;
            colors.push(color);
        }
        return colors;
    }

    // Function to generate random number within a range
    function getRandomNumber(min, max) {
        return Math.floor(Math.random() * (max - min + 1) + min);
    }

    new Chart("pieChart", {
        type: "pie",
        data: {
            labels: pieLabels,
            datasets: [{
                backgroundColor: backgroundColors,
                data: pieData
            }]
        },
        options: {
            plugins: {
                title: {
                    display: true,
                    text: 'Sales by Category',
                    align: 'center',
                    font: {
                        size: 16
                    }
                },
                legend: {
                    position: 'bottom', // Move legend to bottom
                    spacing: 20 // Adjust the value as needed
                },
            },
            maintainAspectRatio: false // Adjust as needed
        }
    });
    
});