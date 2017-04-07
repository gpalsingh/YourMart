<html><head> <title>Template</title></head>
<body>
<?php
include_once "header.php"
?>
<div class="content">
<h1>About</h1>
<?php
$readme_file = fopen("../README.rst", "r") or die(error_msg("Unable to open file."));
echo "<div>";
while (!feof($readme_file)) {
	echo fgets($readme_file) . "</br>";
}
echo "</div>";
fclose($readme_file);
?>
</div>
<?php
include_once "footer.php"
?>
</body></html>

