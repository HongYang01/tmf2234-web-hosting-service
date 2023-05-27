/*
################################
||                            ||
||          Function          ||
||                            ||
################################

- Save profile changes
- load the subscribed plan(s) afer DOM loaded
- Get subscribed plan from [payment] table
- Render table
- sort plan by: defaul | name | date

- Get product detail
- Get product feature detail
- Render FULL product details (click Listener)

*/

function saveChanges() {
	// Get form data
	let formData = new FormData(document.getElementById("myprofile-form"));
	let fnameInput = document.getElementById("fname");
	let lnameInput = document.getElementById("lname");
	let fnameErrMsg = document.getElementById("err-msg-fname");
	let lnameErrMsg = document.getElementById("err-msg-lname");
	let err_found = false;

	fnameErrMsg.style.display = "none";
	lnameErrMsg.style.display = "none";

	if (fnameInput.value === "") {
		fnameErrMsg.innerHTML = "First Name is required";
		fnameErrMsg.style.display = "block";
		err_found = true;
	}

	if (lnameInput.value === "") {
		lnameErrMsg.innerHTML = "Last Name is required";
		lnameErrMsg.style.display = "block";
		err_found = true;
	}

	// Send AJAX request, iff err_found is false
	if (!err_found) {
		let xhr = new XMLHttpRequest();

		xhr.open("POST", "/handlers/update_myprofile_handler.php");

		xhr.onload = function () {
			if (xhr.status === 200) {
				showPopup(xhr.responseText);
			} else {
				// console.log("Error: " + xhr.statusText);
				showPopup("AJAX status: " + xhr.statusText);
			}
		};

		xhr.send(formData);
	}
}

/*
################################
||                            ||
||  after DOM content loaded  ||
||                            ||
################################
*/

