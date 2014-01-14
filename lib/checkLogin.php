<?php
session_start();
function checkLogin() {
	if(isset($_SESSION['user']))
		return true;
	if(isset($_COOKIE['user'])) {
		
		$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
		$user = $_COOKIE['user'];
		$pass = $_COOKIE['pass'];
		$temp = "SELECT * FROM users WHERE username='$user' and password='$pass'";
	
		$count = 0;
		if ($stmt = $mysqli->prepare($temp)) {
		
		    $stmt->execute();
		
		    $stmt->store_result();
		
		    $count = $stmt->num_rows;
		
		    $stmt->close();
		}
		
		if($count==1) {
			if(!isset($_SESSION['user'])) {
				$_SESSION['user'] = $user;
				$_SESSION['pass'] = $pass;
			}
			return true;
		}
		else {
			return false;
		}
	}
	else
		return false;
}
?>