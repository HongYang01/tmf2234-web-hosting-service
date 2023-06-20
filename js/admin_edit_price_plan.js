/*
################################
||                            ||
||    Check if form Dirty     ||
||                            ||
################################
*/

let formIsDirty = false;

function checkDirty() {
	const formInputs = document.querySelectorAll("input, select, textarea");
	formInputs.forEach((input) => {
		input.addEventListener("input", () => {
			updateButtonState();
			formIsDirty = true;
		});
	});
}

/*
################################
||   Listen to page reload    ||
################################
*/

window.addEventListener("beforeunload", (event) => {
	if (formIsDirty) {
		event.preventDefault();
		event.returnValue = "";
	}
});

/*
########################################
||                                    ||
||   Create form element (feature)    ||
||                                    ||
########################################
*/

let counter = 0; // Counter to track the number of features
const addButton = document.getElementById("add-feature"); // Button to add new features
const featureContainer = document.getElementById("feature-container"); // Container for feature elements
let removeBtnCounter = 0;
let prevRemoveButton = null;

const submitBtn = document.getElementById("submitBtn");
const featureID = []; // to collect all feature IDs
const removedFeature = []; // to collect all REMOVED feature IDs

/*


/*
################################
||                            ||
||    Add NEW feature line    ||
||                            ||
################################
*/

/**
 * Add a new feature line to the form.
 * @param {string} getID - The ID of the feature (optional).
 * @param {string} getValue - The value of the feature textbox (optional).
 * @param {string} getStatus - The status of the feature (optional).
 */

function addFeature(getID = null, getValue = null, getStatus = null) {
	updateCounter();
	const container = createFeatureContainer(getID);
	const label = createFeatureLabel();
	const newTextbox = createFeatureTextbox(getValue);
	const newSelection = createFeatureSelection(getStatus);
	const removeButton = createRemoveButton();
	attachRemoveButtonListener(removeButton, container);

	// Render elements
	container.appendChild(label);
	container.appendChild(newTextbox);
	container.appendChild(newSelection);
	container.appendChild(removeButton);
	featureContainer.appendChild(container);

	counter++; // Increment the counter for the next feature
	updateButtonState(); // Update the state of the add button
	checkDirty(); // reset the form listener
}

function createFeatureContainer(getID) {
	const container = document.createElement("div");
	container.id = "feature-wrap"; // Set the ID of the container
	if (getID !== null) {
		container.setAttribute("data-feature-id", getID);
		featureID.push(getID);
	}
	return container;
}

function createFeatureLabel() {
	const label = document.createElement("label");
	label.setAttribute("for", `feature-${counter}`); // Set the "for" attribute of the label
	label.textContent = `Feature ${counter + 1}:`; // Set the text content of the label
	return label;
}

function createFeatureTextbox(getValue) {
	const newTextbox = document.createElement("input");
	newTextbox.type = "text"; // Set the input type to text
	newTextbox.id = `feature-${counter}`; // Set the ID of the input
	newTextbox.autocomplete = "off";
	if (getValue === null) {
		newTextbox.name = "new-feature[]";
	} else {
		newTextbox.name = "feature[]";
		newTextbox.value = getValue;
	}
	return newTextbox;
}

function createFeatureSelection(getStatus) {
	const newSelection = document.createElement("select");
	newSelection.id = `feature-status-${counter}`;
	if (getStatus === null) {
		newSelection.name = `new-feature-status[]`;
	} else {
		newSelection.name = `feature-status[]`;
	}
	const options = [
		{value: 1, label: "Include"},
		{value: 0, label: "Exclude"},
	];
	options.forEach(function (option) {
		const newOption = document.createElement("option");
		newOption.value = option.value;
		newOption.textContent = option.label;
		if (getStatus == option.value) {
			newOption.selected = true;
		}
		newSelection.appendChild(newOption);
	});
	return newSelection;
}

function createRemoveButton() {
	const removeButton = document.createElement("button");
	removeButton.type = "button"; // Set the button type to button
	removeButton.id = `removeBtn-${counter}`; // Set the id of the button
	removeButton.textContent = "❌"; // Set the text content of the button
	return removeButton;
}

