<?php
session_start();
require_once("config.php");

if(isset($_SESSION["user"])) {
	
	// remove all blank indicies
	for($i = 0; $i < count($_POST['p']); $i++) {
		if($_POST['p'][$i] != null) {
			$player[] = $_POST['p'][$i];
			$cells[] = preg_replace('/\D+/', '', $_POST['c'][$i]);
		}
	}
	
	$assignments = array_merge($player);
	
	// If less then three play in array, return back error
	if(count($player) < 3) {
		header("location: " . URL . "players.php?error=true");
		die();
	}
	
	// shift all elements in assignment by 1
	$assignments[count($assignments)-1] = array_shift($assignments);
			
	$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	
	if($_GET['modify'] != true) { 
		// Make a gameID based off of time and username
		date_default_timezone_set('America/Mexico_City');
		$gid = $_SESSION['user'] . date('mdyhis', time());
				
		// Create a new entry in the games database that stores the user's name and the unique gameID
		$q = "INSERT INTO games (user, gameid) VALUES ('" . $_SESSION['user'] . "', '$gid')";
		$mysqli->query($q);
		
		// Create a table that holds the players, targets, and cellphone numbers
		$q= "CREATE TABLE " . $gid . " (id INT NOT NULL AUTO_INCREMENT, player TEXT, target TEXT, cell TEXT, PRIMARY KEY (id))";
		$mysqli->query($q);
		
		// Add all players, targets, and cells into the game table
		for($i = 0; $i < count($player); $i++) {
			$q = "INSERT INTO " . $gid . " (player, target, cell) VALUES ('" . $player[$i] . "', '" . $assignments[$i] . "', '" . $cells[$i] . "')";
			$mysqli->query($q);
		}
		
		header("location: " . URL . "addrules.php");
	}
	else {
		// Get the gameID
		$query = "SELECT gameid FROM games WHERE user = '" . $_SESSION['user'] . "'";
		$qtip = $mysqli->query($query);
		$gameid = $qtip->fetch_array(MYSQLI_NUM);
		
		// Delete all entries in game table
		$q = "DELETE FROM " . $gameid[0];
		$mysqli->query($q);
		
		// Add all players, targets, and cells into the game table
		for($i = 0; $i < count($player); $i++) {
			$q = "INSERT INTO " . $gameid[0] . " (player, target, cell) VALUES ('" . $player[$i] . "', '" . $assignments[$i] . "', '" . $cells[$i] . "')";
			$mysqli->query($q);
		}
		
		header("location: " . URL . "dashboard.php");
	}
}
else {
	header("location: " . URL . "index.php");
}
?>