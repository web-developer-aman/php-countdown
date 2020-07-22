<?php 
	session_start();
	require_once('functions.php');
	include('include/header.php');
	if (!user_loged_in()) {
		header('location: login.php');
		die();
	}

	if (isset($_POST['update_cover'])) {
		$u_cover       = $_FILES['u_cover']['name'];
        $temp_cover  = $_FILES['u_cover']['tmp_name'];  
        if(isset($u_cover) and !empty($u_cover)){
            $c_location = 'cover/' . $u_cover;      
            if(move_uploaded_file($temp_cover, $c_location)){
                mysqli_query($connect, "UPDATE users SET cover_pic='$c_location' WHERE user_id='$user_id'");
                echo "<script>window.open('profile.php$user_id', '_self')</script>";

            }
        }
	}

	if (isset($_POST['update_profile'])) {
		$u_profile       = $_FILES['u_profile']['name'];
        $temp_profile  = $_FILES['u_profile']['tmp_name'];  
        if(isset($u_profile) and !empty($u_profile)){
            $p_location = 'profile/' . $u_profile;      
            if(move_uploaded_file($temp_profile, $p_location)){
                mysqli_query($connect, "UPDATE users SET profile_pic='$p_location' WHERE user_id='$user_id'");
                echo "<script>window.open('profile.php$user_id', '_self')</script>";

            }
        }
	}
		
	if (isset($_GET['id'])) {
					$u_id = "?id=" . $_GET['id'];
					$get_user = mysqli_query($connect, "SELECT * FROM users WHERE user_id ='$u_id'");
      				$row = mysqli_fetch_assoc($get_user);
          			$u_fname = $row['fname'];
          			$u_lname = $row['lname'];
          			$u_profile_pic = $row['profile_pic'];
          			$u_cover_pic = $row['cover_pic'];
          			$u_email = $row['email'];
          			$u_password = $row['password'];
          			$u_reg_date = $row['reg_date'];

					
	}else{
		header('location: profile.php' . $user_id);
	}
				

 ?>
 
<!DOCTYPE html>
<html>
<head>

	
	<title><?php echo $fname;?></title>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

	<!-- jQuery library -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

	<!-- Latest compiled JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js">
	</script>
	<script src='https://kit.fontawesome.com/a076d05399.js'></script>
	<link rel="stylesheet" type="text/css" href="style.css">
	<script src="script.js"></script>
	
</head>
<style>
	body{
		background: #173F5F;
	}
	#about{
		background: #E8F0FE;
	}
	
</style>

