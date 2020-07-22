<?php 
	
	session_start();
	require_once('functions.php');
	require_once('config.php');
	if (!admin_loged_in()) {
		header('location: index.php');
	}

	if (isset($_POST['delete'])) {
		if (!empty(isset($_POST['email']))) {
			foreach ($_POST['email'] as $delete) {
				$email_query = mysqli_query($connect, "DELETE FROM users WHERE email= '$delete'");
			}
		}
	}
	
 ?>
<!DOCTYPE html>
<html>
<head>
	<title>Users</title>
	<link rel="stylesheet" type="text/css" href="admin.css">
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
			<div class="users_table">
			<form action="" method="POST">
				<h1 class="table_heading">Users Information table</h1>
				<input type="submit" name="delete" value="Delete" onclick="return confirm('Are you sure want to delete!')">
			<table>
			<tr>
				<th><input id="selectAll" type="checkbox"></th>
				<th>First Name</th>
				<th>Last Name</th>
				<th>Email</th>
				<th>Password</th>
			</tr>

				<?php 

					$query = mysqli_query($connect, "SELECT * FROM users");
					while ($row = $query->fetch_object()) : ?>
						
					<tr>
						<td><input type="checkbox" name="email[]" class="checkItem" value="<?= $row->email?>"></td>	
						<td><?php echo $row->fname; ?></td>
						<td><?php echo $row->lname; ?></td>
						<td><?php echo $row->email; ?></td>
						<td><?php echo $row->password; ?></td>
					</tr>

				<?php endwhile; ?>
		</table>
			</form>
		<p><a href="adminlogout.php">Logout</a></p>
		</div>
		</div>
	</div>
	
		
	
</body>
</html>