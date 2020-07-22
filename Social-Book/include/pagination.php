<style>
	.pagination a{
		text-decoration: none;
		padding: 8px 16px;
		color: #fff;
		transition: background-color .3s;
	}
	.pagination a:hover:not(.active){
		background: #fff;
		color:#173F5F;
	}
</style>
<?php 
	
	$query = mysqli_query($connect, "SELECT * FROM posts");
	$total_post = mysqli_num_rows($query);
	$total_page= ceil($total_post / $per_page);

	echo "
		<center>
			<div class='pagination'>
				<a href='home.php?page=1'>First Page</a>
		";
			for ($i=2; $i <$total_page; $i++) { 
				echo "<a href='home.php?page=$i'>$i</a>";
			}
			if ($total_post==0) {
				echo "<a href='home.php?page=1'>Last Page</a>";
			}else{
				echo "<a href='home.php?page=$total_page'>Last Page</a>";
			}
			
	echo "</div></center>";

 ?>