function attachRemoveButtonListener(removeButton, container) {
	let removeBtnCounter = 0;
	let prevRemoveButton = null;

	removeButton.addEventListener("click", function () {
		if (prevRemoveButton !== null && prevRemoveButton !== removeButton) {
			prevRemoveButton.textContent = "❌";
			removeBtnCounter = 0;
		}

		removeBtnCounter++; // plus one only after checking button

		// Countdown
		let countdown = 3; // Set the initial countdown value
		removeButton.textContent = countdown;
		let countdownInterval = setInterval(function () {
			countdown--;
			if (countdown > 0) {
				removeButton.textContent = countdown;
			} else {
				clearInterval(countdownInterval); // Stop the countdown when it reaches 0
				removeBtnCounter = 0;
				removeButton.textContent = "❌";
			}
		}, 1000);

		// Confirm remove
		if (removeBtnCounter === 2) {
			// Add the ID to the removedIds array (if not null)
			const removedID = container.getAttribute("data-feature-id");
			if (removedID !== null) {
				removedFeature.push(removedID);
			}

			// Remove the div from the DOM
			featureContainer.removeChild(container); // Remove the feature container
			updateButtonState(); // Update the state of the add button
			updateCounter(); // Update the counter and IDs of the features

			// Reset the click count for the next two clicks
			removeBtnCounter = 0;
			prevRemoveButton = null;
			formIsDirty = true;
		}

		prevRemoveButton = removeButton;
	});
}

/*
#############################################
||         Update feature counter          ||
#############################################
*/

function updateCounter() {
	const featureWraps = Array.from(featureContainer.querySelectorAll("#feature-wrap"));
	counter = featureWraps.length; // Update the counter with the current number of inputs

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

		const button = wrap.querySelector("button");
		button.id = "removeBtn-" + index;
	});
}

/*#############################*
||                            ||
||    Listen Submit Button    ||
||                            ||
*##############################*

1. request PayPal update plan (return HTTP 204)
2. request PayPal update pricing (return HTTP 204)
3. save changes to DB (plan & plan details)

*/
let submitCounter = 0;
submitBtn.addEventListener("click", (event) => {
	event.preventDefault();

	if (!formIsDirty) {
		showPopup("No changes yet.");
		return;
	}

	submitCounter++;
	submitBtn.textContent = "⚠️ Confirm Save Changes";

	setTimeout(function () {
		//reset when user dont do anything
		submitBtn.textContent = "Save Changes";
		submitCounter = 0;
	}, 3000);

	if (submitCounter == 2) {
		showPopup("Loading...");
		document.body.style.pointerEvents = "none";

		(async () => {
			try {
				const form = document.getElementById("edit-form");
				const formData = new FormData(form);
				formData.append("js_featureID", featureID); // previous/new feature
				formData.append("js_removedFeatureID", removedFeature); // deleted feature

				const result1 = await paypalUpdatePlan(formData);
				if (result1 === null) {
					throw new Error("PayPal Error: Failed to update plan");
				}

				const result2 = await paypalUpdatePricing(formData);
				if (result2 === null) {
					throw new Error("PayPal Error: Failed to update plan pricing");
				}

				const result3 = updatePlanToDB(formData);
				if (result3 === null) {
					throw new Error("Failed to update to database, but updated in PayPal");
				}
			} catch (error) {
				showPopup(error);
				console.error(error);
				document.body.style.pointerEvents = "auto";
			}
		})().catch((error) => console.error(error));
	}
});

/**
 *
 * @param {keyValue} formData
 * @returns {null|HTTP} null | HTTP code 204
 */
function paypalUpdatePlan(formData) {
	return fetch(location.origin + "/vendor/paypal_6_updatePlan.php", {
		method: "POST",
		body: formData,
	})
		.then(function (response) {
			if (!response.ok) {
				throw new Error("Failed to save changes");
			}
			return response.json();
		})
		.then(function (data) {
			if (data.error) {
				throw new Error(data.error);
			} else if (data.HTTP) {
				return data.HTTP; // return HTTP code 204 (success)
			}
			return null;
		})
		.catch(function (error) {
			showPopup(error);
			console.error(error);
			return null;
		});
}

/**
 *
 * @param {keyValue} formData
 * @returns {null|HTTP} null | HTTP code 204
 */
function paypalUpdatePricing(formData) {
	return fetch(location.origin + "/vendor/paypal_7_updatePricing.php", {
		method: "POST",
		body: formData,
	})
		.then(function (response) {
			if (!response.ok) {
				throw new Error("PayPal Error: Failed to update pricing");
			}
			return response.json();
		})
		.then(function (data) {
			if (data.error) {
				throw new Error(data.error);
			} else if (data.HTTP) {
				return data.HTTP; // return HTTP code 204 (success)
			}
			return null;
		})
		.catch(function (error) {
			showPopup(error);
			console.error(error);
			return null;
		});
}

