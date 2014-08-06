<?php session_start();
require_once("lib/config.php");

include "lib/checkLogin.php";

$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Get the Rules
if ($stmt = $mysql->prepare('SELECT rules FROM games WHERE user = ?')) {
  $stmt->bind_param('s', $_GET['user']);
  $stmt->execute();
  $stmt->bind_result($rules);
  $stmt->fetch();
  $stmt->close();
  $rules = $rules[0];
}

// Get the weapon type
$query = "SELECT weapon FROM games WHERE user = '" . $_SESSION['user'] . "'";
$qtip = $mysqli->query($query);
$weapon = $qtip->fetch_array(MYSQLI_NUM);
$weapon = $weapon[0];
?>
<!DOCTYPE html>
<html>
<head>
	<title>Paranoia - Rules</title>
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
					<?php if(!checkLogin()) { ?>
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">Login <b class="caret"></b></a>
					<ul class="dropdown-menu">
						<li><a href="#login" data-toggle="modal">Login</a></li>
						<li><a href="#createaccount" data-toggle="modal">Create Account</a></li>
					</ul>
					<?php } else { ?>
					<a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php print $_SESSION['user'] . " "; ?><b class="caret"></b></a>
					<ul class="dropdown-menu">
						<li><a href="dashboard.php">Go To Dashboard</a></li>
						<li class="divider"></li>
						<li><a href="lib/login.php?logout=true" data-toggle="modal">Logout</a></li>
						<li class="disabled"><a href="#" data-toggle="modal">Account Settings</a></li>
					</ul>
					<?php } ?>
				</li>
			</ul>
		</div>
	</div> 
	<div class="section container-fluid">
		<div class="row-fluid">
			<div class="span6 offset3 well" id="stats">
				<h1>Weapon: <?php echo nl2br($weapon); ?></h1>
			</div>
		</div>
		<div class="row-fluid">
			<div class="span6 offset3 well" id="stats">
				<h1>Rules</h1>
				<p style="font-size: 20px; line-height:30px;"><?php echo nl2br($rules); ?></p>
			</div>
		</div>
	</div>
</body>
</html>
