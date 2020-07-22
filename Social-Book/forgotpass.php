<?php 
	session_start();
	require_once('functions.php');
	require_once('config.php');
	if (user_loged_in()) {
		header('location: profile.php');
		die();
	}

	if (isset($_POST['sendvk'])) {
		$email = $_POST['email'];
		$vkey = md5(time().'86442gfge$#@?()&');
		$to = $email;
		$sub = "Email verification";
		$msg = "Please confirm your email varification by clicking \r\n";
		$msg .= "<a href='http://localhost/practice2/resetpass.php?vkey=$vkey&email=$email'>Reset password</a> \r\n";
		$header = "content-type: text/html";
		
		if ($email == NULL) {
			$error['email'] = "Please enter your email";
		}
		if (!$email == NULL) {
				if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
					$error['emailfilter'] = "Email is not valid. Please enter a valid email address";
				}
			}
			if (!isset($error)) {
				if (email_exists()) {
					
					$query_verify = mysqli_query($connect, "SELECT * FROM users WHERE verified = verified AND email = '$email'");
					if (mysqli_num_rows($query_verify) == 1) {
						mail($to, $sub, $msg, $header);
					$verifysuccess = "Please check your email. We have send a verification mail to your gmail.";
					 $updatevk = mysqli_query($connect, "UPDATE users SET vkey = '$vkey' WHERE email = '$email' LIMIT 1");
					}
					else{
						$verify_error = "Your account is not verified. Please verified your account first";
					}
				}
				else{
				$erroremail = "Email does not exists please" . "<a href= register.php> Register</a>";

			}
			
			}
	}
 ?>
<!DOCTYPE html>
<html>
<head>
	<title>Forgot password</title>
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
	
	<div class="container"><br>
		<form method="Post" action="">
		<label for="email">Enter your email</label>
		<input id="email" type="email" name="email"><br><br>
		<?php if (isset($error['email'])) {
			echo "<div class= 'error'>" . $error['email'] . "</div>" . "<br>";
		}
				if (isset($error['emailfilter'])) {
				 	echo "<div class= 'error'>" . $error['emailfilter'] . "</div>" . "<br>";
				 } ?>
		
		<input type="submit" name="sendvk" value="Send">
	</form><br>
		<?php 
			if (isset($verifysuccess)) {
				echo "<div class= 'successreg'>" . $verifysuccess . "</div>" . "<br>";
			}
			if (isset($verify_error)) {
				echo "<div class= 'error'>" . $verify_error . "</div>" . "<br>";
			}
			if (isset($erroremail)) {
				echo "<div class= 'error'>" . $erroremail . "</div>" . "<br>";
			}
			 ?>
	</div>
</body>
</html>