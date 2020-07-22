<?php 
	require_once("config.php");
	require_once("functions.php");
	
	if (isset($_GET['vkey']) && isset($_GET['email'])) {
		$vkey = $_GET['vkey'];
		$email = $_GET['email'];
		$resultSet = mysqli_query($connect,"SELECT verified, vkey FROM users WHERE verified ='not verified' AND vkey='$vkey' LIMIT 1");

		if(mysqli_num_rows($resultSet) == 1) {
			$update = mysqli_query($connect,"UPDATE users SET verified ='verified', vkey='' WHERE email= '$email' LIMIT 1 ");

			if ($update) {
				header('location: login.php');
			}
			else{
				echo "database connect error";
			}
			
		}
		else{
			header('location: login.php');
		}
	}
	else{
		header('location: login.php');
	}


	
 ?>
<!DOCTYPE html>
<html>
<head>
	<title>User verification</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>

</body>
</html>