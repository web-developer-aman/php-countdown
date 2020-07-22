<?php 
	session_start();
	require_once('functions.php');
	require_once('config.php');
	if (admin_loged_in()) {
		header('location: admin.php');
		die('user loged in');
	}

	if (isset($_POST['admin_login'])) {

		define('ADMIN', 'amanuddin');
		define('PASSWORD', '102030');
		$admin = $_POST['admin_name'];
		$password = $_POST['admin_pass'];
		if ($admin == NULL) {
			$error['admin_name'] = "<p class= 'error'>User name is missing</p>";
		}
		if ($password == NULL) {
			$error['admin_pass'] = "<p class= 'error'>Password is missing</p>";
		}
		if (!isset($error)) {
			if (ADMIN == $admin && PASSWORD == $password) {
			$_SESSION['login_users']= "admin login";
			header('location: admin.php');
		}
		else{
			$error['login']= "<p class= 'error'>Username and Password does not match</p>";
		}
		}

	}
 ?>
<!DOCTYPE html>
<html>
<head>
	<title>Admin Login</title>
	<link rel="stylesheet" type="text/css" href="../style.css">
</head>
	<style>
		body{
			background: url('img/bg2.jpg');
			padding: 0;
			margin: 0;
			overflow-x: hidden;
			background-size: cover;
			background-position: fixed;
			left: 0;
			right: 0;
			color: white;		
		}
	</style>
<body>
	<div class="container">
		<h1>Admin Login</h1>
		<form class="admin_form" method="POST" action="">
			<label for="admin">User Name</label><br>
			<input id="admin" type="text" name="admin_name"><br>
			<?php if (isset($error['admin_name'])) {
				echo $error['admin_name'];
			} ?>
			<label for="pass">Password</label><br>
			<input id="pass" type="password" name="admin_pass"><br>
			<?php if (isset($error['admin_pass'])) {
				echo $error['admin_pass'];
			} ?>
			<input type="submit" name="admin_login" value="Login">
			<?php if (isset($error['login'])) {
				echo $error['login'];
			} ?>
		</form>
	</div>
</body>
</html>