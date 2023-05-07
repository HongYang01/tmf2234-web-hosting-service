//get current line number for error handling
function getCurrentLineNumber() {
	return new Error().stack;
}
