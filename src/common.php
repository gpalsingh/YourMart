<?php
function displayFormErrors($errors_list) {
	foreach ($errors_list as $error_val) {
		echo "<span class=\"form-errors\">$error_val</span>";
	}
}

function initSession() {
	$_SESSION['valid'] = false;
	$_SESSION['username']= null;
}

function logoutUser() {
	initSession();
}

function start_new_session() {
	if (session_status() == PHP_SESSION_NONE) {
		session_start();
	}
}

function clean_data($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>
