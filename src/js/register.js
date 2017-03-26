function getById(id) {
	return document.getElementById(id);
}

function getOrCreateErrorNode(id, parent_id) {
	var node = document.getElementById(id);
	if (node == null) {
		node = document.createTextNode("");
		node.id = id;
		insertBefore(node, getById(parent_id));
	}
	return node;
}

function getErrorField(id) {
	errors_field = getById(id.concat("-errors"));
	errors_field.innerHTML = "";
	return errors_field;
}

var validValues = {
	"person-name-first": false,
	"person-name-last": false,
	"person-email": false,
	"person-email-again": false,
	"person-username": false,
	"person-password": false,
	"agree-terms": false,
};

//TODO: Add more error checking
function checkFirstName() {
	id = "person-name-first";
	first_name = getById(id);
	first_name_errors = getErrorField(id);

	//Error checkup
	if (first_name.value.length < 3) {
		validValues[id] = false;
		first_name_errors.innerHTML += "First name must be at least 3 characters long.<br>";
	} else {
		validValues[id] = true;
		getById("person-name").innerHTML = first_name.value + ",";
	}

	//Cleanup
	if (!validValues[id]) {
		//Reset visibility
		first_name_errors.setAttribute("class", "form-errors");
	} else {
		//Remove all text
		first_name_errors.innerHTML = "";
		first_name_errors.class = "hidden";
	}
}

function checkLastName() {
	id = "person-name-last";
	last_name = getById(id);
	last_name_errors = getErrorField(id);

	//Error checkup
	if (last_name.value.length == 0) {
		validValues[id] = false;
		last_name_errors.innerHTML += "Last name cannot be empty.<br>";
	} else {
		validValues[id] = true;
	}

	//Cleanup
	if (!validValues[id]) {
		last_name_errors.setAttribute("class", "form-errors");
	} else {
		//Remove all text and hide element
		last_name_errors.innerHTML = "";
		last_name_errors.class = "hidden";
	}
}

function isValidEmail(str) {
	var re = /[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?/
	return re.test(str);
}

function checkEmailMatch() {
	id = "person-email-again";
	email_match = getById(id);
	email = getById("person-email");
	email_match_errors = getErrorField(id);

	if (email_match.value != email.value) {
		validValues[id] = false;
		email_match_errors.innerHTML += "Emails don't match.<br>";
	} else {
		validValues[id] = true;
	}

	if (!validValues[id]) {
		email_match_errors.setAttribute("class","form-errors");
	} else {
		//Remove all text and hide element
		email_match_errors.innerHTML = "";
		email_match_errors.setAttribute("class","hidden");
	}
}

function checkEmailValid() {
	id = "person-email";
	email = getById(id);
	email_errors = getErrorField(id);

	//Error checking
	if (email.value.length == 0) {
		validValues[id] = false;
		email_errors.innerHTML += "Email is required.<br>";
	} else if(!isValidEmail(email.value)) {
		validValues[id] = false;
		email_errors.innerHTML += "Email not valid.<br>";
	} else {
		validValues[id] = true;
		//Remove error matches from matching field
		if (getById("person-email-again").value.length > 0) {
			checkEmailMatch();
		}
	}

	//Cleanup
	if (!validValues[id]) {
		email_errors.setAttribute("class","form-errors");
	} else {
		//Remove all text and hide element
		email_errors.innerHTML = "";
		email_errors.setAttribute("class","hidden");
	}
}

function checkUsernameValid() {
	id = "person-username";
	uname = getById(id);
	uname_errors = getErrorField(id);

	if (uname.value.length < 8) {
		validValues[id] = false;
		uname_errors.innerHTML += "Username must have at least 8 characters at least.<br>";
	} else {
		validValues[id] = true;
	}

	//Cleanup
	if (!validValues[id]) {
		uname_errors.setAttribute("class","form-errors");
	} else {
		//Remove all text and hide element
		uname_errors.innerHTML = "";
		uname_errors.setAttribute("class","hidden");
	}
}

function checkPasswordValid() {
	id = "person-password";
	pass = getById(id);
	pass_errors = getErrorField(id);

	if (pass.value.length < 8) {
		validValues[id] = false;
		pass_errors.innerHTML += "Password length must be at least 8.<br>";
	} else {
		validValues[id] = true;
		//Remove error matches from matching field
		if (getById("person-password-again").value.length > 0) {
			checkPasswordMatch();
		}
	}

	if (!validValues[id]) {
		pass_errors.setAttribute("class", "form-errors");
	} else {
		//Remove all text and hide element
		pass_errors.innerHTML = "";
		pass_errors.setAttribute("class","hidden");
	}
}

function checkPasswordMatch() {
	id = "person-password-again";
	pass_match = getById(id);
	pass = getById("person-password");
	pass_match_errors = getErrorField(id);

	if (pass_match.value != pass.value) {
		validValues[id] = false;
		pass_match_errors.innerHTML += "Passwords don't match.<br>";
	} else {
		validValues[id] = true;
	}

	if (!validValues[id]) {
		pass_match_errors.setAttribute("class","form-errors");
	} else {
		//Remove all text and hide element
		pass_match_errors.innerHTML = "";
		pass_match_errors.setAttribute("class","hidden");
	}
}

function checkAgreeTerms() {
	id = "agree-terms";
	agree = getById(id);
	agree_errors = getErrorField(id);

	if (!(agree.checked)) {
		validValues[id] = false;
		agree_errors.innerHTML += "You must agree to the terms.<br>"
	} else {
		validValues[id] = true;
	}

	if (!validValues[id]) {
		agree_errors.setAttribute("class","form-errors");
	} else {
		//Remove all text and hide element
		agree_errors.innerHTML = "";
		agree_errors.setAttribute("class","hidden");
	}
}

$(document).ready(function() {
	$("#signup-form").submit(function checkFormValid(e) {
		//page doesn't load if default action prevented :/
		//e.preventDefault();
		checkFirstName();
		checkLastName();
		checkEmailValid();
		checkEmailMatch();
		checkUsernameValid();
		checkPasswordValid();
		checkPasswordMatch();
		checkAgreeTerms();
		for (var key in validValues) {
			if (!validValues[key]) {
				console.log(key);
				alert("Please fix the requested errors first.");
				return false;
			}
		}

		return true;
	});
});
