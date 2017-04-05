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
<link rel="stylesheet" href="css/main.css">
<link rel="stylesheet" href="css/header.css">
<script src="js/common.js" type="text/javascript"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<ul class="header test">
<li><a href="about.php">About Us</a></li>
<li><a href="terms.php">Terms</a></li>
<li><a href="index.php">Home</a></li>
<li>
<form name="search-form" action="index.php" method="GET">
<li><input type="text" placeholder="Search" name="searchkey" id="searchkey" required></li>
<li><button type="submit">GO!</button></li>
</form>
</li>
<?php if(!$_SESSION['valid'] == true) { ?>
<li><a href="signin.php">Sign-in</a></li>
<li><a href="register.php">Register</a></li>
<?php } else { ?>
<li><a href="add_product.php">Sell</a></li>
<li><a href="http://localhost?logout=true">Logout
<?php echo '(' . $_SESSION['username'] . ')'; } ?>
</a>
</li>
</ul>
<br>
