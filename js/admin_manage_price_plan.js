document.addEventListener("DOMContentLoaded", function () {
	editPlan();
});

function editPlan() {
	const rowBtn = document.querySelectorAll("#plan-row");

	rowBtn.forEach(function (row) {
		row.addEventListener("click", function (event) {
			event.preventDefault();

			// Retrieve the value of data-plan-id
			const planId = this.getAttribute("data-plan-id");
			const planStatus = this.getAttribute("data-plan-status");

			fetch(
				location.origin +
					"/handlers/get_plan_details.php" +
					"?plan_id=" +
					encodeURIComponent(planId)
			)
				.then(function (response) {
					return response.json();
				})
				.then((data) => {
					if (data.error) {
						throw new Error(data.error);
					} else {
						if (planStatus === "ACTIVE") {
							redirectToEdit(planId); // send the planId
						} else {
							renderActivateContainer(data); // reativate plan first
						}
					}
				})
				.catch((error) => {
					showPopup(error);
					console.error(error);
				});
		});
	});
}

/**
 * Only redirect when the plan_status is ACTIVATE
 * @param {string} plan_id
 */
function redirectToEdit(plan_id) {
	// Create a form dynamically
	const form = document.createElement("form");
	form.method = "POST";
	form.action = location.origin + "/admin/edit_price_plan.php";

	// Create a hidden input field for the JSON data
	const dataInput = document.createElement("input");
	dataInput.type = "hidden";
	dataInput.name = "plan_id";
	dataInput.value = plan_id.toString(); // need to cast it to string
	form.appendChild(dataInput);

	// Append the form to the document body and submit it
	document.body.appendChild(form);
	form.submit();
}

/**
 *
 * @param {JSON} planInfo
 */
function renderActivateContainer(planInfo) {
	/*
	1. popup toggle plan status
	2. request API from paypal_8_activatePlan.php (return HTTP: 204)
	3. update to database is execute in paypal_8_activatePlan.php
	*/

	const mainContainer = document.querySelector(".grid-layout-content-2");
	mainContainer.style.position = "relative";

	/*######################################*
	||          Popup Container           ||
	*######################################*/
	const popupContainer = document.createElement("div");
	popupContainer.id = "popup-reactivate-container";
	popupContainer.style.display = "flex";

	/*######################################*
	||                 h1                 ||
	*######################################*/
	const h1 = document.createElement("h1");
	h1.textContent = "Reactivate This Plan?";
	popupContainer.appendChild(h1);

	/*######################################*
	||            p - plan_id             ||
	*######################################*/
	const p1 = document.createElement("p");
	p1.style.textAlign = "center";
	p1.textContent = planInfo.plan_id;
	popupContainer.appendChild(p1);

	/*######################################*
	||           p - prod_name            ||
	*######################################*/
	const p2 = document.createElement("p");
	p2.style.textAlign = "center";
	p2.textContent = planInfo.prod_name + " Hosting (" + planInfo.plan_name + ")";
	popupContainer.appendChild(p2);

	/*######################################*
	||          p - are you sure          ||
	*######################################*/
	const p3 = document.createElement("p");
	p3.style.textAlign = "center";
	p3.innerHTML =
		"Are you sure you want to re-activate this plan? <br>Only then you can edit the details";
	popupContainer.appendChild(p3);

	/*######################################*
	||         div - put Buttons          ||
	*######################################*/
	const divBtn = document.createElement("div");
	divBtn.id = "popup-reactivate-btn-container";

	/*######################################*
	||             NO button              ||
	*######################################*/
	const btnNo = document.createElement("button");
	btnNo.textContent = "NO";
	btnNo.style.width = "fit-content";
	btnNo.addEventListener("click", function () {
		popupContainer.style.display = "none";
	});
	divBtn.appendChild(btnNo);

	/*######################################*
	||             YES button             ||
	*######################################*/
	const btnYes = document.createElement("button");
	btnYes.textContent = "YES";
	btnYes.style.width = "fit-content";
	btnYes.addEventListener("click", function () {
		activatePlan(planInfo);
	});
	divBtn.appendChild(btnYes);

	/*######################################*
	||        Put button into div         ||
	*######################################*/
	popupContainer.appendChild(divBtn);

	mainContainer.appendChild(popupContainer);
}

/**
 * @param {JSON} planInfo
 */
function activatePlan(planInfo) {
	document.body.style.pointerEvents = "none";
	showPopup("Requesting PayPal API...");

	fetch(location.origin + "/vendor/paypal_8_activatePlan.php", {
		method: "POST",
		body: JSON.stringify({plan_id: planInfo.plan_id}),
	})
		.then(function (response) {
			return response.json();
		})
		.then((data) => {
			if (data.error) {
				throw new Error(data.error);
			} else {
				showPopup("Plan activated successfully");
				setTimeout(() => {
					window.location.reload();
				}, 1500);
			}
		})
		.catch((error) => {
			showPopup(error);
			console.error(error);
		});
	document.body.style.pointerEvents = "auto";
}
