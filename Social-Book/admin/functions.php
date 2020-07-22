<?php 
	
	require_once ('config.php');

	function email_exists(){

		global $email;
		global $connect;
		$query = mysqli_query($connect, "SELECT * FROM users WHERE email='$email'");
		if(mysqli_num_rows($query) == 1) {
			return true;
		}
	}
	
	

	function admin_loged_in(){
		if (isset($_SESSION['login_users'])) {
			return true;
		}
	}
	
 ?>