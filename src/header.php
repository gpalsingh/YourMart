<?php
	include_once "common.php";
	start_new_session();
	if ($_SERVER['REQUEST_METHOD'] === 'GET') {
		if (array_key_exists('logout', $_GET) && ($_GET['logout'] == true)) {
			logoutUser();
		}
	}
	if (!array_key_exists('valid', $_SESSION)) {
		initSession();
	}
?>
<div class="header">
<link rel="stylesheet" href="css/main.css">
<script src="js/common.js" type="text/javascript"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<a href="about.php">About Us</a>
<a href="terms.php">Terms</a>
<a href="index.php">Home</a>
<input type="text" placeholder="search">
<?php if(!$_SESSION['valid'] == true) { ?>
<a href="signin.php">Sign-in</a>
<a href="register.php">Register</a>
<?php } else { ?>
<a href="add_product.php">Sell</a>
<a href="http://localhost?logout=true">Logout</a>
<?php echo '(' . $_SESSION['username'] . ')'; } ?>
</div>