/**
 *
 * @param {keyValue} formData
 * @returns {null|string} null | success message
 */
function updatePlanToDB(formData) {
	return fetch(location.origin + "/handlers/admin_edit_price_plan_handler.php", {
		method: "POST",
		body: formData,
	})
		.then(function (response) {
			if (!response.ok) {
				throw new Error("Failed to update to database");
			}
			return response.json();
		})
		.then(function (data) {
			if (data.error) {
				throw new Error(data.error);
			} else {
				showPopup(data.success);

				formIsDirty = false; // so can reload successfully

				setTimeout(function () {
					location.reload();
				}, 1500);
			}
			return data;
		})
		.catch(function (error) {
			showPopup(error);
			console.error(error);
			return null;
		});
}

/*######################################*
||                                    ||
||          Deactivate Plan           ||
||                                    ||
*######################################*/

const deactivateBtn = document.getElementById("deactivateBtn");
let deleteBtnCounter = 0;

deactivateBtn.addEventListener("click", (event) => {
	event.preventDefault();

	deleteBtnCounter++;

	//TODO: do a popup message to confirm action

	// Countdown
	let countdown = 3; // Set the initial countdown value
	deactivateBtn.textContent = "⚠️ Confirm Deactivate Plan ? " + countdown + "s";
	let countdownInterval = setInterval(function () {
		countdown--;
		if (countdown > 0) {
			deactivateBtn.textContent = "⚠️ Confirm Deactivate Plan ? " + countdown + "s";
		} else {
			clearInterval(countdownInterval);
			deleteBtnCounter = 0;
			deactivateBtn.textContent = "Deactivate Plan";
		}
	}, 1000);

	if (deleteBtnCounter === 2) {
		clearInterval(countdownInterval);
		deleteBtnCounter = 0;
		deactivateBtn.textContent = "Deactivate Plan";

		const modal = document.querySelector("[data-modal]");
		const cancelBtn = document.querySelector("[data-close-modal]");
		const confirmBtn = document.getElementById("confirm-btn");

		modal.showModal(); // popup confirmation

		// deactivating
		confirmBtn.addEventListener("click", () => {
			showPopup("Loading...");

			const form = document.getElementById("edit-form");
			const formData = new FormData(form);
			deactivatePlan(formData.get("plan_id"));

			modal.close();
		});

		cancelBtn.addEventListener("click", () => {
			modal.close();
		});
	}
});

/**
 * @param {string} plan_id
 */
function deactivatePlan(plan_id) {
	// new status will also be updated in database
	// not need to return because redirected

	document.body.style.pointerEvents = "none";

	showPopup("Requesting PayPal API...");

	fetch(location.origin + "/vendor/paypal_9_deactivatePlan.php", {
		method: "POST",
		body: JSON.stringify({plan_id: plan_id}),
	})
		.then(function (response) {
			return response.json();
		})
		.then((data) => {
			if (data.error) {
				throw new Error(data.error);
			} else if (data.success) {
				showPopup(data.success);
				setTimeout(() => {
					window.location.href = location.origin + "/admin/manage_price_plan.php";
				}, 1500);
			}
		})
		.catch((error) => {
			showPopup(error);
			console.error(error);
		});
	document.body.style.pointerEvents = "auto";
}

/*######################################*
||                                    ||
||        Update Buttons State        ||
||                                    ||
*######################################*

- Add Feature Button
- Save Changes Button

*/

function updateButtonState() {
	// Get all input elements with IDs starting with "feature-"
	const leftContainer = document.getElementsByClassName("left-container");
	const rightContainer = document.getElementsByClassName("right-container");
	const productTextbox = Array.from(leftContainer[0].querySelectorAll('input[id^="prod_"]'));
	const featureTextbox = Array.from(rightContainer[0].querySelectorAll('input[id^="feature-"]'));

	// Check if any input element has an empty value
	const isFeatureEmpty = featureTextbox.some((textbox) => textbox.value === "");
	const isPlanEmpty = productTextbox.some((textbox) => textbox.value === "");

	// check if price is <= 0
	const priceIsZero = document.getElementById("plan_price").value <= 0;

	// Disable the add button if any input element is empty or any select element is unselected
	addButton.disabled = isFeatureEmpty || isPlanEmpty || priceIsZero;
	submitBtn.disabled = isFeatureEmpty || isPlanEmpty || priceIsZero;
}
