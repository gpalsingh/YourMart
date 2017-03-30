<html><head><title>Sell</title></head>
<body>
<?php
include_once "header.php";
?>
<div class="content">
<?php if($_SESSION['valid'] === true) {?>
<script type="text/javascript">
var validValues = {
	"product-title": false,
};

function checkTitleValid(id) {
	title = getById(id);
	title_errors = getErrorField(id);

	if (title.value.length < 10) {
		validValues[id] = false;
		title_errors.innerHTML += "Title too short (at least ten characters).<br>";
	} else {
		validValues[id] = true;
	}

	updateErrorField(id, validValues, title_errors);
}

$(document).ready(function() {
	$("#add-product-form").submit(function checkFormValid(e) {
		checkTitleValid("product-title");
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
<h1>Add product data</h1>
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$title = clean_data($_POST['product-title']);
	$desc = clean_data($_POST['product-description']);
	$price = $_POST['product-price'];
	$units = $_POST['product-units'];
	$seller = $_SESSION['username'];

	$conn = new mysqli("localhost", "pma", "pmapass", "yourmart");
	if ($desc) {
		$query_base = "INSERT INTO product_data (title, price, description, seller, units_left) VALUES ('%s', %d, '%s', '%s', %d);";
		$query_string = sprintf($query_base, $title, $price, $desc, $seller, $units);
	} else {
		$query_base = "INSERT INTO product_data (title, price, seller, units_left) VALUES ('%s', %d, '%s', %d);";
		$query_string = sprintf($query_base, $title, $price, $seller, $units);
	}
	$sql = $conn->query($query_string);
	if (($conn->affected_rows) < 1) {
		echo "Failed to enter data.</br>";
		echo $conn->error;
	} else {
		echo "Entered data successfully.";
	}
	$conn->close();
}
?>
<form id="add-product-form" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST">
Title:<input type="text" name="product-title" id="product-title" required autofocus maxlength="200" placeholder="Enter title" onChange="checkTitleValid('product-title')"><br>
<span id="product-title-errors" class="hidden"><br></span>
Price:<input type="number" name="product-price" id="product-price" min="1" required placeholder="Enter price"><br>
Description:<textarea name="product-description" id="product-description"></textarea><br>
Total units:<input type="number" name="product-units" id="product-units" min="1" required placeholder="Number of units being sold"><br>
<button type="submit">Submit</button>
</form>
<?php } else echo "Not signed in"; ?>
</div>
<?php
include_once "footer.php";
?>
</body></html>
