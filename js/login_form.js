const submitBtn = document.getElementById("submit");

// Add an event listener to the submit button
// Submit post request to PHP
// PHP respond back to client JS
submitBtn.addEventListener("click", (event) => {
	event.preventDefault();

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
				showPopup(data.error); //get error attrib from object (string)
			}
		})
		.catch((error) => {
			showPopup("Error: " + error.message);
			console.error("Error:", error);
		});
});