document.addEventListener("DOMContentLoaded", async function () {
	sortPlan("default");
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

function getSubPlan(sortBy) {
	return new Promise((resolve, reject) => {
		fetch(location.origin + "/handlers/get_all_payment.php", {
			method: "POST",
			headers: {
				"Content-Type": "application/json",
			},
			body: JSON.stringify({sortBy: sortBy}),
		})
			.then(function (response) {
				return response.json();
			})
			.then((data) => {
				if (data.error) {
					let tableContainer = document.getElementById("render-plan");
					tableContainer.innerHTML = "";
					let test = document.createElement("p");
					test.textContent = data.error;
					tableContainer.appendChild(test);
					resolve(null); // Resolving the promise with null
				} else {
					if (sortBy == "name") {
						showPopup("Sorting type: Plan name");
					} else if (sortBy == "date") {
						showPopup("Sorting type: Maturity date");
					}
					resolve(data); // Resolving the promise with the data
				}
			})
			.catch((error) => {
				console.error("Error: ", error);
				reject(error); // Rejecting the promise with the error
			});
	});
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
	thInvoiceId.textContent = "Invoice ID";
	headerRow.appendChild(thInvoiceId);

	let thStartDate = document.createElement("th");
	thStartDate.textContent = "Start Date";
	headerRow.appendChild(thStartDate);

	let thMaturityDate = document.createElement("th");
	thMaturityDate.textContent = "Maturity Date";
	headerRow.appendChild(thMaturityDate);

	let thStatus = document.createElement("th");
	thStatus.textContent = "Status";
	headerRow.appendChild(thStatus);

	thead.appendChild(headerRow);
	table.appendChild(thead);

	// Create table body
	let tbody = document.createElement("tbody");

	payments.forEach((payment) => {
		let row = document.createElement("tr");
		row.setAttribute("id", "plan-row");
		row.setAttribute("data-prod-id", payment.product_id);
		row.setAttribute("data-invoice-id", payment.invoice_id);

		let nameCell = document.createElement("td");
		nameCell.textContent = payment.product_name;
		row.appendChild(nameCell);

		let invoiceIdCell = document.createElement("td");
		invoiceIdCell.textContent = payment.invoice_id;
		row.appendChild(invoiceIdCell);

		let startDateCell = document.createElement("td");
		startDateCell.textContent = payment.bill_date;
		row.appendChild(startDateCell);

		let maturityCell = document.createElement("td");
		maturityCell.textContent = payment.maturity_date;
		row.appendChild(maturityCell);

		let statusCell = document.createElement("td");
		// NOTE: need to "parseInt" to cast plan_status to integer, because it came back from PHP JSON encode, so it is more likely to become a string
		if (parseInt(payment.plan_status) === 1) {
			statusCell.textContent = "Active";
			statusCell.className = "green text-normal font-w-600";
		} else {
			statusCell.textContent = "Expired";
			statusCell.className = "red text-normal font-w-600";
		}
		row.appendChild(statusCell);

		tbody.appendChild(row);
	});

	// for (let index = 0; index < 50; index++) {
	// 	let row = document.createElement("tr");
	// 	let maturityCell = document.createElement("td");
	// 	maturityCell.textContent = "Testing use";
	// 	row.appendChild(maturityCell);
	// 	tbody.appendChild(row);
	// }

	table.appendChild(tbody);
	tableContainer.appendChild(table);

	// show sorting type
}

/**
 * POST to php to retrive subscribed plan
 * @param {String} sortBy default | name | date
 */
function sortPlan(sortBy) {
	getSubPlan(sortBy)
		.then((data) => {
			if (data !== null) {
				renderSubPlan(data); // Handle the returned data
			}
		})
		.catch((error) => {
			console.error(error); // Handle the error
		});
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

function getProductDetail(productId) {
	return new Promise((resolve, reject) => {
		fetch(location.origin + "/handlers/get_all_product_detail.php", {
			method: "POST",
			headers: {
				"Content-Type": "application/json",
			},
			body: JSON.stringify({prod_id: productId}),
		})
			.then(function (response) {
				return response.json();
			})
			.then((data) => {
				if (data.error) {
					showPopup(data.error);
					resolve(null); // Resolving the promise with null (return null)
				} else {
					resolve(data); // Resolving the promise with the data (return data)
				}
			})
			.catch((error) => {
				console.error("Error: ", error);
				reject(error); // Rejecting the promise with the error
			});
	});
}

// render popup
function renderSubPlanDetail(productId, invoiceId) {
	/*
	#############################################
	||   render payment detail (by default)    ||
	#############################################
	*/

	let paymentData;

	getSubPlan("default")
		.then((data) => {
			if (data !== null) {
				// match invoice, because getSubPlan return all user's payment
				paymentData = data.find((temp) => temp.invoice_id === invoiceId);

				if (!paymentData) {
					showPopup("Error: Invoice not found " + invoiceId);
					return;
				}

				const popUpDetail = document.getElementById("popup-details");
				const headerValue = document.getElementById("popup-content-1-value");

				headerValue.innerHTML = "";
				popUpDetail.style.display = "block";

				let p1 = document.createElement("p");
				p1.textContent = paymentData.product_name;
				headerValue.appendChild(p1);

				let p2 = document.createElement("p");
				p2.textContent = paymentData.invoice_id;
				headerValue.appendChild(p2);

				let p3 = document.createElement("p");
				p3.textContent = paymentData.bill_date;
				headerValue.appendChild(p3);

				let p4 = document.createElement("p");
				p4.textContent = paymentData.maturity_date;
				headerValue.appendChild(p4);

				// Convert string to date
				const targetDate = new Date(paymentData.maturity_date);
				// Get the current date
				const currentDate = new Date();
				// Calculate the countdown in days
				const timeDifference = targetDate.getTime() - currentDate.getTime();
				const countdownInDays = Math.floor(timeDifference / (1000 * 3600 * 24));

				let p5 = document.createElement("p");
				p5.textContent = countdownInDays + " Days";
				headerValue.appendChild(p5);

				let p6 = document.createElement("p");
				if (parseInt(paymentData.plan_status) === 1) {
					p6.textContent = "Active";
					p6.className = "green text-normal font-w-600";
				} else {
					p6.textContent = "Expired";
					p6.className = "red text-normal font-w-600";
				}
				headerValue.appendChild(p6);
			}
		})
		.catch((error) => {
			console.error(error);
			return;
		});

	/*
	########################################
	||       render product detail        ||
	########################################
	*/
	let includeArr;
	let excludeArr;

	getProductDetail(productId)
		.then((data) => {
			if (data !== null) {
				const includeContainer = document.getElementById("popup-content-2-include");
				const excludeContainer = document.getElementById("popup-content-2-exclude");

				includeContainer.innerHTML = "";
				excludeContainer.innerHTML = "";

				includeArr = data.include;
				excludeArr = data.exclude;

				includeArr.forEach((feature) => {
					let p = document.createElement("p");
					p.textContent = feature;

					p.insertAdjacentHTML("afterbegin", '<span class="icon-tick"></span>');

					includeContainer.appendChild(p);
				});

				excludeArr.forEach((feature) => {
					let p = document.createElement("p");
					p.textContent = feature;

					p.insertAdjacentHTML("afterbegin", '<span class="icon-cross"></span>');

					excludeContainer.appendChild(p);
				});
			}
		})
		.catch((error) => {
			console.error(error);
			return;
		});
}

// Click Listener
document.addEventListener("DOMContentLoaded", async function () {
	// Attach event listener to a parent element
	document.addEventListener("click", handlePlanRowClick);

	// Function to handle the click event on plan rows
	function handlePlanRowClick(event) {
		event.preventDefault();
		const planRow = event.target.closest("#plan-row");

		if (planRow) {
			const productId = planRow.getAttribute("data-prod-id");
			const invoiceId = planRow.getAttribute("data-invoice-id");
			renderSubPlanDetail(productId, invoiceId);
		}
	}
});

/*
################################
||                            ||
||        Esc Listener        ||
||                            ||
################################
*/

document.addEventListener("keydown", function (event) {
	const planDetail = document.getElementById("popup-details");

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
