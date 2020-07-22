<?php 
	
	session_start();
	require_once('functions.php');
	require_once('config.php');
	if (!admin_loged_in()) {
		header('location: index.php');
	}
	
 ?>
 
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Admin Panel</title>
	<link rel="stylesheet" href="admin.css">
</head>
<body>
	<div class="container">
		<div class="left_side_bar">
			<ul>
				<li><a href="addpages.php">Add Pages</a></li>
				<li><a href="allpages.php">All Pages</a></li>
				<li><a href="users.php">Users</a></li>
				<li><a href="sendmail.php">Send Mail</a></li>
			</ul>
		</div>
		<div class="right_side_bar"></div>
	</div>
</body>
</html>