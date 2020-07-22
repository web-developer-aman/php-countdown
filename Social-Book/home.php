<?php 
	session_start();
  include('include/header.php');
	require_once('functions.php');
	if (!user_loged_in()) {
		header('location: login.php');
		die();
	}
 ?>
 <!DOCTYPE html>
<html>
<head>
	<?php

          $user = $_SESSION['email'];
          $get_user = mysqli_query($connect, "SELECT * FROM users WHERE email ='$user'");
          $row = mysqli_fetch_assoc($get_user);
          $user_id = $row['user_id'];
          $fname = $row['fname'];
      ?>
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
  h2{
    color: #fff;
  }
  
</style>

<body style="padding-top: 50px;">
  <div id="lol"></div>
	
  <div class="row">
    <div class="col-sm-12" id="insert_post">
      <center>
        <form action="home.php<?php echo "$user_id;"?>" id="f" method="POST" enctype="multipart/form-data">
          <div style='position: relative; overflow: hidden; width: 70%'>
            <textarea class="form-control" name="content" id="content" rows="4" placeholder="What's in your mind?"></textarea>
          <label class="btn btn-warning" id="post_img_btn">Select Image
            <input type="file" name="upload_img">
          </label>
          </div><br>
          <button class="btn btn-success" id="insert_post_btn" name="post">Post</button> 
        </form>
        <?php insertPost();


         ?>
      </center>
    </div>
  </div>
  <div class="row">
    <div class="col-sm-12">
      <center><h2><strong>News Feed</strong></h2></center><br>
      <?php echo get_posts();
           
       ?>
    </div>
  </div>

</body>
</html>