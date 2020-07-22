<?php 
	require_once('functions.php');
	if (!user_loged_in()) {
		header('location: login.php');
		die();
	}
 ?>

<nav class="navbar navbar-inverse navbar-fixed-top">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="home.php">Home</a>

    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav">
      	<?php

      		$user = $_SESSION['email'];
      		$get_user = mysqli_query($connect, "SELECT * FROM users WHERE email ='$user'");
      		$row = mysqli_fetch_assoc($get_user);
      		$user_id = $row['user_id'];
          $fname = $row['fname'];
          $lname = $row['lname'];
          $profile_pic = $row['profile_pic'];
          $cover_pic = $row['cover_pic'];
          $email = $row['email'];
          $password = $row['password'];
          $reg_date = $row['reg_date'];
          $user_post = mysqli_query($connect, "SELECT * FROM posts WHERE user_id= '$user_id'");
          $post = mysqli_num_rows($user_post);
	
      	?>
        

        <li><a href="profile.php<?php echo $user_id;?>"><?php echo "<img src='$profile_pic' class='img-circle' width='25px' height='25px'>";?>&nbsp&nbsp<?php echo $fname;?></a></li>
        <li class='dropdown'>
                  <a id="users" href='#' class='dropdown-toggle' data-toggle='dropdown' role='button' aria-haspopup='true' aria-expended='false' ><span> <i class='fas fa-user-friends'style='font-size:18px'> </i></span>
                  <span class='caret'></span></a>
                  <ul class='dropdown-menu' style='width:500px;'>
                  <div class='row'>
                    <div class='col-sm-12'>
                      <li><input type='text' id="find_friend" placeholder='Find People' style='width:80%;margin-left:10%;padding:5px 15px; border-radius:5px;'></li><br>
                    </div>
                  </div>              
                    <div id="get_friend"></div>
                    
                    
                  </ul>
          </li>
         
  
        <li class='dropdown'>
                  <a id="<?=$user_id?>" href='#' class='dropdown-toggle chat_user' data-toggle='dropdown' role='button' aria-haspopup='true' aria-expended='false' ><i class='fab fa-facebook-messenger'style='font-size:18px'> </i>
                  </a>
                  <ul class='dropdown-menu' style='width:500px;'>
                    
                      <div id="c_users"></div>   
                             
                  </ul>
          </li>


        <?php
          echo "

            <li class='dropdown'>
              <a href='#' class='dropdown-toggle' data-toggle='dropdown' role='button' aria-haspopup='true' aria-expended='false' ><span> <i class='fa fa-user'style='font-size:18px'> </i></span>
              <span class='caret'></span></a>
              <ul class='dropdown-menu'>
                <li>
                  <a href='#'>My Post &nbsp<span class='badge badge-secondary'>$post</span></a>
                </li>
                <li>
                  <a href='edit_profiel.php$user_id'>Edit Account</a>
                </li>
                <li role='separator' class='divider'></li>
                <li>
                  <a href='secureout.php'>Log Out</a>
                </li>
              </ul>
          </li>

          ";

        ?>

      </ul>

      <ul class="nav navbar-nav navbar-right">

          <li class="dropdown">
            <form action="result.php" method="GET" class="navbar-form navbar-left">
              
              <div class="form-group">
                <input type="text" class="form-control" placeholder="Search" name="user_query">
              </div>
              <button type="submit" class="btn btn-info" name="search">Search</button>
            </form>
          </li>
        
      </ul>
      
    </div>
  </div>
</nav>
