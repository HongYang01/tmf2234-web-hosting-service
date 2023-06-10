/*
################################
||                            ||
||          Function          ||
||                            ||
################################

- load the subscribed plan(s) afer DOM loaded
- Get subscribed plan from [payment] table
- Render table
- sort plan by: defaul | name | date

- Get plan detail
- Get plan feature detail
- Render FULL plan details (click Listener)

*/

/*
################################
||                            ||
||  after DOM content loaded  ||
||                            ||
################################
*/

document.addEventListener("DOMContentLoaded", function () {
	sortAllSub("default").catch(function (error) {
		console.log(error);
	});
});

/*
################################
||                            ||
||    Get subscribed plan     ||
||     Render plan table      ||
||         Sort plan          ||
||                            ||
################################
*/

function getAllSub(sortBy) {
	return fetch(location.origin + "/handlers/get_all_subscription.php", {
		method: "POST",
		headers: {
			"Content-Type": "application/json",
		},
		body: JSON.stringify({sortBy: sortBy}),
	})
		.then(function (response) {
			return response.json();
		})
		.then(function (data) {
			if (data.error) {
				let tableContainer = document.getElementById("render-plan");
				tableContainer.innerHTML = "";
				let test = document.createElement("p");
				test.textContent = data.error;
				tableContainer.appendChild(test);
				return null;
			} else {
				if (sortBy == "name") {
					showPopup("Sorting type: Plan name");
				} else if (sortBy == "date") {
					showPopup("Sorting type: Next Bill Date");
				}
				return data;
			}
		})
		.catch(function (error) {
			showPopup(error);
			console.error("Error: ", error);
			return null;
		});
}

async function sortAllSub(sortBy) {
	const allSubPlan = await getAllSub(sortBy);

	if (allSubPlan != null) {
		renderSubPlan(allSubPlan); // render if no problem
	}
}

function renderSubPlan(payments) {
	let tableContainer = document.getElementById("render-plan");

	// Clear previous elements
	tableContainer.innerHTML = "";

	// Create table
	let table = document.createElement("table");
	table.className = "payment-table";

	// Create table header
	let thead = document.createElement("thead");
	let headerRow = document.createElement("tr");

	let thName = document.createElement("th");
	thName.textContent = "Plan Name";
	headerRow.appendChild(thName);

	let thInvoiceId = document.createElement("th");
	thInvoiceId.textContent = "Subscription ID";
	headerRow.appendChild(thInvoiceId);

	let thStartDate = document.createElement("th");
	thStartDate.textContent = "Bill Date";
	headerRow.appendChild(thStartDate);

	let thMaturityDate = document.createElement("th");
	thMaturityDate.textContent = "Next Bill Date";
	headerRow.appendChild(thMaturityDate);

	let thStatus = document.createElement("th");
	thStatus.textContent = "Status";
	headerRow.appendChild(thStatus);

	thead.appendChild(headerRow);
	table.appendChild(thead);

	// Create table body
	let tbody = document.createElement("tbody");

	for (const payment of payments) {
		if (payment.sub_status === "CANCELED") {
			continue;
		}

		let row = document.createElement("tr");
		row.setAttribute("id", "plan-row");
		row.setAttribute("data-plan-id", payment.plan_id);
		row.setAttribute("data-sub-id", payment.sub_id);

		let nameCell = document.createElement("td");
		nameCell.textContent = payment.plan_name;
		row.appendChild(nameCell);

		let subIdCell = document.createElement("td");
		subIdCell.textContent = payment.sub_id;
		row.appendChild(subIdCell);

		let startDateCell = document.createElement("td");
		startDateCell.textContent = myDateTimeFormat(payment.bill_date);
		row.appendChild(startDateCell);

		let nextBillCell = document.createElement("td");
		nextBillCell.textContent = myDateTimeFormat(payment.next_bill_date);
		row.appendChild(nextBillCell);

		let statusCell = document.createElement("td");
		statusCell.textContent = payment.sub_status;
		if (payment.sub_status === "ACTIVE") {
			statusCell.className = "green text-normal font-w-600";
		} else if (payment.sub_status === "SUSPENDED") {
			statusCell.className = "orange text-normal font-w-600";
		} else if (payment.sub_status === "CANCELLED") {
			statusCell.className = "red text-normal font-w-600";
		}
		row.appendChild(statusCell);

		tbody.appendChild(row);
	}

	table.appendChild(tbody);
	tableContainer.appendChild(table);
}

