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
<link rel="icon" type="image/gif" href="logo.gif">
<script src="js/common.js" type="text/javascript"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script>
	$(document).ready(function () {
		//Add "YourMart" to title
		var title = document.getElementsByTagName("title")[0];
		title.innerHTML += " | YourMart";
	});
</script>
<ul class="header test">
<li style="padding:0px; margin:0px;">
<a href="index.php" style="text-align:left; padding:0px;">
<img src="logo.gif"></a></li>
<li><a href="about.php">About Us</a></li>
<li><a href="terms.php">Terms</a></li>
<li><a href="index.php">Home</a></li>
<li>
<form name="search-form-header" id="search-form-header" action="index.php" method="GET">
<li><input type="text" placeholder="Search" name="searchkey" id="searchkey" required></li>
<li><button type="submit">GO!</button></li>
</form>
</li>
<li><a href="cart.php">Cart</a></li>
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
