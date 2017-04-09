<html><head><title>Sell</title></head>
<body>
<?php
include_once "header.php";
?>
<div class="content">
<h1>Your Cart</h1>
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	if (isset($_POST["add_to_cart_button"])) {
		$pid = $_POST['pid'];
		//Add product to session cart
		$count = $_POST['product_count'];
		$_SESSION['cart'][$pid] = $count;
	} else if (isset($_POST["order-button"])) {
		//Check if user is logged in
		if (!$_SESSION['valid']) {
			die(error_msg("You need to log in first"));
		}
		//Update item count
		$conn = getDbConnection();
		foreach ($_SESSION['cart'] as $id => $cnt) {
			$sql = "SELECT units_left FROM product_data WHERE id=".$id.";";
			$result = $conn->query($sql);
			if ($result === FALSE) {
				die(error_msg("Failed to get data.<br>Error:" . $conn->error));
			}
			$prev_count = intval($result->fetch_assoc()['units_left']);
			$sql = "UPDATE product_data SET units_left=".($prev_count-$cnt)." WHERE id=".$id.";";
			$result = $conn->query($sql);
			if ($result === FALSE) {
				die(error_msg("Failed to get data.<br>Error:" . $conn->error));
			}
		}
		//Reset cart
		$result = $conn->query("DELETE FROM product_data WHERE units_left<=0;");
		if ($result === FALSE) {
			die(error_msg("Failed to get data.<br>Error:" . $conn->error));
		}
		$conn->close();
		$_SESSION['cart'] = array();
		die(success_msg("Your order has been placed!"));
	}
}
//Build total as we fetch them
$num_products = 0;
$total_price = 0;

//List all the products in cart
$first_item = TRUE;
$conn = getDbConnection();
foreach ($_SESSION['cart'] as $id => $cnt) {
	$sql = "SELECT * FROM product_data WHERE id=" . $id;
	$result = $conn->query($sql);
	if ($result === FALSE) {
		die(error_msg("Failed to get data.<br>Error:" . $conn->error));
	}
	if ($conn->affected_rows == 0) {
		//Deleted item
		continue;
	}
	if ($first_item === TRUE) {
		echo "<table><tr><th>Product</th><th>Count</th><th>Price</th><th>Total Price</th></tr>";
		$first_item = FALSE;
	}
	$row = $result->fetch_assoc();
	echo "<tr><td>".$row['title']."</td><td>$cnt</td><td>".$row['price']."</td><td>".$cnt * $row['price']."</td></tr>";
	echo "<tr><td></td><td></td></tr>";
	$total_price += $cnt * $row['price'];
	$num_products++;
}
$conn->close();
if ($num_products === 0) {
	show_error_msg("Your cart is empty at the moment. Let's go buy something!");
} else {
	//Show grand total
	echo "<tr><th>Total</th><td>$total_price</td></tr>";
	echo "</table>";
	//Order the items
?>
<div class="button-container">
<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST">
<button name="order-button" type="submit">
Order!
</button>
</form>
</div>
<?php
}
?>
</div>
<?php
include_once "footer.php";
?>
</html>
