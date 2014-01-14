<?php
require_once("config.php");

$username = $_POST["user"];

$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);


$username = $mysqli->real_escape_string($username);
$temp = "SELECT * FROM users WHERE username='$username'";

$query = $mysqli->query($temp);

print json_encode(mysqli_num_rows($query));
?>