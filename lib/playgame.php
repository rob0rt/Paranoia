<?php 
session_start();

require "Services/Twilio.php";
require_once("config.php");

// Set up Twilio
$AccountSid = TWILIO_ID;
$AuthToken = TWILIO_TOKEN;
$from = TWILIO_NUMBER;
$client = new Services_Twilio($AccountSid, $AuthToken);

$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Get the start time
$query = "SELECT starttime FROM games WHERE user = '" . $_SESSION['user'] . "'";
$qtip = $mysqli->query($query);
$starttime = $qtip->fetch_array(MYSQLI_NUM);

if(isset($_SESSION["user"]) && $starttime[0] == null) {

	// Get the rules short URL
	$rules = json_decode(file_get_contents("https://api-ssl.bitly.com/v3/shorten?access_token=".BITLY_ACCESS_TOKEN."&longUrl=".urlencode(URL . "rules.php?user=" . $_SESSION["user"])."&format=json"))->data->url;
	
	// Set the starttime in the games table
	date_default_timezone_set('America/Mexico_City');
	$q = "UPDATE games SET starttime='" . date('Y-m-d H:i:s') . "' WHERE user = '" . $_SESSION['user'] . "'";
	$mysqli->query($q);	
	
	// Get the gameID
	$query = "SELECT gameid FROM games WHERE user = '" . $_SESSION['user'] . "'";
	$qtip = $mysqli->query($query);
	$gameid = $qtip->fetch_array(MYSQLI_NUM);
	$gameid = $gameid[0];
	
	// Get the weapon type
	$query = "SELECT weapon FROM games WHERE user = '" . $_SESSION['user'] . "'";
	$qtip = $mysqli->query($query);
	$weapon = $qtip->fetch_array(MYSQLI_NUM);
	$weapon = $weapon[0];
	
	// Loop over all players and send them a text
	$query = "SELECT * FROM " . $gameid . "";
	$qtip = $mysqli->query($query);
	
	while($row = $qtip->fetch_array(MYSQLI_ASSOC)) {
		$body = 
"Welcome to Paranoia.
Your target: " . $row['target'] . "
Weapon: ". $weapon . "
Rules: " . $rules ."
When out, reply with OUT";
		$message = $client->account->sms_messages->create($from, $row['cell'], $body);
	}
	
	header("location: " . URL . "dashboard.php");
}
else {
	if(!isset($_SESSION["user"]))
		header("location: " . URL . "index.php");
	else 
		header("location: " . URL . "dashboard.php");
}
?>