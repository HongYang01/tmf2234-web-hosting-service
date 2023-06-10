const inputs = document.querySelectorAll('input:not([type="submit"]):not([type="email"])');
const submitBtn = document.getElementById("submit");

const fname = document.getElementById("fname");
const lname = document.getElementById("lname");
const email = document.getElementById("email");
const pwd = document.getElementById("password");
const c_pwd = document.getElementById("confirm_password");

// error message span tag
const err1 = document.getElementById("err-msg-1");
const err2 = document.getElementById("err-msg-2");
const err3 = document.getElementById("err-msg-3");
const err4 = document.getElementById("err-msg-4");
const err5 = document.getElementById("err-msg-5");

submitBtn.addEventListener("click", (event) => {
	event.preventDefault();

	resetErr();

	if (checkNameValidity() && checkEmailValidity() && checkPasswordValididy()) {
		const form = document.getElementById("form-component");
		const formData = new FormData(form);

		fetch(location.origin + "/handlers/signup_handler.php", {
			method: "POST",
			body: formData,
		})
			.then((response) => response.json())
			.then((data) => {
				if (data.success) {
					window.location.href = data.redirect;
				} else {
					throw new Error(data.error);
				}
			})
			.catch((error) => {
				showPopup(error);
				console.error(error);
			});
	}
});

function resetErr() {
	err1.style.display = "none";
	err2.style.display = "none";
	err3.style.display = "none";
	err4.style.display = "none";
	err5.style.display = "none";
}

function checkNameValidity() {
	if (!fname.value.trim()) {
		err1.innerHTML = "Field cannot be empty";
		err1.style.display = "block";
		return false;
	} else {
		err1.style.display = "none";
	}

	if (!lname.value.trim()) {
		err2.innerHTML = "Field cannot be empty";
		err2.style.display = "block";
		return false;
	} else {
		err2.style.display = "none";
	}

	return true;
}

function checkPasswordValididy() {
	if (!pwd.value.trim()) {
		err4.innerHTML = "Field cannot be empty";
		err4.style.display = "block";
		return false;
	} else {
		err4.style.display = "none";
		if (pwd.value.length < 8) {
			err4.innerHTML = "Password must be at least 8 characters";
			err4.style.display = "block";
			return false;
		} else {
			err4.style.display = "none";
		}
	}

	if (!c_pwd.value.trim()) {
		err5.innerHTML = "Field cannot be empty";
		err5.style.display = "block";
		return false;
	} else {
		err5.style.display = "none";
		if (c_pwd.value !== pwd.value) {
			err5.innerHTML = "Password does not match";
			err5.style.display = "block";
			return false;
		} else {
			err5.style.display = "none";
		}
	}

	return true;
}

function checkEmailValidity() {
	const regex = /^[^\s@]+@(?!.*semicolonix)[^\s@]+\.[^\s@]+$/;

	if (!email.value.trim()) {
		err3.innerHTML = "Field cannot be empty";
		err3.style.display = "block";
		return false;
	} else {
		err3.style.display = "none";
	}

	if (regex.test(email.value)) {
		err3.style.display = "none";
	} else {
		err3.innerHTML = "Invalid email";
		err3.style.display = "block";
		return false;
	}

	return true;
}
