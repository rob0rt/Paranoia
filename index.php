<?php
	include "lib/checkLogin.php";
	$failed = ($_GET["login"] == "failed");
?>
<!DOCTYPE html>
<html>
<head>
	  <title>Paranoia</title>
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
	<!-- Login -->
	<div id="login" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
			<h3 id="myModalLabel">Login</h3>
		</div>
		<div class="modal-body">
			<?php if($failed) { ?>
				<div class="alert alert-error" id="failedLogin">
					<button type="button" class="close" data-dismiss="alert">&times;</button>
					Login Failed.
				</div>
			<?php } ?>
			<form class="form-horizontal" method="post" action="lib/login.php">
				<div class="control-group">
					<label class="control-label" for="inputUsername">Username</label>
					<div class="controls">
						<input type="text" id="inputUsername" placeholder="Username" name="user">
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="inputPassword">Password</label>
					<div class="controls">
						<input type="password" id="inputPassword" placeholder="Password" name="pass">
					</div>
				</div>
				<div class="control-group">
					<div class="controls">
						<label class="checkbox">
						<input type="checkbox" name="remember"> Remember me</label>
						<div style="padding-bottom: 20px"></div>
						<button type="submit" class="btn">Sign in</button>
					</div>
				</div>
			</form>
		</div>
		<div class="modal-footer">
			<a class="btn" data-dismiss="modal" aria-hidden="true" data-toggle="modal" href="#createaccount">Create Account</a>
			<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
		</div>
	</div>
	
	<!-- Create Account -->
	<div id="createaccount" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div id="alert"></div>
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
			<h3 id="myModalLabel">Create an account</h3>
		</div>
		<div class="modal-body">
			<form class="form-horizontal" method="post" action="lib/newuser.php">
				<div class="control-group" id="accountName">
					<label class="control-label" for="createUsername">Username</label>
					<div class="controls">
						<input type="text" id="createUsername" placeholder="Username" name="user" onchange="checkUserExists();" required>
					</div>
				</div>
				<div class="control-group" id="userEmail">
					<label class="control-label" for="inputEmail">Email</label>
					<div class="controls">
						<input type="text" id="inputEmail" placeholder="Email" name="email" onchange="verifyEmail();" required>
					</div>
				</div>
				<div class="control-group" id="createPsswd">
					<label class="control-label" for="createPassword">Password</label>
					<div class="controls">
						<input type="password" id="createPassword" placeholder="Password" name="pass" onchange="checkPW();" required>
					</div>
				</div>
				<div class="control-group" id="verifyPsswd">
					<label class="control-label" for="verifyPassword">Verify Password</label>
					<div class="controls">
						<input type="password" id="verifyPassword" placeholder="Verify Password" onchange="checkPW();" required>
					</div>
				</div>
				<div class="control-group">
					<div class="controls">
						<label class="checkbox">
						<button type="submit" class="btn" id="mkAccount">Create Account</button>
					</div>
				</div>
			</form>
		</div>
		<div class="modal-footer">
			<a class="btn" data-dismiss="modal" aria-hidden="true" data-toggle="modal" href="#login">Login</a>
			<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
		</div>
	</div>
	
	<!-- Main Title -->
	<h1 class="maintitle hidden-phone">Paranoia</h1>
	<h1 class="maintitle visible-phone" style="font-size:30px">Paranoia</h1>
	<script>$(window).resize();</script>
	<?php if($failed) { ?>
		<script>$('#login').modal('show');</script>
	<?php } ?>
</body>
</html>