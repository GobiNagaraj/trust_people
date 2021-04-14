<?php 
	include_once '../../model/db.php';
	$conn = db_connect();

		$userId = $_POST['userId'];
		$postId = $_POST['postId'];
		$registerId = $_POST['registerId'];
		
		$demoCnt = execute_query($conn, "SELECT COUNT(yes_iam) AS yes, COUNT(similar_exp) AS same, COUNT(comments) AS cmt FROM `social_details_tbl` WHERE user_id = '".$userId."' AND post_id = '".$postId."' AND register_id = '".$registerId."'");
		while($demo = mysqli_fetch_assoc($demoCnt)){
			$countofYes 	= 	$demo['yes'];
			$countofSame	=	$demo['same'];
			$countofCmt		=	$demo['cmt'];
		}
?>