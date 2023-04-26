//loader
window.addEventListener("load", function () {
	let test = document.getElementById("loader");

	test.style.opacity = "0"; //set opacity to 0

	setTimeout(function () {
		test.style.display = "none"; //set display to none
	}, 1000); //set time out to 1s (same with css)
});

//add shadow to nav bar when scrolling
window.addEventListener("scroll", function () {
	const myElement = document.getElementById("nav-bar");

	if (window.pageYOffset > 0) {
		myElement.style.boxShadow = "0 4px 10px rgba(0, 0, 0, 0.1)";
	} else {
		myElement.style.boxShadow = "none";
	}
});
