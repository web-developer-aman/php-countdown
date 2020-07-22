<?php 
	
	session_start();
	unset($_SESSION['login_users']);
	header('location: index.php.');
	
	 ?>