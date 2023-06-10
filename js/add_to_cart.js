document.addEventListener("DOMContentLoaded", function () {
	addToCart();
});

function addToCart() {
	const buyBtns = document.querySelectorAll("#addToCartBtn");

	buyBtns.forEach(function (btn) {
		btn.addEventListener("click", function (event) {
			event.preventDefault();

			// Retrieve the value of data-plan-id
			const planId = this.getAttribute("data-plan-id");

			fetch(
				location.origin +
					"/handlers/get_plan_details.php" +
					"?plan_id=" +
					encodeURIComponent(planId)
			)
				.then(function (response) {
					return response.json();
				})
				.then(async (data) => {
					if (data.error) {
						throw new Error(data.error);
					} else {
						if (await planClashed(data)) {
							// plan clashes
							return;
						}
						redirectToCart(data); //send the planInfo to edit
					}
				})
				.catch((error) => {
					showPopup(error);
					console.error(error);
				});
		});
	});
}

function redirectToCart(planInfo) {
	// Create a form dynamically
	const form = document.createElement("form");
	form.method = "POST";
	form.action = location.origin + "/vendor/paypal_5_cart.php";

	// Create a hidden input field for the JSON data
	const dataInput = document.createElement("input");
	dataInput.type = "hidden";
	dataInput.name = "planInfo";
	dataInput.value = JSON.stringify(planInfo);
	form.appendChild(dataInput);

	// Append the form to the document body and submit it
	document.body.appendChild(form);
	form.submit();
}

function planClashed(planInfo) {
	return fetch(location.origin + "/handlers/check_plan_clashed.php", {
		method: "POST",
		body: JSON.stringify({plan_id: planInfo.plan_id}),
	})
		.then(function (response) {
			if (!response.ok) {
				throw new Error("Failed to check plan");
			}
			return response.json();
		})
		.then((data) => {
			if (data.error) {
				throw new Error(data.error);
			} else if (data.success) {
				showPopup("Redirecting you to checkout");
				return false;
			} else {
				return true;
			}
		})
		.catch((error) => {
			showPopup(error);
			return true;
		});
}
