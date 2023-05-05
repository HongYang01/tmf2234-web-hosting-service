// Toogle Edit Button

const toggleBtn = document.getElementById("toggle-btn");
const inputs = document.querySelectorAll("input:not(#toggle-btn)");
const updateBtn = document.getElementById("update");

toggleBtn.addEventListener("change", function () {
	// Loop through each input element and toggle its read-only status
	inputs.forEach(function (input) {
		input.readOnly = !input.readOnly;
	});
});

inputs.forEach(function (input) {
	input.addEventListener("input", function () {
		updateBtn.style.display = "block";
	});
});
