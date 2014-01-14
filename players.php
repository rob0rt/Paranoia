<?php session_start();
require_once("lib/config.php");

$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

$query = "SELECT gameid FROM games WHERE user = '" . $_SESSION['user'] . "'";
$qtip = $mysqli->query($query);
$row = $qtip->fetch_array(MYSQLI_NUM);

if(isset($_SESSION["user"]) && (($row[0] == null) || ($_GET['modify'] == true))){ ?>
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
				<?php if($_GET['modify'] != true) { ?>
				<form method="post" action="lib/addPlayers.php">
				<?php } else { ?>
				<form method="post" action="lib/addPlayers.php?modify=true">
				<?php } ?>
					<table class="table table-striped" id="addPlayers">
						<?php if($_GET['error'] == true) { ?>
						<caption style="margin-bottom: 20px;">
						<div class="alert alert-error">
							<button type="button" class="close" data-dismiss="alert">&times;</button>
							<h4>Player Submission Error.</h4>
							You must have at least three players.
						</div> </caption><?php } ?>
						<thead>
							<tr>
								<th>Player</th>
								<th>Cell Phone</th>
								<th>Remove Player</th>
							</tr>
						</thead>
						<tbody>
							<?php if($_GET['modify'] != true) { ?>
							<tr>
								<td><input class="noEnterSubmit" type="text" placeholder="Player name" name="p[]"></td>
								<td><input class="noEnterSubmit" type="text" placeholder="Player cell" name="c[]"></td>
								<td><button class="btn btn-danger" type="button" onclick="deleteRow(this)">Remove</button></td>
							</tr>
							<tr>
								<td><input class="noEnterSubmit"  type="text" placeholder="Player name" name="p[]"></td>
								<td><input class="noEnterSubmit" type="text" placeholder="Player cell" name="c[]"></td>
								<td><button class="btn btn-danger" type="button" onclick="deleteRow(this)">Remove</button></td>
							</tr>
							<tr>
								<td><input class="noEnterSubmit" type="text" placeholder="Player name" name="p[]"></td>
								<td><input class="noEnterSubmit" type="text" placeholder="Player cell" name="c[]"></td>
								<td><button class="btn btn-danger" type="button" onclick="deleteRow(this)">Remove</button></td>
							</tr>
							<?php } else {
							$query = "SELECT * FROM " . $row[0] . "";
							$qtip = $mysqli->query($query);
							while($row = $qtip->fetch_array(MYSQLI_ASSOC)) : ?>
							<tr>
								<td><input class="noEnterSubmit" type="text" placeholder="Player name" value="<?php echo $row['player']; ?>" name="p[]"></td>
								<td><input class="noEnterSubmit" type="text" placeholder="Player cell" value="<?php echo $row['cell']; ?>" name="c[]"></td>
								<td><button class="btn btn-danger" type="button" onclick="deleteRow(this)">Remove</button></td>
							</tr>
							<?php endwhile; 
							} ?>
						</tbody>
					</table>
					<div class="input-append" style="margin-bottom: 20px">
						<input class="span4 noEnterSubmit" placeholder="1 - 100" id="numPlayToAdd" type="number" min="1" max="100">
						<button class="btn" type="button" onclick="addMultipleRows()">Add Multiple Players</button>
						<button class="btn btn-primary" type="button" onclick="addRow()">Add Single Player</button>
					</div>
					<button class="btn btn-block btn-info" type="submit" value="Submit" onclick="window.onbeforeunload = null;">Submit Players</button>
				</form>
			</div>
		</div>
	</div>
	<script>
		window.onbeforeunload = function() {
			return "All progress on this page will be lost if you leave. Make sure you submit players when you're done.";
		}
	</script>
</body>
</html>
<?php } else { 
	if(!isset($_SESSION["user"]))
		header("location: " . URL . "index.php");
	else if($row[0] != null)
		header("location: " . URL . "dashboard.php");
} ?>