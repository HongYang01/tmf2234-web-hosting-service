const inputs = document.querySelectorAll('input:not([type="submit"]):not([type="email"])');
const submitBtn = document.getElementById("submit");
const pwd = document.getElementById("password");
const c_pwd = document.getElementById("confirm_password");

// error message span tag
const err1 = document.getElementById("err-msg-1");
const err2 = document.getElementById("err-msg-2");
const err3 = document.getElementById("err-msg-3");

// flag
let err_found = false;

//Event listener for input tags (exclude id: submit & email)
inputs.forEach(function (input) {
	input.addEventListener("input", function () {
		if (this.name === "password") {
			if (this.value.length < 8) {
				err2.innerHTML = "Password must be at least 8 characters";
				err2.style.display = "block";
				err_found = true;
			} else {
				err2.style.display = "none";
				err_found = false;
			}
		}

		//check if password matched
		if (c_pwd.value !== "" && c_pwd.value !== pwd.value) {
			err3.innerHTML = "Password does not match";
			err3.style.display = "block";
			err_found = true;
		} else {
			err3.style.display = "none";
			err_found = false;
		}

		//toggle submit button ability
		if (err_found) {
			submitBtn.disabled = true;
		} else {
			submitBtn.disabled = false;
		}
	});
});

// Check email validity using regex (exclude "semicolonix")
// Toggle err1
// set err_found
// disable the submit button if found error
function checkEmailValidity(email) {
	const regex = /^[^\s@]+@(?!.*semicolonix)[^\s@]+\.[^\s@]+$/;

	if (regex.test(email)) {
		err1.style.display = "none";
		err_found = false;
	} else {
		err1.innerHTML = "Invalid email";
		err1.style.display = "block";
		err_found = true;
	}

	if (err_found) {
		submitBtn.disabled = true;
	} else {
		submitBtn.disabled = false;
	}
}

// Add an event listener to the submit button
// Submit post request to PHP
// PHP respond back to client JS
submitBtn.addEventListener("click", (event) => {
	event.preventDefault();

	const form = document.getElementById("form-component");
	const formData = new FormData(form);

	fetch(location.origin + "/handlers/signup_handler.php", {
		method: "POST",
		body: formData,
	})
		.then((response) => response.json()) //get response from signup_handler.php
		.then((data) => {
			// check success attrib from object (boolean)
			if (data.success) {
				window.location.href = data.redirect; //get redirect attrib from object (URL string)
			} else {
				showPopup(data.error); //get error attrib from object (string)
			}
		})
		.catch((error) => {
			showPopup("Error: " + error.message);
			console.error("Error:", error);
		});
});
