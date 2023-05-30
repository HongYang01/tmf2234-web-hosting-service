document.addEventListener("DOMContentLoaded", function() {

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
});