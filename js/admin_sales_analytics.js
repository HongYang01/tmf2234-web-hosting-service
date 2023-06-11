document.addEventListener("DOMContentLoaded", function () {
	createLineGraph();
	createPieChart();
});

/*######################################*
||         Create Line Graph          ||
*######################################*/

function createLineGraph() {
	fetch(location.origin + "/handlers/admin_get_line_graph_data.php", {
		headers: {
			"X-Requested-With": "Fetch",
		},
	})
		.then((response) => response.json())
		.then((res) => {
			// Process the response from PHP here
			if (res.error) {
				throw new Error(res.error);
			}
			let labels = res.label;
			let data = res.data;

			new Chart("lineChart", {
				type: "line",
				data: {
					labels: labels,
					datasets: [
						{
							fill: false,
							lineTension: 0,
							backgroundColor: "rgba(0,0,255,1.0)",
							borderColor: "rgba(0,0,255,0.1)",
							data: data,
						},
					],
				},
				options: {
					plugins: {
						title: {
							display: true,
							text: "All Time Sales",
							align: "center",
							font: {
								size: 16,
							},
						},
						legend: {
							display: false,
						},
					},
					scales: {
						x: {
							title: {
								display: true,
								text: "Daily",
								font: {
									size: 14,
									weight: "bold",
								},
							},
						},
						y: {
							title: {
								display: true,
								text: "Sales (USD)",
								font: {
									size: 14,
									weight: "bold",
								},
							},
							beginAtZero: true, // Start the y-axis at 0
						},
					},
					maintainAspectRatio: false, // Respect the height previously added to the canvas
				},
			});
		})
		.catch((error) => {
			console.error(error);
		});
}

/*######################################*
||          Create Pie Chart          ||
*######################################*/

// Function to generate random background colors
function generateBackgroundColors(numColors) {
	const colors = [];
	for (let i = 0; i < numColors; i++) {
		const color = `rgba(${getRandomNumber(0, 255)}, ${getRandomNumber(0, 255)}, ${getRandomNumber(
			0,
			255
		)}, 1)`;
		colors.push(color);
	}
	return colors;
}

// Function to generate random number within a range
function getRandomNumber(min, max) {
	return Math.floor(Math.random() * (max - min + 1) + min);
}

function createPieChart() {
	fetch(location.origin + "/handlers/admin_get_pie_graph_data.php", {
		headers: {
			"X-Requested-With": "Fetch",
		},
	})
		.then((response) => response.json())
		.then((res) => {
			if (res.error) {
				throw new Error(res.error);
			}

			let pieLabels = res.pieLabels;
			let pieData = res.pieData;
			const numCategories = pieLabels.length;

			// Generate random background colors
			const backgroundColors = generateBackgroundColors(numCategories);

			new Chart("pieChart", {
				type: "pie",
				data: {
					labels: pieLabels,
					datasets: [
						{
							backgroundColor: backgroundColors,
							data: pieData,
						},
					],
				},
				options: {
					plugins: {
						title: {
							display: true,
							text: "All Time Sales (USD) by Category",
							align: "center",
							font: {
								size: 16,
							},
						},
						legend: {
							position: "bottom", // Move legend to the bottom
							labels: {
								padding: 20, // Increase padding between legend items
							},
						},
					},
					maintainAspectRatio: false, // Adjust as needed
				},
			});
		})
		.catch((error) => {
			console.error(error);
		});
}
