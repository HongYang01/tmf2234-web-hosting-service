//loader
window.addEventListener("load", function () {
	let test = document.getElementById("loader");

	setTimeout(function () {
		test.style.display = "none"; //set display to none
	}, 1000); //set time out to 1s (same with css)

	//modify href of dropdown menu
	if (window.location.pathname == "/pages/shared_hosting_pricing.php") {
		document.getElementById("link-sh").href = "#";
	} else if (window.location.pathname == "/pages/vps_hosting_pricing.php") {
		document.getElementById("link-vps").href = "#";
	} else if (window.location.pathname == "/pages/dedicated_hosting_pricing.php") {
		document.getElementById("link-dc").href = "#";
	}
});

//add shadow to nav bar when scrolling
window.addEventListener("scroll", function () {
	const nav_bar = document.getElementById("nav-bar");
	const logo = document.getElementById("logo");

	if (window.scrollY > 0) {
		nav_bar.style.boxShadow = "0 4px 10px rgba(0, 0, 0, 0.1)";
		logo.href = "#";
	} else {
		nav_bar.style.boxShadow = "none";
		logo.href = "/index.php";
	}
});
