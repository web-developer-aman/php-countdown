<?php 

	session_start();
	$user_email = $_SESSION['email'];
	$connect = mysqli_connect("localhost", "root", "", "registerlogin");
	$run_query = mysqli_query($connect, "SELECT * FROM users WHERE email='$user_email'");
	$get_data = mysqli_fetch_assoc($run_query);
	$user_id = $get_data['user_id'];
	$fname = $get_data['fname'];
	$u_profile = $get_data['profile_pic'];

	if (isset($_POST['friend_id'])) {
		$frnd_id = $_POST['friend_id'];
		$run_fid = mysqli_query($connect, "SELECT * FROM users WHERE user_id='$frnd_id'");
		$get_fdata = mysqli_fetch_assoc($run_fid);
		$frnd_fname = $get_fdata['fname'];
		$frnd_lname = $get_fdata['lname'];
		$frnd_profile = $get_fdata['profile_pic'];
		

	?>
		
			
			<div class="col-md-4 col-md-offset-6" id="cbox">
				<li>
                      <div class='row toggle-chat-box'  style='padding-left: 20px; display:flex; background: #4267B2; padding-top: 5px; '>
                       <div class='col-sm-2'>
                     <p><img src='<?php echo $frnd_profile;?>' alt='frnd profile' class='img-circle' width='50px' height='50px'></p>
                      </div>
                    <div class='col-sm-8'>
                     <h4><a href='profile.php<?php echo $frnd_id;?>' style="color: #fff"><?php echo $frnd_fname . "&nbsp" . $frnd_lname?></a></h4>   
                   </div>
						
						<div class='col-sm-2'>
					<i class="fa fa-minus" aria-hidden="true" style="margin-top: 10px;">&nbsp&nbsp</i>
                     <i class="fa fa-times hide-chat-box" aria-hidden="true" style="margin-top: 10px;"></i>
                     
                   </div>
                   </div>
                       
               </li>
					
				<li>
					<div id="msgs"></div>
				</li>

              

				
		<li>
               <div class='row'  style='display:flex; padding-top: 10px;border-top: 1px solid #bbb;'>
                       <div class='col-sm-1'>
                     <p><img src='<?php echo $u_profile ?>' class='img-circle' width='30px' height='30px' alt='profile_pic'></p>
                      </div>
                    <div class='col-sm-11'>
                     <form action='' method='POST' enctype='multipart/form-data' id=''>
						<input id="c_msg" type='text' name='' placeholder="Type something" style="border:none;color: #555;">
						<input type="hidden" id="user_id" value="<?php echo $user_id ?>">
						<input type="hidden" id="frnd_id" value="<?php echo $frnd_id ?>">
						<button type='submit' name='' id='sub_msg' class='' style="display: none;"></button>
					</form>   
                   </div>
						
                   </div>       
                       
         </li>


		</div>
		
					
				
	
	<?php } ?>

<?php 
	$connect = mysqli_connect("localhost", "root", "", "registerlogin");
	if (isset($_POST['c_msg'])) {
		$c_msg = $_POST['c_msg'];
		$u_id = $_POST['u_id'];
		$frnd_id = $_POST['frnd_id'];

		if ($c_msg==NULL) {
				echo "";

			}else{
				$send_msg =mysqli_query($connect, "INSERT INTO chats (msgFrom, msgTo, msg, sendTime) VALUES ('$u_id', '$frnd_id', '$c_msg', NOW())");			
			}
	}
 ?>
<?php 
if (isset($_POST['user_id'])) {
 			$cu_id = $_POST['user_id'];

 			$run_cuser = mysqli_query($connect,"SELECT * FROM users WHERE user_id!='$cu_id'");
 			while ($get_cuser = mysqli_fetch_assoc($run_cuser)) {
 				$cuser_id = $get_cuser['user_id'];
                $cfname = $get_cuser['fname'];
                $clname = $get_cuser['lname'];
                $cprofile_pic = $get_cuser['profile_pic'];
                $cget_user= "<li>
                          <div class='row'  style='padding: 0px 50px; display:flex;'>
                        <div class='col-sm-2'>
                     <p><img src='$cprofile_pic' alt='profile_pic' class='img-circle' width='50px' height='50px'></p>
                      </div>
                    <div class='col-sm-10'>
                     <h4 class='chat' id='$cuser_id'>$cfname $clname</h4>
                     
                   </div>
                   </div>
                          
                        </li>
                  "; 
                  echo $cget_user;

 			}
 			
 		}
 ?>
<script src=".\script.js"></script>
