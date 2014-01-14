<?php session_start();
require_once("lib/config.php");

$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if(isset($_SESSION["user"])) { ?>
<!DOCTYPE html>
<html>
<head>
	  <title>Paranoia - Create Game</title>
	  <meta name="viewport" content="width=device-width, initial-scale=1.0">
	  <link href="css/bootstrap.css" rel="stylesheet" media="screen">
	  <link href="css/bootstrap-responsive.css" rel="stylesheet">
	  <link href="css/darkstrap.css" rel="stylesheet">
	  <link href="css/style.css" rel="stylesheet">
	  <link href='http://fonts.googleapis.com/css?family=Montserrat+Subrayada' rel='stylesheet' type='text/css'>
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
						<li><a href="dashboard.php">Go To Dashboard</a></li>
						<li class="divider"></li>
						<li><a href="lib/login.php?logout=true" data-toggle="modal">Logout</a></li>
						<li class="disabled"><a href="#" data-toggle="modal">Account Settings</a></li>
					</ul>
				</li>
			</ul>
		</div>
	</div>
	<div class="section container-fluid">
		<div class="row-fluid">
			<div class="span6 offset3">
				<form method="post" action="lib/setRules.php">
					<h3>Weapon Type:</h3>
					<?
					// Get the start time
					$query = "SELECT rules FROM games WHERE user = '" . $_SESSION['user'] . "'";
					$qtip = $mysqli->query($query);
					$rules = $qtip->fetch_array(MYSQLI_NUM);
					$rules = $rules[0];
					
					// Get the start time
					$query = "SELECT weapon FROM games WHERE user = '" . $_SESSION['user'] . "'";
					$qtip = $mysqli->query($query);
					$weapon = $qtip->fetch_array(MYSQLI_NUM);
					$weapon = $weapon[0];
					?>
					<input type="text" data-provide="typeahead" data-items="4" data-source="[&quot;socks&quot;, &quot;water&quot;, &quot;stickers&quot;, &quot;nerf&quot;, &quot;rubber band&quot;, &quot;marker&quot;]" name="weapon" <?php if($weapon != null) { echo "value= '" . $weapon . "'"; } ?> autocomplete="off">
					<h3>Rules:</h3>
					<textarea class="span12" rows="10" name="rules"><?php if($rules != null) { echo $rules; } ?></textarea>
					<button class="btn btn-block btn-info" type="submit" value="Submit" onclick="window.onbeforeunload = null;">Submit</button>
				</form>
			</div>
		</div>
	</div>
	<script>
		window.onbeforeunload = function() {
			return "All progress on this page will be lost if you leave. Make sure you click submit when you're done.";
		}
	</script>
</body>
</html>
<?php } else { 
	if(!isset($_SESSION["user"]))
		header("location: " . URL . "index.php");
} ?>