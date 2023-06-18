/*######################################*
||                                    ||
||     Run once after page loaded     ||
||                                    ||
*######################################*/

document.addEventListener("DOMContentLoaded", function () {
	addButton.dispatchEvent(new Event("click")); //simulate click
});

/*######################################*
||                                    ||
||  Dynamically Create Form Element   ||
||                                    ||
*######################################*/

let counter = 0; // Counter to track the number of features
const addButton = document.getElementById("add-feature"); // Button to add new features
const submitBtn = document.getElementById("submitBtn"); // Button to add new features
const featureContainer = document.getElementById("feature-container"); // Container for feature elements

// Event listener for the add button click
addButton.addEventListener("click", function () {
	/*######################################*
	||         Feature Container          ||
	*######################################*/
	const container = document.createElement("div");
	container.id = "feature-wrap"; // Set the ID of the container

	/*######################################*
	||           Feature Label            ||
	*######################################*/
	const label = document.createElement("label");
	label.setAttribute("for", `feature-${counter}`); // Set the "for" attribute of the label
	label.textContent = `Feature ${counter + 1}:`; // Set the text content of the label
	container.appendChild(label);

	/*######################################*
	||           Feature Input            ||
	*######################################*/
	const newTextbox = document.createElement("input");
	newTextbox.type = "text";
	newTextbox.name = "feature[]";
	newTextbox.id = `feature-${counter}`;
	newTextbox.autocomplete = "off";
	container.appendChild(newTextbox);

	/*######################################*
	||           Feature Status           ||
	*######################################*/
	const newSelection = document.createElement("select");
	newSelection.name = `feature-status[]`;
	newSelection.id = `feature-status-${counter}`;

	// Add options to the selection element
	const options = [
		{value: 1, label: "Include"},
		{value: 0, label: "Exclude"},
	];

	options.forEach(function (option) {
		const newOption = document.createElement("option");
		newOption.value = option.value;
		newOption.textContent = option.label;
		newSelection.appendChild(newOption);
	});

	container.appendChild(newSelection);

	/*######################################*
	||       Delete Feature Button        ||
	||          Delete Listener           ||
	*######################################*/
	const deleteButton = document.createElement("button");
	deleteButton.type = "button"; // Set the button type to button
	deleteButton.id = `removeBtn-${counter}`; // Set the id of the button
	deleteButton.textContent = "❌"; // Set the text content of the button
	container.appendChild(deleteButton);

	// Event listener for the delete button click
	deleteButton.addEventListener("click", function () {
		featureContainer.removeChild(container); // Remove the feature container from the feature container
		updateAddButtonState(); // Update the state of the add button
		updateCounter(); // Update the counter and IDs of the features
	});

	/*####################################################################*
	||        Append the feature container to the main container        ||
	*####################################################################*/
	featureContainer.appendChild(container); //

	/*######################################*
	||           Update Counter           ||
	*######################################*/
	counter++; // Increment the counter for the next feature
	updateAddButtonState(); // Update the state of the add button
});

/*######################################*
||                                    ||
||   Update ADD & SAVE button state   ||
||                                    ||
*######################################*/

document.addEventListener("input", updateAddButtonState); // Event listener for input changes in the feature container
document.addEventListener("select", updateAddButtonState); // Event listener for input changes in the feature container

function updateAddButtonState() {
	// check all input
	const inputs = Array.from(document.querySelectorAll("input"));
	const allInputEmpty = inputs.some((input) => input.value === "");

	// check feature inputs
	let isFeatureEmpty = true;
	const featureInputs = Array.from(featureContainer.querySelectorAll("input"));
	const noFeature = featureInputs.length === 0;
	if (noFeature) {
		addButton.disabled = false;
		submitBtn.disabled = true;
		return;
	} else {
		isFeatureEmpty = featureInputs.some((input) => input.value === "");
	}

	// check selection
	const selections = Array.from(document.querySelectorAll("select"));
	const hasUnselected = selections.some((selection) => selection.value === "");

	// Toggle Button ability
	addButton.disabled = isFeatureEmpty || hasUnselected;
	submitBtn.disabled = allInputEmpty || hasUnselected || noFeature;
}

/*
################################
||                            ||
||       Update counter       ||
||                            ||
################################
- to track the number of feature
*/

function updateCounter() {
	const featureWraps = Array.from(featureContainer.querySelectorAll("#feature-wrap"));
	counter = featureWraps.length; // Update the counter with the current number of features

	if (counter === 0) {
		submitBtn.disabled = true;
	}

	featureWraps.forEach(function (wrap, index) {
		const label = wrap.querySelector("label");
		label.setAttribute("for", "feature-" + index); // Update the "for" attribute of the label
		label.textContent = "Feature " + (index + 1) + ":"; // Update the label text

		const textbox = wrap.querySelector("input");
		textbox.id = "feature-" + index; // Update the input id

		const select = wrap.querySelector("select");
		select.id = "feature-status-" + index;
	});
}

/*#####################################*
||                                    ||
||           Submit Button            ||
||                                    ||
*######################################*

1. Request PayPal APIs for sub_id (paypal_4_createPlan.php)
2. Save data to database

*/
submitBtn.addEventListener("click", function (event) {
	event.preventDefault(); // Prevent the default form submission

	// Get the form data
	let formData = new FormData(document.getElementById("add-plan-form"));

	/*######################################*
	||  Request plan_id from PayPal API   ||
	*######################################*
	
	Variable:
	- prod_id
	- prod_name
	- plan_desc
	- plan_price
	- feature[]
	- feature-status[] (bool)
	
	*/

	showPopup("Requesting PayPal for new plan ID");

	fetch("/vendor/paypal_4_createPlan.php", {
		method: "POST",
		body: formData,
	})
		.then(function (response) {
			// Handle the response
			if (!response.ok) {
				throw new Error("Failed requesting Paypal APIs");
			}

			return response.json();
		})
		.then(function (data) {
			if ("error" in data) {
				throw new Error(data.error);
			}

			showPopup("New plan ID: " + data.id);

			setTimeout(function () {
				// change formData format (key-value pair -> JSON)

				showPopup("Success: Saving new plan to database...");

				saveNewPlanToDB(formData, data);
			}, 1500);
		})
		.catch(function (error) {
			showPopup(error);
			console.error(error);
		});
});

/*######################################*
||      Save details to database      ||
*######################################*/

function saveNewPlanToDB(form_planInfo, PayPal_planInfo) {
	// using append because the formData is a "key-value" format
	form_planInfo.append("plan_id", PayPal_planInfo.id); // new plan id
	form_planInfo.append("plan_status", PayPal_planInfo.status); // new plan status

	fetch(location.origin + "/handlers/admin_add_price_plan_handler.php", {
		method: "POST",
		body: form_planInfo,
	})
		.then(function (response) {
			// Handle the response
			if (!response.ok) {
				throw new Error("Failed to update new plan to database");
			}

			return response.json();
		})
		.then(function (data) {
			if (data.error) {
				throw new Error(data.error);
			} else if (data.success) {
				showPopup(data.message);
				setTimeout(function () {
					window.location.replace(location.origin + "/admin/manage_price_plan.php");
				}, 1500);
			}
			console.log(data);
		})
		.catch(function (error) {
			showPopup(error);
			console.error(error);
		});
}
