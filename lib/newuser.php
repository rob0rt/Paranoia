<?php
require_once("config.php");

$user = $_POST['user'];
$pass = $_POST['pass'];
$email = $_POST['email'];
echo $email;
addNewUser($user, $pass, $email);

function addNewUser($username, $password, $email) {
	$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
   
	$salt = '$2a$10$RobertShouldStoreASeparateSaltWithEachUser';
	$password = crypt($password, $salt);
	
	$username = mysql_real_escape_string($username);
	$username = str_replace("<", "", $username);
	$username = str_replace(">", "", $username);
   
	$q = "INSERT INTO users (username, password, email) VALUES ('$username', '$password', '$email')";
	return $mysqli->query($q);
}
header("location: " . URL . "dashboard.php");
?>
