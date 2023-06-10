/**
 *  Must online
 * 	Must include the script to DOM:
 *  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
 *  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment-timezone/0.5.33/moment-timezone-with-data-10-year-range.min.js"></script>
 *
 * @param {string} datetime
 * @returns
 */
window.myDateTimeFormat = function (datetime) {
	if (typeof datetime !== "string") {
		return null;
	}

	// Check if the device is online
	if (navigator.onLine) {
		let zone = moment.tz.guess();
		const formatted_datetime = moment.utc(datetime).tz(zone).format("DD MMM YYYY, HH:mm:ss");
		return formatted_datetime;
	} else {
		// Device is offline, return regular date without formatting
		return datetime;
	}
};
