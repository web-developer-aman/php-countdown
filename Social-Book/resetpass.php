<?php 
	session_start();
	require_once('functions.php');
	require_once('config.php');
	if (user_loged_in()) {
		header('location: profile.php');
		die();
	}

	if (isset($_GET['vkey']) && isset($_GET['email'])){
		$vkey = $_GET['vkey'];
		$email = $_GET['email'];
		$resultset = mysqli_query($connect, "SELECT vkey, email FROM users WHERE vkey= '$vkey' AND email= '$email' LIMIT 1");
		if (mysqli_num_rows($resultset) == 1) {

		if (isset($_POST['sendrepass'])) {
		$repass = $_POST['repass'];
		$resetpass = md5($repass);
		$crepass = $_POST['crepass'];
		$to = $email;
		$sub = "Password change successfull";
		$msg = "You have successfully change your password. Please \r\n";
		$msg .= "<a href='http://localhost/practice2/login.php'>Login</a> \r\n";
		$header = "content-type: text/html";

		if ($repass == NULL) {
			$error['repass'] = "Please enter your new password";
		}
		if ($crepass == NULL) {
			$error['crepass'] = "Confirm your new password";
		}
		if (!$crepass == NULL) {
			if ($crepass != $repass) {
				$error['cpasserror'] = "Password does not match";
			}
		}
		if (!$repass == NULL) {
			if (strlen($repass) < 6) {
				$error['pcharerror'] = "Password must be at least 6 characters";
			}
		}
		if (!isset($error)) {
			$updatepass = mysqli_query($connect, "UPDATE users SET password = '$resetpass', vkey = '' WHERE email= '$email' LIMIT 1");
			if ($updatepass) {

				mail($to, $sub, $msg, $header);
				$success_update_pass = "Password has been change successfully. Please" . "<a href= 'login.php'> login</a>";
				}
				
			}
			else{
				$error_update_pass = "Something went wrong. Please retry";
			
		}
	}
		}
		else{
			header('location:login.php');
		}
	}
	else{
			header('location: login.php');
	}
 ?>
<!DOCTYPE html>
<html>
<head>
	<title>Reset password</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<style>

	body{
		background: url(admin/img/bg2.jpg);
		background-size: cover;
		background-position: fixed;		
		color:#fff;
	}
	
</style>
<body>
	<div class="container">
		<form method="POST" action=""><br>
			<label for="repass">Enter new password</label><br>
			<input type="password" name="repass"><br><br>
			<?php if (isset($error['repass'])) {
			echo "<div class= 'error'>" . $error['repass'] . "</div>" . "<br>";
			}
				if (isset($error['pcharerror'])) {
			echo "<div class= 'error'>" . $error['pcharerror'] . "</div>" . "<br>";
			} ?>
			<label for="crepass">Confirm new password</label><br>
			<input type="password" name="crepass"><br><br>
			<?php if (isset($error['crepass'])) {
			echo "<div class= 'error'>" . $error['crepass'] . "</div>" . "<br>";
			} 
			if (isset($error['cpasserror'])) {
			echo "<div class= 'error'>" . $error['cpasserror'] . "</div>" . "<br>";
			}?>
			<input type="submit" name="sendrepass" value="Reset">
		</form><br>
		<?php 
		if (isset($success_update_pass)) {
			echo "<div class= 'successreg'>" . $success_update_pass . "</div>" . "<br>";
			}
			if (isset($error_update_pass)) {
			echo "<div class= 'error'>" . $error_update_pass . "</div>" . "<br>";
			} ?>
	</div>
</body>
</html>