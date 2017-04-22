<?php
session_start();
?>
<!DOCTYPE html>
<html>
<body>
<?php
	$conn=mysqli_connect("localhost","root","tanisha","login");
	if($conn)
	{
		echo "Connection established";
		if(!empty($_POST["username"]) && !empty($_POST["password"]))
		{
			$user=$_POST["username"];
			$password=$_POST["password"];
			$sql="select password from users where username='".$user."'";
			echo $sql."<br>";
			$result=mysqli_query($conn,$sql);
			if(mysqli_num_rows($result)>0)
			{
				while($row=mysqli_fetch_assoc($result))
				{

					if($row["password"]==$password)
					{
						echo "correct credentials</br>";
						echo "<a href='logout.php'>Logout</a><br>";
						$_SESSION["username"]=$user;
						$_SESSION["password"]=$password;
						echo "hello<br>";
						$script=shell_exec('sudo ./script.sh');
						echo $script;
						echo "script run";
						header('Refresh: 10, URL="display.php"');
					}
					else
					{
						echo "wrong credentials<br>";
						header('Refresh: 10,URL="/Network-Monitoring-Tool/"');
					}
				}
			}
			else
			{
				echo "wrong credentials<br>";
				header('Refresh: 10,URL="/Network-Monitoring-Tool/"');
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
