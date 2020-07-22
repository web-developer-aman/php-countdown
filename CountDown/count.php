<?php 

	
		 		date_default_timezone_set('Asia/Dhaka');
		 		$now = new DateTime();

		 		$selected_date = new DateTime("04-07-2021 7:33pm");

		 		if ($now > $selected_date) {
		 			die('<h1>' . 'The Event Start' . '</h1>');
		 		}else{
		 			$intervel = $selected_date->diff($now);	

		 		}
		 		
?>

		 		<div class="Cdown">
		 			<h1>Date <?php echo date("d-m-y") . "<br>" . "Time " . date("h:i:sa") . " (Dhaka)";?></h1>
		 		<h2>COUNT DOWN</h2>
		 		
		 		<table>

		 			<thead>
		 				<tr>
		 					<th><?php  echo $intervel->format("%a");?></th>
		 					<th><?php  echo $intervel->format("%h");?></th>
		 					<th><?php  echo $intervel->format("%i");?></th>
		 					<th><?php  echo $intervel->format("%s");?></th>
		 					
		 				</tr>
		 				
		 			</thead>
		 			<tbody>

		 				<tr>
		 					<td>Days</td>
		 					<td>Hours</td>
		 					<td>Minutes</td>
		 					<td>Seconds</td>
		 				</tr>

		 			</tbody>
		 		</table>
		 		</div>


