paypal
	.Buttons({
		style: {
			shape: "rect",
			color: "gold",
			layout: "vertical",
			label: "subscribe",
		},
		createSubscription: function (data, actions) {
			return actions.subscription.create({
				// Creates the subscription
				plan_id: planId,
			});
		},
		onApprove: function (data, actions) {
			window.document.body.style.pointerEvents = "none";
			storeSubscription(data.subscriptionID);
		},
		onError: function (data) {
			console.error(data);
		},
	})
	.render("#paypal-button-container"); // Renders the PayPal button

// store Subscription details
function storeSubscription(subID) {
	showPopup("Saving subscription data...");

	fetch(location.origin + "/vendor/paypal_13_storeSub.php", {
		method: "POST",
		body: JSON.stringify({
			sub_id: subID,
		}),
	})
		.then((response) => {
			return response.json();
		})
		.then((data) => {
			if (data.error) {
				throw new Error(data.error);
			} else if (data.success) {
				// console.log(data.success);
				storeTransaction(subID);
			} else {
				throw new Error("Something went wrong");
			}
		})
		.catch((error) => {
			showPopup(error);
			console.error("Error: ", error);
			window.location.replace(location.origin);
		});
}

// store transaction details

function storeTransaction(subID) {
	showPopup("Saving transaction data...");

	fetch(location.origin + "/vendor/paypal_14_storeTransaction.php", {
		method: "POST",
		body: JSON.stringify({
			sub_id: subID,
		}),
	})
		.then((response) => {
			return response.json();
		})
		.then((data) => {
			console.log(data);

			if (data.error) {
				throw new Error(data.error);
			} else if (data.success) {
				// console.log(data.success);
				redirectToSuccessPage(subID);
			} else {
				throw new Error("Something went wrong");
			}
		})
		.catch((error) => {
			showPopup(error);
			console.error("Error: ", error);
			// window.location.replace(location.origin);
		});
}

function redirectToSuccessPage(subID) {
	// Create a new form element
	let form = document.createElement("form");

	// Set the form attributes
	form.method = "POST";
	form.action = successURL; // Replace with the actual URL of your success page

	// Create a hidden input field for the sub_id parameter
	var input = document.createElement("input");
	input.type = "hidden";
	input.name = "sub_id";
	input.value = subID;

	// Append the input field to the form
	form.appendChild(input);

	// Append the form to the document body
	document.body.appendChild(form);

	// Submit the form
	form.submit();
}
