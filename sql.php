<?php
session_start();
?>
<!DOCTYPE html>
<html>
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
<body style="background-color:#232830;color:white;">
<?php
	$conn=mysqli_connect("localhost","root","swear@123","login");
	if($conn)
	{
		if(!empty($_POST["username"]) && !empty($_POST["password"]))
		{
			$user=$_POST["username"];
			$password=$_POST["password"];
			$sql="select password from users where username='".$user."'";
			$result=mysqli_query($conn,$sql);
			if(mysqli_num_rows($result)>0)
			{
				while($row=mysqli_fetch_assoc($result))
				{

					if($row["password"]==$password)
					{
						echo " - correct credentials</br>";
						echo "<a href='logout.php' style='color:#26a69a'>Logout</a><br>";
						$_SESSION["username"]=$user;
						$_SESSION["password"]=$password;
						header('Refresh: 0, URL="display.php"');
					}
					else
					{
						echo "<h2 class='center' style='color:white;'>Network Monitoring Tool</h2><div class='container'><div class='card center' style='background-color:#2C323C;'><h4>Sorry you entered wrong credentials</h4></div></div>";
						header('Refresh: 5,URL="/Network-Monitoring-Tool/"');
					}
				}
			}
			else
			{
				echo "<h2 class='center' style='color:white;'>Network Monitoring Tool</h2><div class='container'><div class='card z-depth-1 center' style='background-color:#2C323C;'><h4>Sorry you entered wrong credentials</h4><br>You will be redirected automatically</div></div>";
				header('Refresh: 5,URL="/Network-Monitoring-Tool/"');
			}
		}
	}
	else
	{
		echo "<div class='card z-depth-1>'<br>Sorry you entered wrong credentials<br></div>";
	}

?>
</body>
</html>