<body style="padding-top: 50px;">
	
	<div class="row" id="c_row"></div>

	<div class="row">
		<div class="col-sm-2"></div>
	
	<div class="col-sm-8">

		<?php 
			if ($u_id==$user_id) {
				echo "		
			<div>
				<div>
					<img src='$cover_pic' class='img-rounded' alt='cover_pic' id='cover_img'>
				</div>
				<form action='profile.php$user_id' method='POST' accept-charset='utf-8' enctype='multipart/form-data'>
					<ul class='nav pull-left' style='position:absolute; top:10px; left:40px;'>
						<li class='dropdown'>
		              <button class='dropdown-toggle btn btn-default'data-toggle='dropdown'>Change Cover</button>
		              <div class='dropdown-menu' style='background:rgba(0, 0, 0, 0.4);'>
						<center>
							<label id='update_cover' class='btn btn-default' style='background:transparent;'>Select Cover
							<input type='file' name='u_cover' size='60' />
							</label><br>
							<button name='update_cover' class='btn btn-default' style='background:transparent; color:#fff;'>Update Cover</button>
							

						</center>
		              </div>
              
                		<li>
					</ul>		
				</form>
			</div>
			<div>
				
				<div id='profile_img'>
					<img src='$profile_pic' class='img-circle' width='180px' height='185px style='position:relative;' alt='profile_pic'>
					<form action='profile.php$user_id' method='POST' accept-charset='utf-8' enctype='multipart/form-data'>
					<label id='update_profile' class='btn btn-info'>
					<div>
						<span class='glyphicon glyphicon-camera'></span>
					</div>
					Select Profile
							<input type='file' name='u_profile' size='60' />
					</label>
							
				</div>
				<button id='button_profile' name='update_profile' class='btn btn-info'>Update Profile</button>
					</form>
					
					<div class='col-sm-2'>
						<h3 id='u_prof_name'>$fname</h3>
					</div>					
			</div>
								
								<div class='row'>
								<div class='col-sm-12' id='p_btn_container'>
									
									<ul style='background:#fff;margin-top:-30px;'>
										<li data-toggle='collapse' data-target='#View'>Timeline</li>
										<li data-toggle='collapse' data-target='#View'>Photos</li>
										<li data-toggle='modal' data-target='#delete'>Friends</li>
										<li data-toggle='modal' data-target='#editpost_id'>More</li>
									</ul>
																	
								</div></div>
		";
			}else{
				echo "		
			<div>
				<div>
					<img src='$u_cover_pic' class='img-rounded' alt='cover_pic' id='cover_img'>
				</div>
                				
			</div>
			<div>
				
				<div id='profile_img'>
					<img src='$u_profile_pic' class='img-circle' width='180px' height='185px style='position:relative;' alt='profile_pic'>
				</div>
					<div class='col-sm-2'>
						<h3 id='u_prof_name'>$u_fname</h3>
					</div>
	

			</div>			
				
								<div class='row'>
								<div class='col-sm-12' id='p_btn_container'>
									
									<ul style='background:#fff;margin-top:-30px;'>
										<li data-toggle='collapse' data-target='#View'>Timeline</li>
										<li data-toggle='collapse' data-target='#View'>Photos</li>
										<li data-toggle='modal' data-target='#delete'>Friends</li>
										<li class='chat' id='$u_id'>Message</li>
									</ul>
																	
								</div></div>
								";
			}
		 ?>

			
	</div>
	<div class="col-sm-2"></div>
	</div>
	<div class="row">
		<div class="col-sm-2"></div>
		<div class="col-sm-2" id="about">
				 	
			<center><h2><strong>About</strong></h2></center>
			<center><h4><strong><?php echo $fname . " " . $lname; ?></strong></h4></center>
							 
		
		</div>
		<div class="col-sm-6">

			
			<?php 
				
				
				if (isset($_GET['id'])) {
					$user_id = "?id=" . $_GET['id'];

					$get_post = mysqli_query($connect, "SELECT * FROM posts WHERE user_id='$user_id' ORDER BY 1 DESC LIMIT 5");

					while ($row_post = mysqli_fetch_assoc($get_post)) {
						$post_id = $row_post['post_id'];
						$user_id = $row_post['user_id'];
						$post_content = $row_post['post_content'];
						$post_img = $row_post['upload_img'];
						$post_date = $row_post['post_date'];
						

						$get_user = mysqli_query($connect, "SELECT * FROM users WHERE user_id='$user_id' AND post='YES'");
						$row_user = mysqli_fetch_assoc($get_user);

						$u_name = $row_user['fname'];
						$u_profile = $row_user['profile_pic'];



						if ($post_img=="" && strlen($post_content) >= 1) {
				echo "
				
				<div class='row'>
					<div class='col-sm-12' id='posts'><hr>
						<div class='row'  style='padding: 0px 50px; display:flex;'>
							<div class='col-sm-2'>
								<p><img src='$u_profile' alt='profile_pic' class='img-circle' width='50px' height='50px'></p>
							</div>
							<div class='col-sm-10'>
								<h4><a href='profile.php$user_id'>$u_name</a></h4>
								<small>Updated a post on $post_date</small>
							</div>
						</div><br>
							<div class='row' style='padding: 0px 50px;'>
								<div class='col-sm-12'>						
								<p>$post_content</p>
								</div>
							
						</div>
						<br>		
					
			";

				
					echo post_btn();
				
			
			
			}


			if (strlen($post_content) >= 1 && strlen($post_img) >= 1){
				echo "
				<div class='row'>
					
					<div class='col-sm-12' id='posts'><hr>
						<div class='row' style='padding: 0px 50px; display:flex;'>
							<div class='col-sm-2'>
								<img src='$u_profile' alt='profile_pic' class='img-circle' width='50px' height='50px'>
							</div>
							
							<div class='col-sm-10'>
								<h4><a href='profile.php$user_id'>$u_name</a></h4>
								<small>Updated a post on $post_date</small>
							</div>
							
						</div><br>
						<div class='row' style='padding: 0px 50px;'>
								<div class='col-sm-12'>
								<p>$post_content</p>
								</div>
						</div>
						
						<div class='row'>
							<div class='col-sm-12'>
								<img id='post_img' src='$post_img' style='height:auto; max-height:700px; width:100%;'>
							</div>
						</div><br>
					
				
			";

				echo post_btn();
			
			}
			if ($post_content=="" && strlen($post_img) >= 1){
				echo "
				<div class='row'>
					
					<div class='col-sm-12' id='posts'><hr>
						<div class='row' style='padding: 0px 50px; display:flex;'>
							<div class='col-sm-2'>
								<p><img src='$u_profile' alt='profile_pic' class='img-circle' width='50px' height='50px'></p>
							</div>
							<div class='col-sm-10'>
								<h4><a href='profile.php$user_id'>$u_name</a></h4>
								<small>Updated a post on $post_date</small>
							</div>
							
						</div><br>
						
						<div class='row'>
							<div class='col-sm-12'>
								
								<img id='post_img' src='$post_img' style='height:auto; max-height:700px; width:100%;'>
							</div>
						</div><br>
					
				
			";
			
			echo  post_btn();
			
			}
		}
				

					}
				
			 ?>
		</div>
		<div class="col-sm-2"></div>
	</div>
	</div>
</body>
</html>