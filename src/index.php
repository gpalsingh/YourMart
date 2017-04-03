<html><head><title>Welcome to YourMart</title></head>
<body>
<?php
include_once "header.php";
?>
<div class="content">
<h1>Welcome to YourMart</h1>
<?php
$start_pos = 0;
$page_size = 10;
if (isset($_GET['startpos']) && !empty($_GET['startpos'])) {
	$start_pos = $_GET['startpos'];
}

//Enter data into database
$conn = getDbConnection();
if (!$conn) {
	echo "Could not connect to database";
} else {
$result = $conn->query("SELECT COUNT(id) as total_items FROM product_data;");
$row = $result->fetch_assoc();
$total_items = intval($row['total_items']);
$query_base = "SELECT * FROM product_data LIMIT %d OFFSET %d;";
$sql = sprintf($query_base, $page_size, $start_pos);
$result = $conn->query($sql);
if ($result === FALSE) {
	echo "Failed to get data";
	die(0);
}
}
if ($result->num_rows > 0) {
	echo "<table><tr><th>Title<th><th>Price</th>";
	echo "<th>Units left</th></tr>";
	while($row = $result->fetch_assoc()) {
		$row_str = "<tr><td><a href=\"%s\">%s</td><td>%s</td><td>%d</td></tr>";
		echo sprintf($row_str,
				"show_product.php?id=".$row['id'],
				$row['title'],
				$row['price'],
				$row['units_left']);
	}
	echo "</table>";
}

//navigation
$curr_page = (int)($start_pos / $page_size);
$last_page = (int)($total_items / $page_size);
if (($last_page % $page_size) == 0) {
	$last_page--;
}
echo "Page:";
echo "<table>";
if ($curr_page > 0) {
	echo "<td><a href=index.php?startpos=0>&lt;&lt;</a></td>";
	echo "<td><a href=index.php?startpos=",$curr_page-1,">",$curr_page,"</a></td>";
}
echo "<td>" , $curr_page + 1 , "</td>";
if ($last_page > $curr_page) {
	echo "<td><a href=index.php?startpos=",$curr_page+1,">",$curr_page+2,"</a></td>";
	echo "<td><a href=index.php?startpos=$last_page>&gt;&gt;</a></td>";
}
echo "</table>";
?>
</div>
<?php
include_once "footer.php";
?>
</body></html>
