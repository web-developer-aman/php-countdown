<?php 
	
	session_start();
	require_once('config.php');
	require_once('functions.php');
	if (!admin_loged_in()) {
		header('location: index.php');
	}
	if (isset($_POST['send_mail'])) {
		$sub = $_POST['sub'];
		$head = $_POST['header'];
		$msg = $_POST['msg'];

		$name       = $_FILES['tmpt_file']['name'];
        $temp_name  = $_FILES['tmpt_file']['tmp_name'];  
        if(isset($name) and !empty($name)){
            $location = 'templete/';      
            move_uploaded_file($temp_name, $location.$name);
            
        } 

		if ($name) {

			$tmptmsg ='templete/'.$name;
		}else{
			$tmptmsg ="";
		}
		if ($sub == NULL) {
			$error['sub'] = "<p class='error'>Please enter your mail sub</p>";
		}
		if ($head == NULL) {
			$error['header'] = "<p class='error'>Please enter your mail header</p>";
		}
		if ($name == NULL && $msg == NULL) {
			$error['tmpt_file'] = "<p class='error'>Please choose your templete file</p>";
		}
		if($msg == NULL && $name == NULL){
			$error['msg'] = "<p class='error'>Please enter your mail message</p>";
		}
		if (!isset($error)) {
				if (!empty(isset($_POST['email']))) {
					foreach ($_POST['email'] as $email) {

				$to = $email;
				$subject = $sub;
				$headers = "From: " . "$head" . "\r\n";
				$headers .= "Reply-To: ". "noreply@gmail.com" . "\r\n";
				$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
				
				
				$message = $tmptmsg;
				$message .= $msg;

				
				$send = mail($to, $subject, $message, $headers);
				if ($send) {
					$send_success = "<p>Message send successfull</p>";
				}else{
					$error['send_fail'] = "<p>Message send fail</p>";
				}

					}
				}
				else{
					$error['user'] = "Please select an user whos you want to send mail";
				}
									
			
				
				


	
				
			
			
	
		
	}
	}
	
	
 ?>

 <!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Admin Panel</title>
	<link rel="stylesheet" href="admin.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){
		$("#selectAll").click(function(){
		if($(this).is(":checked")){
		$(".checkItem").prop('checked',true);
		}
		else{
			$(".checkItem").prop('checked',false);
		}
		
	});
	});
	</script>
</head>
<body>
	
	<div class="container">
		
		<div class="left_side_bar">
			<ul>
				<li><a href="addpages.php">Add Pages</a></li>
				<li><a href="allpages.php">All Pages</a></li>
				<li><a href="users.php">Users</a></li>
				<li><a href="sendmail.php">Send Mail</a></li>
			</ul>
		</div>
		<div class="right_side_bar">
	

			<div class="mail">
				<h1 class="table_heading">Send Mail To Your Users</h1>
				<?php 
				if (isset($send_success)) {
					echo $send_success;
				}
				if (isset($error['send_fail'])) {
					echo $error['send_fail'];
				}
				if (isset($error['db_error'])) {
					echo $error['db_error'];
				}
				 ?>
			<form class="mail_form" method="POST" action="" enctype="multipart/form-data">

			<div class="email_table">
			
			
			<table>
			<tr>
				<th><input id="selectAll" type="checkbox"></th>
				<th>First Name</th>
				<th>Last Name</th>
				<th>Email</th>
			</tr>

				<?php 

					$query = mysqli_query($connect, "SELECT * FROM users");
					while ($row = mysqli_fetch_assoc($query)) : ?>
						
					<tr>
						<td><input type="checkbox" name= "email[]" class="checkItem" value="<?= $row['email']?>" ></td>	
						<td><?php echo $row['fname']; ?></td>
						<td><?php echo $row['lname']; ?></td>
						<td><?php echo $row['email']; ?></td>
						
					</tr>

				<?php endwhile; ?>
		</table>
		<h3 style="color:red;"><?php if (isset($error['user'])) {
			echo $error['user'];
		}; ?></h3>
		<p><a href="adminlogout.php">Logout</a></p>
		</div><br><br>

			<input type="text" name="sub" placeholder="Enter your mail subject"><br><br>
			<?php if (isset($error['sub'])) {
				echo $error['sub'];
			} ?>
			<input type="text" name="header" placeholder="Enter your mail header"><br><br>
			<?php if (isset($error['header'])) {
				echo $error['header'];
			} ?>
			<input type="file" name="tmpt_file"><br><br>
			<?php if (isset($error['tmpt_file'])) {
				echo $error['tmpt_file'];
			} ?>
			<textarea placeholder="Enter your mail message" name="msg" id="" cols="30" rows="10"></textarea><br><br>
			<?php if (isset($error['msg'])) {
				echo $error['msg'];
			} ?>
			<input type="submit" name="send_mail" value="Send mail">
			
		</form>
			</div>
			
		</div>
	</div>
</body>
</html>