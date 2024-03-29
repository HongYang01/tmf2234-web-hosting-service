/*
########################################
||                                    ||
||     logout confirmation popup      ||
||                                    ||
########################################
 - using "dialog" html element to create logout confirmation
*/

const modal = document.querySelector("[data-modal]");
const logoutBtn = document.querySelector("[data-open-modal]");
const cancelBtn = document.querySelector("[data-close-modal]");
const confirmBtn = document.getElementById("confirm-btn");

logoutBtn.addEventListener("click", () => {
	modal.showModal();
});

confirmBtn.addEventListener("click", () => {
	fetch(location.origin + "/handlers/logout_handler.php", {
		method: "POST",
	})
		.then((response) => {
			if (response.ok) {
				window.location.href = "/index.php";
			} else {
				showPopup("Failed to logout");
			}
		})
		.catch((error) => console.error(error));
	modal.close();
});

cancelBtn.addEventListener("click", () => {
	modal.close();
});
