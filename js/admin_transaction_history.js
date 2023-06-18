document.addEventListener("DOMContentLoaded", function () {
	showSubDetail();
});

function showSubDetail() {
	const rows = document.querySelectorAll("#show-sub-detail");

	rows.forEach(function (row) {
		row.addEventListener("click", function (event) {
			event.preventDefault();

			// Retrieve the value of data-plan-id
			const subID = this.getAttribute("data-sub-id");

			fetch(
				location.origin + "/handlers/get_sub_details.php" + "?sub_id=" + encodeURIComponent(subID),
				{
					method: "POST",
					headers: {
						"X-Requested-With": "Fetch",
					},
					body: JSON.stringify({sub_id: subID}),
				}
			)
				.then(function (response) {
					return response.json();
				})
				.then(function (data) {
					if (data.error) {
						throw new Error(data.error);
					} else {
						renderShowSubDetail(data); //send the planInfo to edit
					}
				})
				.catch((error) => {
					showPopup(error);
					console.error(error);
				});
		});
	});
}

function renderShowSubDetail(data) {
	const targetDate = new Date(data.next_bill_date);
	// Get the current date
	const currentDate = new Date();
	// Calculate the countdown in days
	const timeDifference = targetDate - currentDate;
	const countdownInDays = Math.floor(timeDifference / (1000 * 3600 * 24));

	let fullPlanName = data.prod_name + " Hosting (" + data.plan_name + ")";

	let readyTableData = [
		{label: "Plan ID", value: data.plan_id},
		{label: "Plan Name", value: fullPlanName},
		{label: "Subscription ID", value: data.sub_id},
		{label: "Payer Name", value: data.paypal_name},
		{label: "Payer Email", value: data.paypal_email},
		{label: "Account Email", value: data.u_email},
		{label: "Amount Charged (USD)", value: data.amount},
		{label: "Bill Date", value: data.bill_date},
		{label: "Next Bill Date", value: data.next_bill_date},
		{label: "Countdown", value: countdownInDays + " days"},
		{label: "Status", value: data.sub_status},
	];

	const popup = document.getElementById("popup-detail");
	popup.innerHTML = "";
	popup.style.display = "block";

	// ready table
	let table = document.createElement("table");
	table.style.border = "none";
	table.style.margin = "30px 0";

	for (const element of readyTableData) {
		let row = document.createElement("tr");

		let labelCell = document.createElement("th");
		labelCell.style.border = "none";
		labelCell.style.width = "40%"; // Set the width of the first column
		labelCell.textContent = element.label;
		row.appendChild(labelCell);

		let valueCell = document.createElement("td");
		valueCell.style.border = "none";
		valueCell.style.width = "60%"; // Set the width of the second column
		valueCell.textContent = element.value;
		row.appendChild(valueCell);

		table.appendChild(row);
	}
	//close table
	popup.appendChild(table);
}
