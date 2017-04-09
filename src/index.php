<html><head><title>Welcome to YourMart</title></head>
<body>
<?php
include_once "header.php";
?>
<div class="content">
<h1>Welcome to YourMart</h1>
<?php
//Connect to database
$conn = getDbConnection();

//Find query type
$start_pos = 0;
$page_size = 6;
$search_key = FALSE;
if (isset($_GET['searchkey']) && !empty($_GET['searchkey'])) {
	$search_key = $_GET['searchkey'];
}
if (isset($_GET['startpos']) && !empty($_GET['startpos'])) {
	$start_pos = $_GET['startpos'];
	//start_pos must be multiple of page_size
	$start_pos -= $start_pos % $page_size;
}

//Get data from database

if ($search_key === FALSE) {
	$query_base = "SELECT * FROM product_data LIMIT %d OFFSET %d;";
	$sql = sprintf($query_base, $page_size, $start_pos);
	$result = $conn->query("SELECT COUNT(id) as total_items FROM product_data;");
	$row = $result->fetch_assoc();
	$total_items = intval($row['total_items']);
} else {
	$query_base = "SELECT %s FROM product_data WHERE ("
		."title LIKE '%%%s%%' OR "
		."description LIKE '%%%s%%' OR "
		."seller LIKE '%%%s%%')";
	$sql = sprintf($query_base." LIMIT %d OFFSET %d;", "*",
		$search_key, $search_key, $search_key,
		$page_size, $start_pos);
	$count_sql = sprintf($query_base, "COUNT(id) as total_items",
		$search_key, $search_key, $search_key);
	$result = $conn->query($count_sql);
	$row = $result->fetch_assoc();
	$total_items = intval($row['total_items']);
}
$result = $conn->query($sql);
if ($result === FALSE) {
	show_error_msg("Failed to get data<br>");
	die(error_msg($conn->error));
}
if ($result->num_rows > 0) {
	echo '<table class="items-list-table"><tr><th>Title</th><th>Price</th>';
	echo "<th>Units left</th></tr>";
	while($row = $result->fetch_assoc()) {
		$row_str = '<tr><td><a href="%s">%s</td><td>%s</td><td>%d</td></tr>';
		echo sprintf($row_str,
				"show_product.php?id=".$row['id'],
				$row['title'],
				$row['price'],
				$row['units_left']);
	}
	echo "</table>";

//Navigation
$curr_page = (int)($start_pos / $page_size);
$last_page = (int)($total_items / $page_size);
if (($last_page * $page_size) == $total_items) {
	$last_page--;
}
echo '<table class="nav-items-list" alink="yellow" vlink="red"><caption>Page:</caption>';
if ($curr_page > 0) {
	echo "<td><a href=index.php?startpos=0><div>&lt;&lt;</div></a></td>";
	echo "<td><a href=index.php?startpos=",$start_pos-$page_size,"><div>",$curr_page,"</div></a></td>";
} else {
	echo "<td></td><td></td>";
}
echo "<td>" , $curr_page + 1 , "</td>";
if ($last_page > $curr_page) {
	echo "<td><a href=index.php?startpos=",$start_pos+$page_size,"><div>",$curr_page+2,"</div></a></td>";
	echo "<td><a href=index.php?startpos=",$last_page*$page_size,"><div>&gt;&gt;</div></a></td>";
} else {
	echo "<td></td><td></td>";
}
echo "</table>";
} else {
	show_error_msg("No items found.");
}
?>
</div>
<?php
include_once "footer.php";
?>
</body></html>
