<?php
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>NMT</title>
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<link type="text/css" rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.5/css/materialize.min.css" media="screen,projection" />
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.5/js/materialize.min.js"></script>
	<style>
	.card{
		padding: 5%;
	}
	</style>
</head>
<body style="background-color:#232830">
<h2 class="center" style="color:white;">Network Monitoring Tool</h2>
<div class="container">
<form action="sql.php" class="card z-depth-1" method="post" style="background-color:#2C323C">
<label id="user">Username</label>
<input id="user" name="username" required type="text"/><br>
<label id="pass">Password</label>
<input id="pass" name="password" required type="password"/>
<button class="center waves-effect waves-light btn" type="submit">Submit</button>
</form>
</div>
</body>
</html>

