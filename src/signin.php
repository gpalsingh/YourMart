<html><head><title>Register</title></head>
<body>
<?php
include_once "header.php"
?>
<div class="content">
<h1>Sign-in to YourMart</h1>
<?php
start_new_session();

function isValidUser($uname, $pass) {
	$conn = getDbConnection();
	$query_base = "SELECT * FROM user_data WHERE username='%s' AND password='%s';";
	$query_string = sprintf($query_base, $uname, $pass);
	$sql = $conn->query($query_string);
	$affected_rows = $conn->affected_rows;
	$conn->close();
	if ($affected_rows < 1) {
		show_error_msg("Username and/or Password is wrong.<br>");
		return false;
	}
	return true;
}
	
if (isset($_POST['login_button']) && !empty($_POST['username']) && !empty($_POST['password'])) {
	$username = $_POST['username'];
	$pass = $_POST['password'];
	if (isValidUser($username, $pass)) {
		$_SESSION['valid'] = true;
		$_SESSION['username'] = $username;
	} else {
		$_SESSION['valid'] = false;
		show_error_msg("Failed to log you in.<br>");
	}
}
$show_form = !(($_SERVER['REQUEST_METHOD'] === 'POST') && $_SESSION['valid']);
if ($show_form) { ?>
<form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
Username: <input type=text name="username" placeholder="Your username" required autofocus>
<br>
Password: <input type=password name="password" placeholder="Your password" required>
<br>
<button type="submit" name="login_button">Login</button>
</div>
<form>
<?php } else show_success_msg("Welcome, $username.");
include_once "footer.php"
?>
</body></html>
