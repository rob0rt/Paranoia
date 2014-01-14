<?php
	require_once("config.php");
	
	$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	
	$reply;
	$name;
	$gameID;
	$target;
	
	// Format the number from the text
	$text = str_replace("+1", "", $_REQUEST['From']);
	
	// Get the array of gameID's
	$q = "SELECT gameid FROM games";	
	$q1 = $mysqli->query($q);
	
	// Loop over all games
	while ($row = $q1->fetch_array(MYSQL_NUM)) {
	    // Loop over all cells in each game
		$query = "SELECT * FROM " . $row[0] . "";
		$qtip = $mysqli->query($query);
		
		while($game = $qtip->fetch_array(MYSQLI_ASSOC)) {
			if($text == $game['cell']) {
				$name = $game['player'];
				$target = $game['target'];
				$gameID = $row[0];
				break 2;
			}
		}
	}
		
	if(strcmp(strtolower($_REQUEST['Body']), "out") == 0) {
		
		// Set the player to out
		$q = "UPDATE " . $gameID . " SET target='OUT' WHERE player = '" . $name . "'";
		$mysqli->query($q);
		
		// Assign their assassin with the player's target
		$q = "UPDATE " . $gameID . " SET target='" . $target . "' WHERE target = '" . $name . "'";
		$mysqli->query($q);
		
		$reply = "Thank you for playing, " . $name;
	}
	else {
	
		// Get the weapon type
		$query = "SELECT * FROM games WHERE gameid = '" . $gameID . "'";
		$qtip = $mysqli->query($query);
		$gameData = $qtip->fetch_array(MYSQLI_ASSOC);
		$weapon = $gameData['weapon'];
		$user = $gameData['user'];
		
		// Get the rules short URL
		$rules = json_decode(file_get_contents("https://api-ssl.bitly.com/v3/shorten?access_token=".BITLY_ACCESS_TOKEN."&longUrl=".urlencode(URL . "rules.php?user=" .$user)."&format=json"))->data->url;
		
		$reply =
"Your target: " . $target . "
Weapon: ". $weapon . "
Rules: " . $shortcut ."
When out, reply with OUT";
	}
	
	header("content-type: text/xml");
	echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
?>
<Response>
	<Sms><?php echo $reply ?></Sms>
</Response>
