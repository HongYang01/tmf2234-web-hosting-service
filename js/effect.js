//loader
let oriURL;

window.addEventListener("load", function () {
	const loader = document.getElementById("loader");

	oriURL = document.getElementById("logo").href; //get ori home URL

	setTimeout(function () {
		loader.style.display = "none"; //set display to none for loader
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
		nav_bar.style.boxShadow = "0px 0px 10px 3px #00000022";
		logo.href = "#";
	} else {
		nav_bar.style.boxShadow = "none";
		logo.href = oriURL;
	}
});

//hide the post query in the URL
function saveChanges(form) {
	let xhr = new XMLHttpRequest();
	xhr.open("POST", form.action);
	xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xhr.onload = function () {
		if (xhr.status === 200) {
			// handle successful response
			console.log(xhr.responseText);
		} else {
			// handle error
			console.error(xhr.statusText);
		}
	};
	xhr.send(new FormData(form));
}

// popup and fade message
// to-use: <div id="popup-fade-msg"></div>
// accept one string parameter only
let timeoutId; // declare timeoutId as a global variable

window.showPopup = function (msg) {
	let popup = document.getElementById("popup-fade-msg");

	popup.innerHTML = msg;
	popup.style.display = "block";

	clearTimeout(timeoutId); // clear the previous timeout, if any

	timeoutId = setTimeout(function () {
		popup.style.opacity = "0";
		setTimeout(function () {
			popup.style.display = "none";
			popup.style.opacity = "1";
		}, 3600);
	}, 3600);

	// add mouseover event listener to stop the popup from fading away
	popup.addEventListener("mouseover", function () {
		clearTimeout(timeoutId);
	});

	popup.addEventListener("mouseout", function () {
		// only set timeout if mouse is not over the element
		timeoutId = setTimeout(function () {
			popup.style.opacity = "0";
			setTimeout(function () {
				popup.style.display = "none";
				popup.style.opacity = "1";
			}, 3600);
		}, 3600);
	});

	// add event listener to reset flag when mouse leaves element
};
