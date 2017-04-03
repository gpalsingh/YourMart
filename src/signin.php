<html><head><title>Register</title></head>
<body>
<?php
include_once "common.php";
$errors_list = Array();
start_new_session();

function isValidUser($uname, $pass) {
	global $errors_list;
	$conn = getDbConnection();
	if (!$conn) {
		array_push($errors_list, "Cannot connect to database :(");
		$conn->close();
		return false;
	}
	$query_base = "SELECT * FROM user_data WHERE username='%s' AND password='%s';";
	$query_string = sprintf($query_base, $uname, $pass);
	$sql = $conn->query($query_string);
	echo $conn->connect_error;
	if (($conn->affected_rows) < 1) {
		array_push($errors_list, "Username and/or Password is wrong.");
		$conn->close();
		return false;
	}
	$conn->close();
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
		array_push($errors_list, "Failed to log you in.");
	}
}
?>

<?php
include_once "header.php"
?>
<div class="content">
<h1>Sign-in to YourMart</h1>
<?php
$show_form = true;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	if (!$_SESSION['valid']) {
		displayFormErrors($errors_list);
	} else {
		$show_form = false;
	}
}
?>
<?php if ($show_form) { ?>
<form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
Username: <input type=text name="username" placeholder="Your username" required autofocus>
<br>
Password: <input type=password name="password" placeholder="Your password" required>
<br>
<button type="submit" name="login_button">Login</button>
</div>
<form>
<?php } else echo "Welcome, $username." ?>
<?php
include_once "footer.php"
?>
</body></html>
