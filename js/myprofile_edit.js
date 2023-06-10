/*
################################
||                            ||
||          Function          ||
||                            ||
################################

- Save profile changes
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
