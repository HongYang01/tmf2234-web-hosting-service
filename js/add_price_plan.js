document.addEventListener("DOMContentLoaded", function () {
	addButton.dispatchEvent(new Event("click")); //simulate click
});

let counter = 0; // Counter to track the number of features
const addButton = document.getElementById("add-feature"); // Button to add new features
const submitBtn = document.getElementById("submitBtn"); // Button to add new features
const featureContainer = document.getElementById("feature-container"); // Container for feature elements

// Event listener for the add button click
addButton.addEventListener("click", function () {
	// Create a new div container for the feature
	const container = document.createElement("div");
	container.id = "feature-wrap"; // Set the ID of the container

	// Create a label element for the feature
	const label = document.createElement("label");
	label.setAttribute("for", `feature-${counter}`); // Set the "for" attribute of the label
	label.textContent = `Feature ${counter + 1}:`; // Set the text content of the label

	// Create an input element for the feature
	const newTextbox = document.createElement("input");
	newTextbox.type = "text"; // Set the input type to text
	newTextbox.name = "feature[]"; // Set the name attribute of the input
	newTextbox.id = `feature-${counter}`; // Set the ID of the input
	newTextbox.autocomplete = "off"; // Set the ID of the input

	// Create a selection element for the status
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

	// Create a button element to remove the feature
	const deleteButton = document.createElement("button");
	deleteButton.type = "button"; // Set the button type to button
	deleteButton.id = "removeBtn"; // Set the id of the button
	deleteButton.textContent = "Remove"; // Set the text content of the button

	// Event listener for the delete button click
	deleteButton.addEventListener("click", function () {
		featureContainer.removeChild(container); // Remove the feature container from the feature container
		updateAddButtonState(); // Update the state of the add button
		updateCounter(); // Update the counter and IDs of the features
	});

	// Render elements
	container.appendChild(label); // Append the label to the feature container
	container.appendChild(newTextbox); // Append the input to the feature container
	container.appendChild(newSelection); // Append the selection to the feature container
	container.appendChild(deleteButton); // Append the delete button to the feature container
	featureContainer.appendChild(container); // Append the feature container to the main container

	counter++; // Increment the counter for the next feature
	updateAddButtonState(); // Update the state of the add button
});

featureContainer.addEventListener("input", updateAddButtonState); // Event listener for input changes in the feature container

// Function to update the state of the add button
function updateAddButtonState() {
	// Get all input elements with IDs starting with "feature-"
	const textboxes = Array.from(featureContainer.querySelectorAll('input[id^="feature-"]'));

	// Check if any input element has an empty value
	const isEmpty = textboxes.some((textbox) => textbox.value === "");

	// Get all select elements with IDs starting with "feature-status-"
	const selections = Array.from(featureContainer.querySelectorAll('select[id^="feature-status-"]'));

	// Check if any select element is unselected
	const hasUnselected = selections.some((selection) => selection.value === "");

	// Disable the add button if any input element is empty or any select element is unselected
	addButton.disabled = isEmpty || hasUnselected;
	submitBtn.disabled = isEmpty || hasUnselected;
}

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
	});
}
