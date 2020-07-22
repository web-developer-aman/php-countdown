<?php 

	session_start();
	require_once('functions.php');
	if (!user_loged_in()) {
		header('location: login.php');
		die();
	}
	else{
		unset($_SESSION['email']);
		header('location: login.php');
	}
	
	
	
	 ?>