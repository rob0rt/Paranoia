<?php session_start(); 
require_once("lib/config.php");
$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Get the gameID
$query = "SELECT gameid FROM games WHERE user = '" . $_SESSION['user'] . "'";
$qtip = $mysqli->query($query);
$gameid = $qtip->fetch_array(MYSQLI_NUM);
$gameid = $gameid[0];

// Get the start time
$query = "SELECT starttime FROM games WHERE user = '" . $_SESSION['user'] . "'";
$qtip = $mysqli->query($query);
$starttime = $qtip->fetch_array(MYSQLI_NUM);
$starttime = $starttime[0];

// Get the rules
$query = "SELECT rules FROM games WHERE user = '" . $_SESSION['user'] . "'";
$qtip = $mysqli->query($query);
$rules = $qtip->fetch_array(MYSQLI_NUM);
$rules = $rules[0];

// Get the weapon type
$query = "SELECT weapon FROM games WHERE user = '" . $_SESSION['user'] . "'";
$qtip = $mysqli->query($query);
$weapon = $qtip->fetch_array(MYSQLI_NUM);
$weapon = $weapon[0];
			
if(isset($_SESSION["user"])) { ?>
<!DOCTYPE html>
<html>
<head>
	<title>Paranoia - Dashboard</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="css/bootstrap.css" rel="stylesheet" media="screen">
	<link href="css/bootstrap-responsive.css" rel="stylesheet">
	<link href="css/darkstrap.css" rel="stylesheet">
	<link href="css/font-awesome.min.css" rel="stylesheet">
	<!--[if IE 7]>
	<link rel="stylesheet" href="css/font-awesome-ie7.min.css">
	<![endif]-->
	<link href="css/style.css" rel="stylesheet">
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
	<script src="js/bootstrap.js"></script>
	<script src="js/scripts.js"></script>
</head>
<body>
	<div class="navbar navbar-static-top">
		<div class="navbar-inner">
			<ul class="nav pull-right">
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $_SESSION["user"] . " "; ?><b class="caret"></b></a>
					<ul class="dropdown-menu">
						<li><a href="lib/login.php?logout=true" data-toggle="modal">Logout</a></li>
						<li class="disabled"><a href="#" data-toggle="modal">Account Settings</a></li>
					</ul>
				</li>
			</ul>
		</div>
	</div>
	<?php
	if($gameid != null) { ?>
	<div class="section container-fluid">
		<div class="row-fluid">
			<div class="span6 well">
				<table class="table table-striped" id="Players">
					<h1>Current Players<h1>
					<thead>
						<tr>
							<th>Player</th>
							<th>Target</th>
						</tr>
					</thead>
					<tbody>
					<?php 
						$query = "SELECT * FROM " . $gameid . "";
						$qtip = $mysqli->query($query);
						while($row = $qtip->fetch_array(MYSQLI_ASSOC)) :
						if(strcmp($row['target'], "OUT") == 0) { ?>
						<tr class="error"> <?php } else { ?>
						<tr> <?php } ?>
							<td><?php echo $row['player']; ?></td>
							<td><?php echo $row['target']; ?></td>
						</tr>
					<?php endwhile; ?>
					</tbody>
				</table>
				<?php if($starttime == null) { ?>
				<a class="btn btn-block btn-primary" type="submit" href="players.php?modify=true">Edit Players</a>
				<? } ?>
			</div>
			<div class="span6" id="stats">
			<?php
			if($starttime != null) {
			?>
				<div class="row-fluid">
					<div class="span6 well">
						<h1>Time Elapsed</h1>
						<h3 id="timePassed">0</h3>
					</div>
					<div class="span6 well">
						<h1>Current Time</h1>
						<h3 id="time">0</h3>
					</div>
				</div>
				<div class="row-fluid">
					<div class="span6 well">
						<h1>Current Deaths</h1>
						<h3 id="deaths">0</h3>
					</div>
					<div class="span6 well">
						<h1>Weapon</h1>
						<h3 id="weapon"><?php echo $weapon; ?></h3>
					</div>
				</div>
				<div class="row-fluid">
					<div class="span12 well">
						<h1>Rules</h1>
						<p style="font-size: 20px; line-height:30px;"><?php echo nl2br($rules); ?></p>
					</div>
				</div>
			<?php } else { ?>
				<div class="row-fluid">
					<div class="span12 well">
						<h1>Your game is not yet started.</h1>
						<h3>Make some changes or push start to begin!</h3>
						<a href="lib/playgame.php" class="icon-off span12" id="gameStart"></a>
						<h3 class="span12" id="gameStartText">Start Game</h3>
					</div>
				</div>
				<?php if($rules != null) { ?>
				<div class="row-fluid">
					<div class="span12 well">
						<h1>Rules</h1>
						<p style="font-size: 20px; line-height:30px;"><?php echo nl2br($rules); ?></p>
						<a class="btn btn-block btn-primary" type="submit" href="addrules.php?modify=true">Edit Rules</a>
					</div>
				</div>
				<?php } ?>
			<? } ?>
			</div>
			<script>setInterval('getTime()', 1000); setInterval('getElapsed(\"<?php echo $starttime; ?>\")', 1000);</script>
		</div>
	</div>
	<?php } else { ?>
	<div class="section container-fluid">
		<div class="row-fluid">
			<div class="span4 offset4 well">
				<h1>No Current Game<h1>
				<a class="btn btn-primary btn-block" type="button" style="margin-top: 20px;" href="players.php">Create a game.</a>
			</div>
		</div>
	</div>
	<?php } ?>
</body>
</html>
<?php } else { header("location: " . URL . "index.php");} ?>