/*
################################
||                            ||
||  Get Product FULL Detail   ||
||        Render Popup        ||
||       Click Listener       ||
||                            ||
################################
*/

function getPlanDetail(planID) {
	return fetch(
		location.origin + "/handlers/get_plan_details.php" + "?plan_id=" + encodeURIComponent(planID)
	)
		.then(function (response) {
			return response.json();
		})
		.then(function (data) {
			if (data.error) {
				throw new Error(data.error);
			} else {
				return data;
			}
		})
		.catch(function (error) {
			showPopup(error);
			console.error(error);
			return null;
		});
}

// render popup
async function renderSubPlanDetail(planID, subID) {
	/*
	#############################################
	||   render payment detail (by default)    ||
	#############################################
	*/

	let planData;
	const allSub = await getAllSub("default");

	// getting all subscription successful
	if (allSub == null) {
		return;
	} else {
		planData = allSub.find((temp) => temp.sub_id === subID);

		// if sub id not found
		if (!planData) {
			showPopup("Error: Subscription ID [" + subID + "] not found ");
			return;
		}
	}

	const targetDate = new Date(planData.next_bill_date);
	// Get the current date
	const currentDate = new Date();
	// Calculate the countdown in days
	const timeDifference = targetDate - currentDate;
	const countdownInDays = Math.floor(timeDifference / (1000 * 3600 * 24));

	let readyTableData = [
		{label: "Plan ID", value: planData.plan_id},
		{label: "Subscription ID", value: planData.sub_id},
		{label: "Plan Name", value: planData.plan_name},
		{label: "Amount Charged (USD)", value: planData.amount},
		{label: "Bill Date", value: window.myDateTimeFormat(planData.bill_date)},
		{label: "Next Bill Date", value: window.myDateTimeFormat(planData.next_bill_date)},
		{label: "Countdown", value: countdownInDays + " days"},
		{label: "Status", value: planData.sub_status},
		{label: "Actions", value: prepareActionButton(planData.sub_id, planData.sub_status)},
	];

	// show popup
	const popUpDetail = document.getElementById("popup-details");
	popUpDetail.style.display = "block";

	// ready table
	let tableContainer = document.getElementById("plan-detail-table-container");
	tableContainer.innerHTML = "";
	let table = document.createElement("table");
	table.style.border = "none";
	table.style.margin = "30px 0";

	for (const element of readyTableData) {
		let row = document.createElement("tr");

		let labelCell = document.createElement("th");
		labelCell.style.border = "none";
		labelCell.style.width = "20%"; // Set the width of the first column
		labelCell.textContent = element.label;
		row.appendChild(labelCell);

		let valueCell = document.createElement("td");
		valueCell.style.border = "none";
		valueCell.style.width = "80%"; // Set the width of the second column
		if (element.label === "Actions") {
			valueCell.appendChild(element.value); // Append the action buttons div
		} else {
			valueCell.textContent = element.value;
		}
		row.appendChild(valueCell);

		table.appendChild(row);
	}
	//close table
	tableContainer.appendChild(table);

	/*
	###################################
	||       render plan detail      ||
	###################################
	*/
	let allFeatures;

	const planDetail = await getPlanDetail(planID);

	if (planDetail == null) {
		showPopup("Plan [" + planID + "] details not found");
		return;
	}

	const includeContainer = document.getElementById("popup-content-2-include");
	const excludeContainer = document.getElementById("popup-content-2-exclude");

	includeContainer.innerHTML = "";
	excludeContainer.innerHTML = "";

	allFeatures = planDetail.plan_detail;

	allFeatures.forEach((temp) => {
		let p = document.createElement("p");
		p.textContent = temp.feature;

		if (temp.status == "1") {
			p.insertAdjacentHTML("afterbegin", '<span class="icon-tick"></span>');
			includeContainer.appendChild(p);
		} else {
			p.insertAdjacentHTML("afterbegin", '<span class="icon-cross"></span>');
			excludeContainer.appendChild(p);
		}
	});
}

