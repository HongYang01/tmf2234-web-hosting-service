// Toogle Edit Button

const toggleBtn = document.getElementById("toggle-btn");
const inputs = document.querySelectorAll("input:not(#toggle-btn)");
const tds = document.querySelectorAll(".editable");
const updateBtn = document.getElementById("update");

toggleBtn.addEventListener("change", function () {
	// Loop through each input element and toggle its read-only status
	inputs.forEach(function (input) {
		input.readOnly = !input.readOnly;
	});

	// Loop through each td element with class "editable" and toggle its contentEditable status
	// NOTE: contentEditable is not a boolean attribute
	tds.forEach(function (td) {
		if (td.contentEditable == "true") {
			td.contentEditable = "false";
		} else {
			td.contentEditable = "true";
		}
	});
});

//-----------------------------
//listen to edit on inputs
inputs.forEach(function (input) {
	input.addEventListener("input", function () {
		updateBtn.style.display = "block";
	});
});

//-----------------------------
//check if form is edited and not save changes yet
let formIsDirty = false;

// Add event listeners to form inputs (exclude toggle-btn)
const formInputs = document.querySelectorAll("input:not(#toggle-btn), select, textarea");
formInputs.forEach((input) => {
	input.addEventListener("input", () => {
		formIsDirty = true;
	});
});

// Add event listener to window
window.addEventListener("beforeunload", (event) => {
	if (formIsDirty) {
		event.preventDefault();
		event.returnValue = "";
	}
});

//-----------------------------
//AJAX
//inline editing
// const editableCells = document.querySelectorAll(".editable");

// editableCells.forEach((cell) => {
// 	cell.addEventListener("blur", () => {

// 		// Send AJAX request to update database
// 		const column = cell.getAttribute("data-column");
// 		const id = cell.getAttribute("data-id");
// 		const value = cell.innerText;
// 		const xhr = new XMLHttpRequest();

// 		xhr.open("POST", "update.php", true);
// 		xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
// 		xhr.onload = () => {
// 			if (xhr.status === 200) {
// 				console.log(xhr.responseText);
// 			}
// 		};
// 		xhr.send(`id=${id}&column=${column}&value=${value}`);
// 	});
// });
