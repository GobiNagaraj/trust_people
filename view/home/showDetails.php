<?php 
	include_once '../../model/db.php';
	$conn = db_connect();

	$sql = execute_query($conn, "SELECT COUNT(post_id) AS cntPost FROM `post_details_tbl` WHERE status = '1'");
	while($row = mysqli_fetch_assoc($sql)){
		$prevCount = $row['cntPost'];
	}

	$nextCount = $prevCount + 1;

	if($nextCount != $prevCount){
		
	}

?>