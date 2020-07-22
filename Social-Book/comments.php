<?php 
	session_start();

	$connect = mysqli_connect("localhost", "root", "", "registerlogin");
	$user = $_SESSION['email'];
      		$get_user = mysqli_query($connect, "SELECT * FROM users WHERE email ='$user'");
      		$row = mysqli_fetch_assoc($get_user);
      		$user_id = $row['user_id'];
      		$fname = $row['fname'];

	
		if (isset($_POST['p_id'])) {
		
			$p_id =$_POST['p_id'];
			$com = $_POST['comment'];
			
			if ($com==NULL) {
				echo "";

			}else{
				$send_comment =mysqli_query($connect, "INSERT INTO comments (post_id, user_id, author_name, comments, com_time) VALUES ('$p_id', '$user_id', '$fname', '$com', NOW())");			
			}
			
	}



	if (isset($_POST['get_com'])) {
		$post_id = $_POST['get_com'];

		$run_comments = mysqli_query($connect, "SELECT * FROM comments WHERE post_id='$post_id' ORDER BY 1 DESC");
		while ($get_comments = mysqli_fetch_assoc($run_comments)) {
		$author_id = $get_comments['user_id'];
		$author_name = $get_comments['author_name'];
		$author_comments = $get_comments['comments'];
		$com_time = $get_comments['com_time'];
		$run_user= mysqli_query($connect,"SELECT profile_pic FROM users WHERE user_id='$author_id'");
		$get_id = mysqli_fetch_assoc($run_user);
		$author_profile = $get_id['profile_pic'];


		if (strlen($author_comments) > 50 ) {
	
			echo "<div class='row' style='padding:0 50px;'>
			<div class='col-sm-1'>
				<img src='$author_profile' class='img-circle' width='30px' height='30px' alt='profile_pic'>
			</div>
			<div class='col-sm-10'>
				
					<p id='com_box'><a href='profile.php$author_id'>$author_name </a>$author_comments</p>
					<p>$com_time</p>

				
			</div>
			<div col-sm-1></div>
		</div><br>";
		}else{
			echo "<div class='row' style='padding:0 50px;'>
			<div class='col-sm-1'>
				<img src='$author_profile' class='img-circle' width='30px' height='30px' alt='profile_pic'>
			</div>
			<div class='col-sm-10'>
				
					<span id='com_box'><a href='profile.php$author_id'>$author_name </a>$author_comments</span>
					<p style='margin:10px 0px 0px 10px;'><small>$com_time</small></p>
				
			</div>
			<div col-sm-1></div>
		</div><br>";
		}
		}
	}
	
   ?>