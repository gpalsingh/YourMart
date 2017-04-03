<html><head><title>Product Details</title></head>
<body>
<?php
include_once "header.php";
?>
<div class="content">
<h1>Product Details</h1>
<?php
$id = -1;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$conn = getDbConnection();
	if (!$conn) {
		die("Cannot connect to database.");
	}
	if (isset($_POST["delete_button"])) {
		//Check if user owns the item
		$sql = "SELECT * FROM product_data WHERE id=" . $_POST["pid"];
		$result = $conn->query($sql);
		if ($result === FALSE) {
			die("Can't find product data.");
		}
		$row = $result->fetch_assoc();
		if ($row['seller'] !== $_SESSION['username']) {
			die("User doesn not own the item.");
		}
		//Delete the item
		$sql = "DELETE FROM product_data WHERE id=" . $_POST["pid"];
		$result = $conn->query($sql);
		if (($result === FALSE) || ($conn->affected_rows < 1)) {
			echo "Failed to delete the data.";
		} else {
			echo "Product data deleted sucessfully";
		}
	} else {
		//Assume update.
		$sql_base = 'UPDATE product_data SET '
			."title='%s', price=%d, description='%s', units_left=%d "
			."WHERE id=%d;";
		$sql = sprintf($sql_base,
			$_POST['ptitle'],
			$_POST['pprice'],
			$_POST['pdescription'],
			$_POST['punits'],
			$_POST['pid']);
		$result = $conn->query($sql);
		if ($result === FALSE) {
			echo "Failed to update data<br>";
			die($conn->error);
		}
		echo "Sucessfully updated the data";
		$conn->close();
		//Redirect to product page
		header("location:show_product.php?id=" . $_POST['pid']);
	}
	$conn->close();
}
else { //GET request code start
if (isset($_GET['id']) && !empty($_GET['id'])) {
	$id = $_GET['id'];
} else {
	die("Product not found");
}
//Get data
$uname = ($_SESSION['valid'] === true)? $_SESSION['username']: false;
$conn = new mysqli("localhost", "pma", "pmapass", "yourmart");
$sql = "SELECT * FROM product_data WHERE id=" . $id;
$result = $conn->query($sql);
if ($conn->affected_rows < 1) {
	$conn->close();
	die("Failed to get data. Product does not exist.");
}
//Show product data
if ($result->num_rows > 0) {
	$row = $result->fetch_assoc();
	if ($uname && ($uname === $row['seller'])) {
	
?>
<script type="text/javascript">
var validValues = {
	"ptitle": false,
};

function checkTitleValid(id) {
	title = getById(id);
	title_errors = getErrorField("product-change");

	if (title.value.length < 10) {
		validValues[id] = false;
		title_errors.innerHTML += "Title too short (at least ten characters).<br>";
	} else {
		validValues[id] = true;
	}

	updateErrorField(id, validValues, title_errors);
}

$(document).ready(function() {
	$("#change-product-form").submit(function checkFormValid(e) {
		checkTitleValid("ptitle");
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
</script>
<form id="change-product-form" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST">
<table>
<tr><th>Title</th>
<td><input type="text" name="ptitle" id="ptitle" required maxlength="200" onChange="checkTitleValid('ptitle')"
value="<?php echo $row['title']; ?>"></td>
</tr>
<tr><th>Price</th>
<td><input type="number" name="pprice" id="pprice" min="1" required value="<?php echo $row['price']; ?>"></td>
</tr>
<tr><th>Description</th>
<td><textarea name="pdescription" id="pdescription"><?php echo $row['description']; ?></textarea></td>
</tr>
<tr><th>Seller</th><td><?php echo $row['seller']; ?></td></tr>
<tr><th>Units Left</th>
<td><input type="number" name="punits" id="punits" min="1" required value="<?php echo $row['units_left']; ?>"></td>
</tr>
<tr><th>Operation</th>
<td>
<input type="hidden" name="pid" value=<?php echo $id ?>>
<button type="submit" name="update_button">Update</button>
<button type="submit" name="delete_button">Delete</button>
</td>
</tr>
</table>
<span id="product-change-errors" class="hidden"></span>
</form>
<?php
	} else {
	$row_str = "<table><tr><th>Title</th><td>%s</td></tr>"
 		."<tr><th>Price</th><td>%d</td></tr>"
 		."<tr><th>Description</th><td>%s</td></tr>"
 		."<tr><th>Seller</th><td>%s</td></tr>"
 		."<tr><th>Units Left</th><td>%s</td></tr></table>";
	echo sprintf($row_str,
			$row['title'],
			$row['price'],
			$row['description'],
			$row['seller'],
			$row['units_left']);
	}
}
} //GET request code end
?>
</div>
<?php
include_once "footer.php";
?>
</body>
</html>
