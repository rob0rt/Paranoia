<?php
session_start();
require_once("config.php");

if(isset($_SESSION["user"])) {	
	
	$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	
	$q = "UPDATE games SET rules='" . $_POST['rules'] . "', weapon='" . $_POST['weapon'] . "' WHERE user = '" . $_SESSION['user'] . "'";
	$mysqli->query($q);

	header("location: " . URL . "dashboard.php");
}
else {
	header("location: " . URL . "index.php");
}
?>