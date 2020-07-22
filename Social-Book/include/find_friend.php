<?php 
      session_start();
      $email= $_SESSION['email'];
      $connect = mysqli_connect("localhost", "root", "", "registerlogin");
      $run_user = mysqli_query($connect,"SELECT * FROM users WHERE email!='$email'");
      
                while ($get_user= mysqli_fetch_assoc($run_user)) {
                  $user_id = $get_user['user_id'];
                  $fname = $get_user['fname'];
                  $lname = $get_user['lname'];
                  $profile_pic = $get_user['profile_pic'];
                  $get_user= "<li>
                          <div class='row'  style='padding: 0px 50px; display:flex;'>
                        <div class='col-sm-2'>
                     <p><img src='$profile_pic' alt='profile_pic' class='img-circle' width='50px' height='50px'></p>
                      </div>
                    <div class='col-sm-10'>
                     <h4><a href='profile.php$user_id'>$fname $lname</a></h4>
                     
                   </div>
                   </div>
                          
                        </li>
                  "; 
                  echo $get_user;               
                }



 ?>
