<?php
session_start();
?>
<!DOCTYPE html>
<html>
<body style="background-color:#232830;color:white;">
<?php
	$conn=mysqli_connect("localhost","root","swear@123","login");
	if($conn)
	{
		echo "Connection established";
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
						header('Refresh: 1, URL="display.php"');
					}
					else
					{
						echo "wrong credentials<br>";
						header('Refresh: 3,URL="/Network-Monitoring-Tool/"');
					}
				}
			}
			else
			{
				echo "wrong credentials<br>";
				header('Refresh: 3,URL="/Network-Monitoring-Tool/"');
			}
		}
	}
	else
	{
		echo "Could not establish connection";
	}

?>
</body>
</html>
