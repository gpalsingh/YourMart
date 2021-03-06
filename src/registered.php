<html><head> <title>Register</title></head>
<body>
<?php
include_once "header.php"
?>
<script type="text/javascript" src="register.js"></script>
<div class="content">
<h1>Registeration Results</h1>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$person_data = array();
	$person_data["first_name"] = clean_data($_POST["first_name"]);
	$person_data["last_name"] = clean_data($_POST["last_name"]);
	$person_data["email"] = clean_data($_POST["email"]);
	$person_data["username"] = clean_data($_POST["username"]);
	$person_data["password"] = clean_data($_POST["password"]);
	$person_data["gender"] = (clean_data($_POST["gender"]) == "Male" ? 1 : 0);

	//Enter data into database
	$conn = getDbConnection();

	//Construct query
	$sql_generic = "INSERT INTO user_data (first_name, last_name, email, username,"
	     	     . "password, gender) VALUES ('%s', '%s', '%s', '%s', '%s', %d);";

	$sql = sprintf($sql_generic,
		$person_data["first_name"],
		$person_data["last_name"],
		$person_data["email"],
		$person_data["username"],
		$person_data["password"],
		$person_data["gender"]);
	
	//Insert the data
	$query_success = $conn->query($sql);

	if ($query_success === TRUE) {
		show_success_msg("New use created with following data:<br>");

		echo "<table><tr><th>Field</th><th>Value</th></tr>";
		foreach ($person_data as $field => $val) {
			echo "<tr><td>" . $field . "</td><td>" . $val . "</td></tr>";
		}
		echo "</table>";
	} else {
		//close the connection
		$conn->close();
		show_error_msg("Unable to create new user<br>");
		die(error_msg("Error: " . $conn->error));
	}

	//close the connection
	$conn->close();
}
?>

</div>
<?php
include_once "footer.php"
?>
</body></html>
