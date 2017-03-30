function getById(id) {
	return document.getElementById(id);
}


function getErrorField(id) {
	errors_field = getById(id.concat("-errors"));
	errors_field.innerHTML = "";
	return errors_field;
}

function updateErrorField(id, validValues, errorField) {
	//Cleanup
	if (!validValues[id]) {
		//Reset visibility
		errorField.setAttribute("class", "form-errors");
	} else {
		//Remove all text
		errorField.innerHTML = "";
		errorField.class = "hidden";
	}
}
