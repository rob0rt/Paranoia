<?php
session_start();
require_once("config.php");

echo "LOGIN";

if($_GET["logout"] == "true") {
	session_destroy();
	setcookie("user", "", time()-2593000, "/");
	setcookie("pass", "", time()-2593000, "/");
	header("location: " . URL . "index.php");
}
else {
	$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	
	$user = $_POST['user']; 
	$pass = $_POST['pass']; 
	$pass = md5($pass);
	
	$user = stripslashes($user);
	$pass = stripslashes($pass);
	
	$user = $mysqli->real_escape_string($user);
	$pass = $mysqli->real_escape_string($pass);
	
	if($_POST["remember"] == "on") {
		$expire=time()+60*60*24*30;
		setcookie("user", $user, $expire, "/");
		setcookie("pass", $pass, $expire, "/");
	}
	
	$temp = "SELECT * FROM users WHERE username='$user' and password='$pass'";
	
	$count = 0;
	if ($stmt = $mysqli->prepare($temp)) {
	
	    $stmt->execute();
	
	    $stmt->store_result();
	
	    $count = $stmt->num_rows;
	
	    $stmt->close();
	}
	if($count==1){
		$_SESSION["user"] = $user;
		$_SESSION["pass"] = $pass;
		header("location: " . URL . "dashboard.php");
	} else {
		header("location: " . URL . "?login=failed");
	}
}
?>