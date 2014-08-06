<?php
session_start();
require_once("config.php");

if(isset($_SESSION["user"])) {	
	
	$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	
	if ($stmt = $mysqli->prepare('UPDATE games SET rules = ?, weapon = ? WHERE user = ?')) {
	  $stmt->bind_param('sss', $_POST['rules'], $_POST['weapon'], $_SESSION['user']);
	  $stmt->execute();
	  $stmt->close();
	}

	header("location: " . URL . "dashboard.php");
}
else {
	header("location: " . URL . "index.php");
}
?>