function prepareActionButton(subID, subStatus) {
	let div = document.createElement("div");
	div.className = "flex-row";

	// only ACTIVE & SUSPENDED plan can CANCEL the plan
	if (subStatus === "ACTIVE" || subStatus === "SUSPENDED") {
		let btn = document.createElement("button");
		btn.textContent = "Cancel Plan";
		btn.id = "popup-btn-cancel";
		btn.onclick = function () {
			cancelSub(subID); // CANCEL subscription
		};
		div.appendChild(btn);
	}

	// only ACTIVE plan can SUSPEND the plan
	if (subStatus === "ACTIVE") {
		let btn2 = document.createElement("button");
		btn2.textContent = "Temporarily Stop";
		btn2.id = "popup-btn-suspend";
		btn2.onclick = function () {
			suspendSub(subID); // SUSPEND(pause) subscription
		};
		div.appendChild(btn2);
	} else if (subStatus === "SUSPENDED") {
		let btn3 = document.createElement("button");
		btn3.textContent = "Reactivate Plan";
		btn3.id = "popup-btn-reactivate";
		btn3.onclick = function () {
			reactivateSub(subID); // REACTIVATE subscription
		};
		div.appendChild(btn3);
	} else {
		let text = document.createElement("p");
		text.textContent = "Reactivate not permitted (Billing Stopped)";
		div.appendChild(text);
	}

	return div; // return all button in a container
}

// Click Listener
document.addEventListener("DOMContentLoaded", function () {
	// Attach event listener to a parent element
	document.addEventListener("click", handlePlanRowClick);

	// Function to handle the click event on plan rows
	function handlePlanRowClick(event) {
		const planRow = event.target.closest("#plan-row");

		if (planRow) {
			const planID = planRow.getAttribute("data-plan-id");
			const subID = planRow.getAttribute("data-sub-id");
			renderSubPlanDetail(planID, subID);
		}
	}
});

function suspendSub(subID) {
	// update in paypal
	// update in database
	subID = subID.toString();
	showPopup("Requesting PayPal API...");
	document.body.style.pointerEvents = "none";

	fetch(location.origin + "/vendor/paypal_10_suspendSub.php", {
		method: "POST",
		headers: {
			"Content-Type": "application/json",
		},
		body: JSON.stringify({sub_id: subID}),
	})
		.then(function (response) {
			if (!response.ok) {
				throw new Error("Failed to suspend your subscription");
			}
			return response.json();
		})
		.then((data) => {
			if (data.error) {
				throw new Error(data.error);
			} else if (data.success) {
				showPopup(data.success);
				setTimeout(function () {
					location.reload();
				}, 1500);
			} else {
				throw new Error("Somthing went wrong");
			}
		})
		.catch((error) => {
			showPopup(error);
			console.error(error);
			document.body.style.pointerEvents = "auto";
		});
}

function cancelSub(subID) {
	// update in paypal
	// update in database

	showPopup("Requesting PayPal API...");
	document.body.style.pointerEvents = "none";

	fetch(location.origin + "/vendor/paypal_11_cancelSub.php", {
		method: "POST",
		body: JSON.stringify({sub_id: subID}),
	})
		.then(function (response) {
			if (!response.ok) {
				throw new Error("Failed to cancel your subscription");
			}
			return response.json();
		})
		.then((data) => {
			if (data.error) {
				throw new Error(data.error);
			} else if (data.success) {
				showPopup(data.success);
				setTimeout(function () {
					location.reload();
				}, 1500);
			} else {
				throw new Error("Somthing went wrong");
			}
		})
		.catch((error) => {
			showPopup(error);
			console.error(error);
			document.body.style.pointerEvents = "auto";
		});
}

function reactivateSub(subID) {
	// update in paypal
	// update in database

	showPopup("Requesting PayPal API...");
	document.body.style.pointerEvents = "none";

	fetch(location.origin + "/vendor/paypal_12_reactivateSub.php", {
		method: "POST",
		body: JSON.stringify({sub_id: subID}),
	})
		.then(function (response) {
			if (!response.ok) {
				throw new Error("Failed to reactivate your subscription");
			}
			return response.json();
		})
		.then((data) => {
			if (data.error) {
				throw new Error(data.error);
			} else if (data.success) {
				showPopup(data.success);
				setTimeout(function () {
					location.reload();
				}, 1500);
			} else {
				throw new Error("Somthing went wrong");
			}
		})
		.catch((error) => {
			showPopup(error);
			console.error(error);
			document.body.style.pointerEvents = "auto";
		});
}

/*######################################*
||        Transaction History         ||
*######################################*/

function getTransactionHistory(subID) {}

function rederTransactionHistory(subID) {
	// create a table
	// list all transaction
}

/*
################################
||                            ||
||        ESC Listener        ||
||                            ||
################################
*/

document.addEventListener("keydown", function (event) {
	if (event.key === "Escape" || event.key === "Esc") {
		closePopupDetail();
	}
});

function closePopupDetail() {
	const planDetail = document.getElementById("popup-details");

	if (planDetail.style.display === "block") {
		planDetail.style.display = "none";
	}
}
