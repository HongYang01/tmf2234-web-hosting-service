const submitBtn = document.getElementById("submit");
const emailInput = document.getElementById("email");
const pwdInput = document.getElementById("password");

const err1 = document.getElementById("err-msg-1");
const err2 = document.getElementById("err-msg-2");

// Add an event listener to the submit button
// Submit post request to PHP
// PHP respond back to client JS
submitBtn.addEventListener("click", (event) => {
	event.preventDefault();

	// Check if email and password inputs are empty
	if (!emailInput.value.trim()) {
		err1.innerHTML = "Field cannot be empty";
		err1.style.display = "block";
		return;
	} else {
		err1.style.display = "none";
	}

	if (!pwdInput.value.trim()) {
		err2.innerHTML = "Field cannot be empty";
		err2.style.display = "block";
		return;
	} else {
		err2.style.display = "none";
	}

	const form = document.getElementById("form-component");
	const formData = new FormData(form);

	fetch(location.origin + "/handlers/login_handler.php", {
		method: "POST",
		body: formData,
	})
		.then((response) => response.json()) //get response from signup_handler.php
		.then((data) => {
			// check success attrib from object (boolean)
			if (data.success) {
				window.location.href = data.redirect; //get redirect attrib from object (URL string)
			} else {
				throw new Error(data.error);
			}
		})
		.catch((error) => {
			showPopup(error);
			console.error(error);
		});
});
