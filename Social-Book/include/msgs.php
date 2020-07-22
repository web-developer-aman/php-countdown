<?php 


		session_start();
	$user_email = $_SESSION['email'];
	$connect = mysqli_connect("localhost", "root", "", "registerlogin");
	$run_query = mysqli_query($connect, "SELECT * FROM users WHERE email='$user_email'");
	$get_data = mysqli_fetch_assoc($run_query);
	$user_id = $get_data['user_id'];
	$fname = $get_data['fname'];
	$u_profile = $get_data['profile_pic'];
	
 		if (isset($_POST['f_id'])) {
 			$f_id = $_POST['f_id'];
 			

		$run_fid = mysqli_query($connect, "SELECT * FROM users WHERE user_id='$f_id'");
		$get_frnd_data = mysqli_fetch_assoc($run_fid);
		$f_fname = $get_frnd_data['fname'];
		$f_lname = $get_frnd_data['lname'];
		$f_profile = $get_frnd_data['profile_pic'];
		$run_user_chat = mysqli_query($connect, "SELECT * FROM chats WHERE (msgFrom='$user_id' AND msgTo='$f_id') OR (msgTo='$user_id' AND msgFrom='$f_id')");
			while ($get_msgs = mysqli_fetch_assoc($run_user_chat)) {
			$u_from = $get_msgs['msgFrom'];
			$u_to = $get_msgs['msgTo'];
			$umsg = $get_msgs['msg'];
			$msg_time = $get_msgs['sendTime'];

			if ($u_from==$user_id AND $u_to==$f_id) {
				echo  "<p style='text-align:right;'><span id='msg_box' style='background:#4267B2;color:#fff;'>$umsg</span><br></p>";
			}
			if ($u_to==$user_id AND $u_from==$f_id) {
				echo  "<div class='row' style='padding:0;'>
			<div class='col-sm-1'>
				<img src='$f_profile' class='img-circle' width='30px' height='30px' alt='frnd_profile'>
			</div>
			<div class='col-sm-10'>
				
					<p><span id='msg_box' border-radius:50px;'>$umsg</span><br></p>
					<p style='text-align:center;color:#999'><small>$msg_time</small></p>

				
			</div>
			
		</div>";
			}

		}		

 		}

 		
  ?>
