/*
################################
||        Loader Popup        ||
################################
*/

window.addEventListener("load", function () {
	showLoadingScreen();
});

let oriURL; //temp variable to store original URL (to be toggled)
window.showLoadingScreen = function () {
	const loader = document.getElementById("loader");
	// Disable scroll behavior
	document.body.style.overflow = "hidden";

	oriURL = document.getElementById("logo").href; //get ori home URL

	setTimeout(function () {
		loader.style.display = "none"; //set display to none for loader
		// Enable scroll behavior
		document.body.style.overflow = "auto";
	}, 1000); //set time out to 1s (same with css)

	//modify href of dropdown menu
	if (window.location.pathname == "/pages/shared_hosting_pricing.php") {
		document.getElementById("link-sh").href = "#";
	} else if (window.location.pathname == "/pages/vps_hosting_pricing.php") {
		document.getElementById("link-vps").href = "#";
	} else if (window.location.pathname == "/pages/dedicated_hosting_pricing.php") {
		document.getElementById("link-dc").href = "#";
	}
};

/*
################################
||      Scroll Listener       ||
################################
- add shadow to nav bar when scrolling
- change the href to # or oriURL
*/
window.addEventListener("scroll", function () {
	const nav_bar = document.getElementById("nav-bar");
	const logo = document.getElementById("logo");

	if (window.scrollY > 0) {
		nav_bar.style.boxShadow = "0px 0px 10px 3px #00000022";
		logo.href = "#";
	} else {
		nav_bar.style.boxShadow = "none";
		logo.href = oriURL;
	}
});

/*
Popup and fade message (top)
to-use: <div id="popup-fade-msg"></div>
*/
let timeoutId; // declare timeoutId as a global variable

window.showPopup = function (msg) {
	const popup = document.getElementById("popup-fade-msg");
	popup.innerHTML = msg;
	popup.style.display = "block";
	popup.style.opacity = "1";

	const duration = 3600; // total duration for fading (in milliseconds)
	const interval = 10; // interval for updating opacity (in milliseconds)
	const delta = 1 / (duration / interval); // change in opacity per interval

	clearTimeout(timeoutId); // clear the previous timeout

	const fadeOut = function () {
		let opacity = parseFloat(popup.style.opacity) || 1;
		opacity -= delta;
		popup.style.opacity = opacity;

		if (opacity > 0) {
			timeoutId = setTimeout(fadeOut, interval);
		} else {
			popup.style.display = "none";
			popup.style.opacity = "1";
		}
	};

	timeoutId = setTimeout(fadeOut, interval);

	// add mouseover event listener to stop the popup from fading away
	popup.addEventListener("mouseover", function () {
		clearTimeout(timeoutId);
		popup.style.opacity = "1";
	});

	//continue to fade
	popup.addEventListener("mouseout", function () {
		if (parseFloat(popup.style.opacity) > 0) {
			timeoutId = setTimeout(fadeOut, interval);
		}
	});
};
