// Add event listeners to the buttons
//NOTE: not using "fetch()" because it need to be redirec to the cart page
const buyBtns = document.querySelectorAll("#addToCartBtn");

buyBtns.forEach(function (buyBtn) {
	buyBtn.addEventListener("click", function (event) {
		event.preventDefault();

		// Retrieve the value of data-product-id
		const productId = this.getAttribute("data-prod-id");

		// Create a form dynamically
		const form = document.createElement("form");
		form.method = "POST";
		form.action = "/pages/cart.php";

		// Create an input field for the product ID
		const input = document.createElement("input");
		input.type = "hidden";
		input.name = "prod_id";
		input.value = productId;

		// Append the input field to the form
		form.appendChild(input);

		// Append the form to the document body
		document.body.appendChild(form);

		// Submit the form
		form.submit();
	});
});
