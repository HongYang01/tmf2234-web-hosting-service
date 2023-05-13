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
||                            ||
||   Listen to page reload    ||
||                            ||
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
########################################
||                                    ||
||   Listen ADD new feature button    ||
||                                    ||
########################################
*/
addButton.addEventListener("click", function () {
	addFeature(undefined, undefined, undefined);
});

/*
################################
||                            ||
||    Listen Submit Button    ||
||                            ||
################################
*/

submitBtn.addEventListener("click", (event) => {
	event.preventDefault();

	showPopup("Loading...");

	if (formIsDirty) {
		const form = document.getElementById("edit-form");
		const formData = new FormData(form);
		formData.append("js_featureID", JSON.stringify(featureID));
		formData.append("js_removedFeature", JSON.stringify(removedFeature));

		fetch(location.origin + "/handlers/update_price_plan_handler.php", {
			method: "POST",
			body: formData,
		})
			.then((response) => response.json()) //get response from signup_handler.php
			.then((data) => {
				if (data.success) {
					showPopup(data.message);
					formIsDirty = false;
					location.reload();
				} else {
					showPopup(data.message);
					console.log(data.message);
				}
			})
			.catch((error) => {
				console.error(error);
				showPopup("An error occurred. Please try again.");
			});
	} else {
		showPopup("No changes made.");
	}
});

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

function addFeature(getID, getValue, getStatus) {
	updateCounter();

	// Create a new div container for the feature
	const container = document.createElement("div");
	container.id = "feature-wrap"; // Set the ID of the container
	if (getID !== undefined) {
		container.setAttribute("data-feature-id", getID);
		featureID.push(getID);
	}

	// Create a label element for the feature
	const label = document.createElement("label");
	label.setAttribute("for", `feature-${counter}`); // Set the "for" attribute of the label
	label.textContent = `Feature ${counter + 1}:`; // Set the text content of the label

	// Create an input element for the NEW feature
	const newTextbox = document.createElement("input");
	newTextbox.type = "text"; // Set the input type to text
	newTextbox.id = `feature-${counter}`; // Set the ID of the input
	newTextbox.autocomplete = "off";
	if (getValue === undefined) {
		newTextbox.name = "new-feature[]";
	} else {
		newTextbox.name = "feature[]";
		newTextbox.value = getValue;
	}

	// Create a selection element for the status
	const newSelection = document.createElement("select");
	newSelection.id = `feature-status-${counter}`;
	if (getStatus === undefined) {
		newSelection.name = `new-feature-status[]`;
	} else {
		newSelection.name = `feature-status[]`;
	}

	// Add options to the selection element
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

	// Create a button element to remove the feature
	const removeButton = document.createElement("button");
	removeButton.type = "button"; // Set the button type to button
	removeButton.id = `removeBtn-${counter}`; // Set the id of the button
	removeButton.textContent = "❌"; // Set the text content of the button

	// Event listener for the remove button click
	removeButton.addEventListener("click", function () {
		if (prevRemoveButton !== null && prevRemoveButton !== removeButton) {
			prevRemoveButton.textContent = "❌";
			removeBtnCounter = 0;
		}

		removeBtnCounter++; // plus one only after checking button
		removeButton.textContent = "⚠️";

		setTimeout(function () {
			//reset when user dont do anything
			removeButton.textContent = "❌"; //set display to none for loader
			removeBtnCounter = 0;
		}, 3000);

		if (removeBtnCounter === 2) {
			// Add the ID to the removedIds array
			removedFeature.push(container.getAttribute("data-feature-id"));

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

/*
#############################################
||                                         ||
||   Update Add feature & Submit button    ||
||                                         ||
#############################################
*/

function updateButtonState() {
	// Get all input elements with IDs starting with "feature-"
	const leftContainer = document.getElementsByClassName("left-container");
	const rightContainer = document.getElementsByClassName("right-container");
	const productTextbox = Array.from(leftContainer[0].querySelectorAll('input[id^="prod_"]'));
	const featureTextbox = Array.from(rightContainer[0].querySelectorAll('input[id^="feature-"]'));

	// Check if any input element has an empty value
	const isFeatureEmpty = featureTextbox.some((textbox) => textbox.value === "");
	const isProductEmpty = productTextbox.some((textbox) => textbox.value === "");

	// check if price is <= 0
	const priceIsZero = document.getElementById("prod_price").value <= 0;

	// Disable the add button if any input element is empty or any select element is unselected
	addButton.disabled = isFeatureEmpty || isProductEmpty || priceIsZero;
	submitBtn.disabled = isFeatureEmpty || isProductEmpty || priceIsZero;
}

/*
#############################################
||                                         ||
||         Update feature counter          ||
||                                         ||
#############################################
*/

/**
 * Update the feature counter (div element)
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

/*
################################
||                            ||
||       Delete Product       ||
||                            ||
################################
*/

const deleteBtn = document.getElementById("deleteBtn");
let deleteBtnCounter = 0;

deleteBtn.addEventListener("click", (event) => {
	event.preventDefault();

	setTimeout(function () {
		//reset when user dont do anything
		deleteBtn.textContent = "Delete Plan";
		deleteBtnCounter = 0;
	}, 3000);

	deleteBtnCounter++;
	deleteBtn.textContent = "⚠️ Confirm Delete Plan";

	if (deleteBtnCounter === 2) {
		showPopup("Loading...");

		const form = document.getElementById("edit-form");
		const formData = new FormData(form);

		fetch(location.origin + "/handlers/delete_price_plan_handler.php", {
			method: "POST",
			body: formData,
		})
			.then((response) => response.json()) //get response from signup_handler.php
			.then((data) => {
				if (data.success) {
					// delete successful
					window.location.href = data.redirect;
					formIsDirty = false;
				} else {
					// failed to delete
					showPopup(data.message);
					location.reload();
				}
			})
			.catch((error) => {
				console.error(error);
				showPopup("An error occurred. Please try again.");
			});

		deleteBtnCounter = 0;
	}
});
