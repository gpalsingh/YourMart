<?php
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

function error_msg($st, $type="error-general") {
	return '<span class="' . $type . '">' . $st . '</span>';
}

function success_msg($st, $type="success-general") {
	return error_msg($st, $type);
}

function show_error_msg($st) {
	echo error_msg($st);
}

function show_success_msg($st) {
	echo success_msg($st);
}

function getDbConnection() {
	$conn = new mysqli("localhost", "pma", "pmapass", "yourmart");
	if ($conn->connect_errno) {
		show_error_msg("Unable to connect to the database.<br>");
		die(error_msg("Error code: " . $conn->connect_errno));
	}
	return $conn;
}

?>
