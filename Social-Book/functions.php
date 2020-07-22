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
	

	function user_loged_in(){
		if (isset($_SESSION['email'])) {
			return true;
		}
	}

	function insertPost(){
			global $connect;
			global $user_id;

		if (isset($_POST['post'])) {
			$content = htmlentities($_POST['content']);
			$post_img = $_FILES['upload_img']['name'];
			$temp_post = $_FILES['upload_img']['tmp_name'];
			

			
			if ($post_img == NULL && $content == NULL) {
				echo "<p style='color:red;'>*Please select file or write your post!*</p>";
			}else{
				if (strlen($content) > 250) {
				
				echo "<p style='color:red;'>*Please use 250 or less than 250 words!*</p>";
				exit();
			}else{
				if(isset($post_img) and !empty($post_img)){
				$location = "posts/$post_img";
				move_uploaded_file($temp_post, "$location");
			}else{
				$location = "";
			}
			}
			}

			if (isset($location)) {
				mysqli_query($connect, "INSERT INTO posts (user_id, post_content, upload_img, post_date) VALUES ('$user_id', '$content', '$location', NOW())");
					mysqli_query($connect, "UPDATE users SET post='YES' WHERE user_id='$user_id'");
					echo "<script>window.open('home.php', '_self')</script>";
			}

			
		}
		
	}
	function get_posts(){
		global $post_id;
		global $connect;
		
		$per_page = 4;
		if (isset($_GET['page'])) {
			$page = $_GET['page'];
		}else{
			$page = 1;
		}
		$start_from = ($page-1) * $per_page;
		$get_posts = mysqli_query($connect, "SELECT * FROM posts ORDER BY 1 DESC LIMIT $start_from, $per_page");
		while($row_post = mysqli_fetch_assoc($get_posts)){
			$post_id = $row_post['post_id'];
			$u_id = $row_post['user_id'];
			$content = $row_post['post_content'];
			$upload_img = $row_post['upload_img'];
			$post_date = $row_post['post_date'];

			$users = mysqli_query($connect, "SELECT * FROM users WHERE user_id='$u_id' AND post='YES'");
			$get_user = mysqli_fetch_assoc($users);
			$u_name = $get_user['fname'];
			$u_profile = $get_user['profile_pic'];

			if ($upload_img=="" && strlen($content) >= 1) {
				echo "
				<div class='row'>
					<div class='col-sm-3'></div>
					<div class='col-sm-6'>
						<div class='row'>
							<div class='col-sm-12' id='posts'><hr>
							<div class='row' style='padding:0px 50px;'>
								<div class='col-sm-2'>
								<p><img src='$u_profile' alt='profile_pic' class='img-circle' width='50px' height='50px'></p>
								</div>
								<div class='col-sm-10'>
								<h4><a href='profile.php$u_id'>$u_name</a></h4>
								<small>Updated a post on $post_date</small>
								</div>
							
							</div><br>
						
							<div class='row' style='padding:0px 50px;'>
								<div class='col-sm-12'>		
								<p>$content</p><br>
								</div>
							</div>

								<div class='row'>
									<div class='col-sm-12' id='p_btn_container'>
									
									<ul>
										<li data-toggle='collapse' data-target='#View'><span class='glyphicon glyphicon-thumbs-up'>&nbsp</span>Like</li>
										<li data-toggle='collapse' data-target='#View'><span class='glyphicon glyphicon-comment'>&nbsp</span>Comment</li>												
									</ul>								
									
								</div>
							</div>
							<br>
			
					";				
							
							 sub_comments();
							
							echo "</div>
						<div class='col-sm-3'></div>
					</div>
					<br>";


				
			}

			if (strlen($content) >= 1 && strlen($upload_img) >= 1){
				echo "
				<div class='row'>
					<div class='col-sm-3'></div>
					<div class='col-sm-6'>
						<div class='row'>
							<div class='col-sm-12' id='posts'><hr>
								<div class='row' style='padding:0px 50px;'>
							<div class='col-sm-2'>
								<p><img src='$u_profile' alt='profile_pic' class='img-circle' width='50px' height='50px'></p>
							</div>
							<div class='col-sm-10'>
								<h4><a href='profile.php$u_id'>$u_name</a></h4>
								<p>Updated a post on $post_date</p>
							</div>
							
						</div><br>
						<div class='row' style='padding:0px 50px;'>
							<div class='col-sm-12'>
								<p>$content</p>
							</div>
						</div>
						
						<div class='row'>
							<div class='col-sm-12'>
								<p><img id='post_img' src='$upload_img' style='height:auto; max-height:700px; width:100%;'></p>
								
							</div>
						</div>
							<div class='row'>
								<div class='col-sm-12' id='p_btn_container'>
									
									<ul>
										<li data-toggle='collapse' data-target='#View'><span class='glyphicon glyphicon-thumbs-up'>&nbsp</span>Like</li>
										<li data-toggle='collapse' data-target='#View'><span class='glyphicon glyphicon-comment'>&nbsp</span>Comment</li>												
									</ul>								
									
								</div>
							</div><br>
					
			";
							
						
							echo sub_comments();
							
							echo "</div>
						<div class='col-sm-3'></div>
						</div><br>";

			}


			if ($content=="" && strlen($upload_img) >= 1){
				echo "
				<div class='row'>
					<div class='col-sm-3'></div>
					<div class='col-sm-6'>
						<div class='row'>
							<div class='col-sm-12' id='posts'><hr>
								<div class='row' style='padding:0px 50px;'>
							<div class='col-sm-2'>
								<p><img src='$u_profile' alt='profile_pic' class='img-circle' width='50px' height='50px'></p>
							</div>
							<div class='col-sm-10'>
								<h4><a href='profile.php$u_id'>$u_name</a></h4>
								<small>Updated a post on $post_date</small>
							</div>
							
						</div><br>
						
						<div class='row'>
							<div class='col-sm-12'>
								
								<p><img id='post_img' src='$upload_img' style='height:auto; max-height:700px; width:100%;'></p>
								
							</div>
						</div>
							<div class='row'>
								<div class='col-sm-12' id='p_btn_container'>
									
									<ul>
										<li data-toggle='collapse' data-target='#View'><span class='glyphicon glyphicon-thumbs-up'>&nbsp</span>Like</li>
										<li data-toggle='collapse' data-target='#View'><span class='glyphicon glyphicon-comment'>&nbsp</span>Comment</li>												
									</ul>								
									
								</div>
							</div><br>
							
					
			";
					
					
					echo sub_comments();

					echo "</div>
					<div class='col-sm-3'></div>
				</div><br>
				";

			}


		}

		include('include/pagination.php');
		
		
	}
	
	function delete_post(){
		global $post_id;
		global $connect;
		echo "<div id='delete$post_id' class='modal fade' role='dialog'>
  <div class='modal-dialog'>

    <!-- Modal content-->
    <div class='modal-content'>
      <div class='modal-header'>
        <button type='button' class='close' data-dismiss='modal'>&times;</button>
        <h4 class='modal-title'>Confirm Delete$post_id</h4>
      </div>
      <div class='modal-body'>
        <p>Are you sure want to delete!</p>
      </div>
      <div class='modal-footer'>
     
        	<form action='' method='POST'>
        	
        	<button type='submit' class='btn btn-default' name='delete' value='$post_id'>Ok</button>
        <button type='button' class='btn btn-default' data-dismiss='modal'>Cancel</button>
        	</form>
       
      </div>
    </div>

  </div>
</div>";
		if (isset($_POST['delete'])) {
			$post_id = $_POST['delete'];
		$run_post  = mysqli_query($connect, "SELECT * FROM posts WHERE post_id='$post_id'");
		$row_post = mysqli_fetch_assoc($run_post);
		$post_id = $row_post['post_id'];
		$user_id = $row_post['user_id'];

		$delete_com = mysqli_query($connect, "DELETE FROM comments WHERE post_id='$post_id'");
		$delete_post = mysqli_query($connect, "DELETE FROM posts WHERE post_id='$post_id'");
		if ($delete_post && $delete_com) {

			echo "<script>window.open('profile.php$user_id', '_self')</script>";
		}
		}

		
	}


	function edit_post(){
		global $post_id;
		global $connect;
		global $post_content;
		global $up_content;
		global $up_img;

		echo "<div id='edit$post_id' class='modal fade' role='dialog'>
  <div class='modal-dialog'>

    <!-- Modal content-->
    <div class='modal-content'>
      <div class='modal-header'>
        <button type='button' class='close' data-dismiss='modal'>&times;</button>
        <h4 class='modal-title'>Update Post$post_id</h4>
      </div>
      <div class='modal-body'>
        <form action='' method='POST' enctype='multipart/form-data'>
          <div style='position: relative; overflow: hidden;'>
            <textarea class='form-control' name='up_content' id='content' rows='4'>$post_content</textarea>
          <label class='btn btn-warning' id='post_img_btn'>Change Image
            <input type='file' name='update_img'>
          </label>
          </div><br> 
 
      </div>
      <div class='modal-footer'>
        	
        	<button type='submit' class='btn btn-default' name='edit' value='$post_id'>Update</button>
        <button type='button' class='btn btn-default' data-dismiss='modal'>Cancel</button>
        	</form>
       
      </div>
    </div>

  </div>
</div>";
		if (isset($_POST['edit'])) {
			$post_id = $_POST['edit'];
			$run_post = mysqli_query($connect, "SELECT * FROM posts WHERE post_id='$post_id'");
			$row_post = mysqli_fetch_assoc($run_post);
			$get_img = $row_post['upload_img'];
			$user_id = $row_post['user_id'];
			$up_content = htmlentities($_POST['up_content']);
			$up_img = $_FILES['update_img']['name'];
			$up_post = $_FILES['update_img']['tmp_name'];

			if (strlen($up_content) > 250) {
				echo  "<script>alert('Please use 250 or less than 250 words!')</script>";
				echo  "<script>window.open('profile.php, '_self')</script>";
				exit();
			}else{
				if(isset($up_img) and !empty($up_img)){
				$location = "posts/$up_img";
				move_uploaded_file($up_post, "$location");
			}else{
				$location = $get_img;
			}
			if (isset($location)) {
			
			mysqli_query($connect, "UPDATE posts SET post_content='$up_content', upload_img='$location', post_date=NOW() WHERE post_id='$post_id'");
			echo "<script>window.open('profile.php$user_id', '_self')</script>";
		}
		}
	}

		
}
	

	function sub_comments(){
		global $profile_pic;
		global $connect;
		global $user_id;
		global $fname;
		global $post_id;

		echo "
			<div id='get_post$post_id' class='comments'></div>
			<div class='row' style='padding:0 50px;' >
				<div class='col-sm-12'>
					<div>
						<img src='$profile_pic' class='img-circle' width='30px' height='30px' alt='profile_pic'>
					
						<form action='' method='POST' enctype='multipart/form-data' id='com_form'>
						<input type='text' class='form-control up_com' name='up_com$post_id' id='up_com$post_id'>
						<button type='submit' name='sub_com$post_id' id='sub_com$post_id' class='sub_com'><span class='glyphicon glyphicon-triangle-right' style='font-size:30px;'></span></button>
					</form>
					</div>
					
				</div>
				
				
			</div>
			</div></div><br>
			<script>
		$(document).ready(function(){
			var p_id = $post_id;
			setInterval(function(){ 
				$.ajax({
						url: 'comments.php',
						method: 'POST',
						data:{
							get_com: p_id
						},
						datatype: 'text',
						success: function(com){
							$('#get_post$post_id').html(com);
						}

			});

				}, 500);
			
			$('#sub_com$post_id').click(function(){
				var comment= $('#up_com$post_id').val();
				

				$.ajax({
						url: 'comments.php',
						method: 'POST',
						data:{
							comment: comment,
							p_id: p_id
						},
						datatype: 'text',
						success: function(data){

							$('#up_com$post_id').val('');
						}

			});
				return false;
				
			});

		});
	</script>
		";

			
		
		
	}


	function post_btn(){
		global $connect;
		global $post_id;

		if (isset($_GET['id'])) {
					$user_id = "?id=" . $_GET['id'];
					$run_user = mysqli_query($connect, "SELECT email FROM users WHERE user_id='$user_id'");
					$get_user = mysqli_fetch_assoc($run_user);
					$user_email = $get_user['email'];

					$user= $_SESSION['email'];
					$run_u= mysqli_query($connect, "SELECT * FROM users WHERE email='$user'");
					$get_u = mysqli_fetch_assoc($run_u);

					$u_id = $get_u['user_id'];
					$u_email = $get_u['email'];

					if ($user_email != $u_email) {
						echo "<div class='row'>
								<div class='col-sm-12' id='p_btn_container'>
									
									<ul>
										<li data-toggle='collapse' data-target='#View'><span class='glyphicon glyphicon-thumbs-up'>&nbsp</span>Like</li>
										<li data-toggle='collapse' data-target='#View'><span class='glyphicon glyphicon-comment'>&nbsp</span>Comment</li>												
									</ul>								
									
								</div></div><br>";
								echo sub_comments();
					
					}else{
						echo "<div class='row'>
								<div class='col-sm-12' id='p_btn_container'>
									
									<ul>
										<li data-toggle='collapse' data-target='#View'><span class='glyphicon glyphicon-thumbs-up'>&nbsp</span>Like</li>
										<li data-toggle='collapse' data-target='#View'><span class='glyphicon glyphicon-comment'>&nbsp</span>Comment</li>
										<li data-toggle='modal' data-target='#delete$post_id'><span class='glyphicon glyphicon-trash'>&nbsp</span>Delete</li>
										<li data-toggle='modal' data-target='#edit$post_id'><span  class='glyphicon glyphicon-edit'>&nbsp</span>Edit</li>
									</ul>
																	
								</div></div>
								<br>";
								
								echo sub_comments();
							
							
							echo delete_post();
							echo edit_post();
							
								
					}

				}
				
	}
	
 ?>
 
