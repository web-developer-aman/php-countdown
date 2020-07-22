<?php
	session_start();
	require_once ('functions.php');

	if (user_loged_in()) {
		header('location: home.php');
		die();
	}

	date_default_timezone_set('Asia/Dhaka');

	$reg_query = mysqli_query($connect, "SELECT reg_date FROM users WHERE verified = 'not verified'");

	while ($run_reg = mysqli_fetch_assoc($reg_query)) {
		$reg_time = $run_reg['reg_date'];

	if (isset($reg_time)) {
		$current_time = time();
		$remain_time = $current_time-$reg_time;

	if ($remain_time > 60) {
			$del_data = mysqli_query($connect, "DELETE FROM users WHERE reg_date = '$reg_time'");

		}
	}

	}


	if (isset($_POST['login'])) {

		$email = mysqli_real_escape_string($connect, $_POST['email']);
		$sess['email'] = $email;
		$password = mysqli_real_escape_string($connect, $_POST['password']);
		$pass = md5($password);
		$vkey = md5(time().'jlorj1270@#$%&^*()');
		$to = $email;
		$sub = "Email verification";
		$msg ="Please confirm your email varification by clicking \r\n";
		$msg .= "<a href='http://localhost/Social-Book/verify.php?vkey=$vkey&email=$email'>Confirm verification</a> \r\n";
		$header = "content-type: text/html";

		if ($email == NULL) {
			$error['email'] = "Email is missing";
		}
		if (!$email == NULL) {
			if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
				$error['emailfilter'] = "Enter a valid email";
			}
		}
		if ($password == NULL) {
			$error['password'] = "Password is missing";
		}
		if (!isset($error)) {
			if (email_exists()) {
				$password_query = mysqli_query($connect, "SELECT password FROM users WHERE email ='$email'");
				$row = mysqli_fetch_assoc($password_query);
				
				if ($pass == $row['password']) {

					$verify_query = mysqli_query($connect, "SELECT * FROM users WHERE verified = 'verified' AND email ='$email'");
					if (mysqli_num_rows($verify_query) == 1) {
						$_SESSION['email'] = $email;

						header('location: home.php');

					}
					else{
						$updatevk = mysqli_query($connect, "UPDATE users SET vkey='$vkey' WHERE email='$email' AND verified='not verified' LIMIT 1");
						if ($updatevk) {
							mail($to, $sub, $msg, $header);
						$verifyerror = "Your email is not verified. please check your Mail. We have send a verification mail to your gmail account";
						}
					}
				}
				else{
					$errorpass = "Password is incorrect";
				}
			}else{
				$erroremail = "Email does not exists please register";
			}
		}
	}

  ?>
<!DOCTYPE html>
<html>
<head>
	<title>login form</title>
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
		<div class="form_header"><h1>Login Form</h1></div>
		<?php 
		
		if (isset($verifyerror)) {
			echo "<p class='error'>" . $verifyerror ."</p>";
		}
		?>
		<form method="POST" action="">
			<label for="email">Email</label><br>
			<input id="email" value="<?php if(isset($sess['email'])){
				echo $sess['email'];
			} ?>" type="email" name="email" pattern="\w{0,15}\w{@}\w{5}\w{.}\w{3}"><br><br>
			<?php if (isset($error['email'])) {
				echo "<div class= 'error'>" . $error['email'] . "</div>" . "</br>";
				}
				if (isset($error['emailfilter'])) {
					echo "<div class= 'error'>" . $error['emailfilter'] . "</div>" . "</br>";
				}
				if (isset($erroremail)) {
					echo "<div class='error'>" . $erroremail ."</div>" . "<br>";
				} ?>
			<label for="password">Password</label><br>
			<input id="password" type="password" name="password"><br><br>
			<?php if (isset($error['password'])) {
				echo "<div class= 'error'>" . $error['password'] . "</div>" . "</br>";
			} 
				if (isset($errorpass)) {
				echo "<div class='error'>" . $errorpass ."</div>" . "<br>";
			}?>
			<input type="submit" name="login" value="SignIn">
			<a href="forgotpass.php">Forgotten Password</a>

		</form><br>
		Don't have an account! Please <a href="register.php">SignUp</a>

		
		
	</div>
</body>
</html>