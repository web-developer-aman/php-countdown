
		
		jQuery(document).ready(function(){

			$(".chat_user").click(function(){
				var user_id = $(this).attr("id");
	
				$.ajax({
					url: "include/chat.php",
					method: "post",
					data: {
						user_id: user_id
					},
					success: function(Cuser){
					
						$("#c_users").html(Cuser);
					}
				});
			});
		

			$(".toggle-chat-box").click(function(){
				$("#c_row").toggleClass("toggle_tray");		
      			
  			});


			$(".hide-chat-box").click(function(){
				$("#c_row").html();

			});
			$(".chat").click(function(){
				$("#c_row").show();

			});


			$(".chat").click(function(){

				var f_id = $(this).attr('id');

				
					$.ajax({
					url: "include/chat.php",
					method: "post",
					data:{
						friend_id: f_id
					},
					success: function(cbox){
						setTimeout(function(){
					$("#msgs").scrollTop($(document).height());
					},500);

						$('#c_row').html(cbox);
					}
				});	

			setInterval(function(){
				$.ajax({
					url: "include/msgs.php",
					method: "post",
					data:{
						f_id: f_id
					},
					success: function(msg){
						
						$('#msgs').html(msg);
					}
				});	

			},500);

		
				return false;
			});


			$("#sub_msg").click(function(){
			setTimeout(function(){
				$("#msgs").scrollTop($(document).height());
			},500);
			 

				var c_msg = $("#c_msg").val();
				var u_id = $("#user_id").val();
				var frnd_id = $("#frnd_id").val();

					$.ajax({
					url: "include/chat.php",
					method: "post",
					data:{
						c_msg: c_msg,
						u_id: u_id,
						frnd_id: frnd_id
					},
					success: function(data){
						$("#c_msg").val('');
					}
				});


				return false;
			});
			

			$("#users").click(function(){

				$.ajax({
						url: "include/find_friend.php",
						method: "get",
						success: function(query){
							$('#get_friend').html(query);
						}


			});

			});

		 
	

 			$("#find_friend").on("keyup", function() {
   		 var value = $(this).val().toLowerCase();
   		 $("#get_friend li").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
  		  });
 		 });



	});
			
	


