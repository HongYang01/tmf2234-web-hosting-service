//loader
window.addEventListener("load", function () {
	let test = document.getElementById("loader");

	test.style.opacity = "0"; //set opacity to 0

	setTimeout(function () {
		test.style.display = "none"; //set display to none
	}, 1000); //set time out to 1s (same with css)
});
