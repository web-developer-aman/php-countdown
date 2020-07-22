<?php 
	
	session_start();
	require_once("config.php");
	require_once("functions.php");

	if (user_loged_in()) {
		header('location: profile.php');
		die();
	}
	
	
	if (isset($_POST['register'])) {
		
		$fname = mysqli_real_escape_string($connect, $_POST['fname']);
		$sess['fname'] = $fname;
		$lname = mysqli_real_escape_string($connect, $_POST['lname']);
		$sess['lname'] = $lname;
		$u_name = $fname;
		$profile_pic = "profile/default.jpg";
		$cover_pic = "cover/default.jpg";
		$email = mysqli_real_escape_string($connect, $_POST['email']);
		$sess['email']  = $email;
		$password = mysqli_real_escape_string($connect, $_POST['password']);
		$pass = md5($password);
		$Cpassword = mysqli_real_escape_string($connect, $_POST['Cpassword']);
		$reg_date = time();
		$vkey = md5(time().$fname);
		$verification = "not verified";
		$rendomid = rand(1,100000).rand(1,1000000);
		$id = '?id='. $rendomid;

		$secretKey = "6LeIZ90UAAAAAOOt4zwaXvvfE4NubQV3QxffXsLI";
		$responseKey = $_POST['g-recaptcha-response'];
		$userIP = $_SERVER['REMOTE_ADDR'];
		$url = "https://www.google.com/recaptcha/api/siteverify?secret=$secretKey&response=$responseKey&remoteip=$userIP";
		$response = file_get_contents($url);
		$response = json_decode($response);

		$to = $email;
		$sub = "Email verification";
		$msg ="Hello $fname," . "<br/>";
		$msg .="Please confirm your email varification by clicking \r\n";
		$msg .= "<a style='text-decoration:none;' href='http://localhost/Social-Book/verify.php?vkey=$vkey&email=$email'>Confirm verification</a>" . "<br/>";
		$msg .="<p style='color:red;'>" . "You have 6 minutes to verify your email \r\n" . "</p>";
		$header = "From: Social Book \r\n";
		$header .= "content-type: text/html";

			if ($fname == NULL ) {
					$error['fname']= "fist name is missing";
		}
		if (!$fname == NULL) {
			if (strlen($fname) < 4) {
			$error['ferror'] = "first name must be at least 4 characters";
		}
		}
		if ($lname == NULL ) {
					$error['lname']= "last name is missing";
		}
		if ($email == NULL ) {
					$error['email']= "email is missing";
		}
		if (!$email == NULL) {
			if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
				$error['emailfilter'] = "email is not valid";
			}
		}
		if ($password == NULL ) {
					$error['password']= "password is missing";
		}
		if (!$password == NULL) {
			if (strlen($password) < 6) {
				$error['pcharerror'] = "Password must be at least 6 characters";
			}
		}
		if ($Cpassword == NULL ) {
					$error['Cpassword']= "confirm password is missing";
		}
		if (!$Cpassword == NULL) {
			if ($Cpassword != $password) {
			$error['Cpasserror'] = "Password does not match";
		}
		}
		
		
		if (!isset($error)) {
			if ($response->success) {
				if (!email_exists()) {
				
				$mail_success= mail($to, $sub, $msg, $header);

				if ($mail_success) {
					$insert = mysqli_query($connect, "INSERT INTO users (fname, lname, email, password, vkey, verified, user_id, profile_pic, cover_pic, reg_date) VALUES('$fname', '$lname', '$email', '$pass', '$vkey', '$verification', '$id', '$profile_pic', '$cover_pic', '$reg_date')");

					$registersuccess = "Please check your email. We have send a verification mail to your gmail Account.";
					if ($registersuccess) {
						$sess = "";
					}
				}
				else{
					$error['email_verify'] = "Please enter a valid email or open a" ."<a href ='https://mail.google.com'> Gmail Account</a>";
				}
				

			}
			else{
				$registererror = "Email already exist! Please try with another email";
			}
			}
			else{
				$error['invalid_captcha'] = "Invalid captcha please try again";
			}
			
		}
				

	}

	 ?>

<!DOCTYPE html>
<html>
<head>
	<title>registration</title>
	<link rel="stylesheet" type="text/css" href="style.css">
	<script src="https://www.google.com/recaptcha/api.js" async defer></script>
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
	
	<div class="img">
		<div class="container">
		<div class="form_header"><h1>Registration Form</h1></div>
		<?php if (isset($registererror)) {
		echo "<p class='error'>" . $registererror ."</p>";
		}
		if (isset($registersuccess)) {
			echo "<p class='successreg'>" . $registersuccess ."</p>";
		}
		if (isset($error['email_verify'])) {
			echo "<p class='error'>" . $error['email_verify'] ."</p>";
		}
		 ?>
		<form method="post" action="">
		<label for="fname">First_Name</label><br>
		<input id="fname" type="text" value="<?php if(isset($sess['fname'])){
			echo $sess['fname'];
		} ?>" name="fname"><br><br>
		<?php if (isset($error['fname'])) {
		 			echo "<div class= error>" . $error['fname'] . "</div>". "<br>";
		 		}
		 		if (isset($error['ferror'])) {
		 		 	echo "<div class= error>" . $error['ferror'] . "</div>". "<br>";;
		 		 } ?>
		<label for="lname">Last_Name</label><br>
		<input id="lname" type="text" value="<?php if(isset($sess['lname'])){
			echo $sess['lname'];
		} ?>" name="lname"><br><br>
		<?php if (isset($error['lname'])) {
		 			echo "<div class= error>" . $error['lname'] . "</div>". "<br>";
		 		} ?>
		<label for="email">Email</label><br>
		<input id="email" type="email" value="<?php if(isset($sess['email'])){
			echo $sess['email'];
		} ?>" name="email"><br><br>

		<?php if (isset($error['email'])) {
		 			echo "<div class= error>" . $error['email'] . "</div>". "<br>";
		 		}
		 		if (isset($error['emailfilter'])) {
		 		 	echo "<div class= error>" . $error['emailfilter'] . "</div>". "<br>";
		 		 } ?>
		<label for="password">Password</label><br>
		<input id="password" type="password" name="password"><br><br>
		<?php if (isset($error['password'])) {
		 			echo "<div class= error>" . $error['password'] . "</div>". "<br>";
		 		}
		 		if (isset($error['pcharerror'])) {
		 			echo "<div class= error>" . $error['pcharerror'] . "</div>". "<br>";
		 		}
		 		 ?>
		 <label for="Cpassword"> Confirm Password</label><br>
		<input id="Cpassword" type="password" name="Cpassword"><br><br>
		<?php if (isset($error['Cpassword'])) {
		 			echo "<div class= error>" . $error['Cpassword'] . "</div>". "<br>";
		 		}
		 		if (isset($error['Cpasserror'])) {
		 			echo "<div class= error>" . $error['Cpasserror'] . "</div>". "<br>";
		 		}
		 		 ?>

		<div class="g-recaptcha" data-sitekey="6LeIZ90UAAAAAN4E3nQttd4Gzp8x10jvi9XNe6z-"></div>
		<?php 
				if (isset($error['invalid_captcha'])) {
					echo "<p class='error'>" . $error['invalid_captcha'] ."</p>";
				}
			 ?>
		<input type="submit" name="register" value="SignUp">
	</form>
	Already have an account please <a href="login.php"> SignIn </a>
	
	</div>
	</div>
	
</body>
</html>