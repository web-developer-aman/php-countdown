


<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Count Down</title>
	<link rel="stylesheet" href="">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<style>

		table{
			
			width: 100%;

		}
		table th{

			border-radius: 5px;
			background: #fff;
			color: #173F5F;
			font-size: 50px;
			width: 25%;
			padding: 5px 20px;

		}

		table td{
			width: 25%;
			text-align: center;
			font-size: 25px;
			border-radius: 5px;
			padding: 5px 20px;
			color: #fff;
		}

		h2 {
			font-size: 35px;
			font-weight: normal;
		}

		h1{
			font-size: 50px;
			font-weight: normal;
			color:#fff;
		}

		.Cdown{
			background: #002948;
			color:#fff;
			padding: 20px;
			width: 50%;
			margin-left: 20%;
			border-radius: 5px;
			text-align: center;
		}

		body{
			background: #173F5F;
		}

	</style>
</head>
<body>
	<div id="timer"></div>

	<script>
		jQuery(document).ready(function(){

			var time = "start";

		 	 	setInterval(function(){
				$.ajax({
					url: "count.php",
					method: "post",
					data: {
						timer: time
					},
					success: function(time){
						
						$('#timer').html(time);
					}
				});	

			},5);

		 	 });
	</script>
</body>
</html>