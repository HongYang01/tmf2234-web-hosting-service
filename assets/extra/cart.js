// For one-time palpal payment

const checkoutBtn = document.getElementById("checkoutBtn");

checkoutBtn.addEventListener("click", function (event) {
	event.preventDefault();

	// Retrieve the value of data-plan-id
	const planId = this.getAttribute("data-plan-id");

	// Send the value to cart.php using fetch
	fetch(location.origin + "/vendor/paypal_2_request.php", {
		method: "POST",
		headers: {
			"Content-Type": "application/json",
		},
		body: JSON.stringify({plan_id: planId}),
	})
		.then(function (response) {
			// Handle the response from paypal-redirect.php
			return response.json();
		})
		.then(function (data) {
			if (data.success) {
				// Perform the redirection using the approval link
				// only can redirect from here, cannot use header() in the paypal_2_request.php due to CORS
				// CORS only recognize the payload file name (meaning from where its origin)
				window.location.href = data.approvalLink;
			} else {
				if ("redirect" in data) {
					window.location.href = data.redirect;
				} else {
					alert(data.message);
				}
			}
		})
		.catch(function (error) {
			// Handle any errors that occur during the fetch request
			console.error(error);
		});
});
