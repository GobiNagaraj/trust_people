<?php 
	include_once '../model/db.php';

	$conn = db_connect();

	$array = array();
	if(isset($_POST['searchContent']))
	{
		//$userId = $_POST['userId'];
		$search = $_POST['searchContent'];

		$sql = "SELECT R.`register_id` AS registerId, R.`first_name` AS firstName, R.`last_name` AS lastName, R.`user_image` AS userImage, P.`post_id` AS postId, P.`post_first_name` AS postFname, P.`post_last_name` AS postLname, P.`title_discussion` AS postTitle, P.`job_location` AS jobLocation, P.`ratings` AS ratings, P.`job_role` AS jobRole, P.`linked_url` AS linkedUrl, P.`details` AS postDetails, P.`date_back_out` AS backOutDate, P.`resume` AS resume, P.`created_at` AS postCreated FROM `register_tbl` AS R JOIN `post_details_tbl` AS P ON R.register_id = P.`created_by` WHERE R.`status` = '1' AND R.`first_name` LIKE '%".$search."%' OR R.`last_name` LIKE '%".$search."%' OR P.`post_first_name` LIKE '%".$search."%' OR P.`post_last_name` LIKE '%".$search."%' OR P.`title_discussion` LIKE '%".$search."%' OR P.`job_location` LIKE '%".$search."%'";
		$query = execute_query($conn, $sql);
		$result = mysqli_num_rows($query);

		if($result > 0)
		{
			while($row = mysqli_fetch_assoc($query))
			{
				$array[] 	= 	$row;
				/*$registerId = 	$row['registerId'];
				$fName 		=	$row['firstName'];
				$lName 		=	$row['lastName'];
				$userImage 	=	$row['userImage'];
				$postId 	=	$row['postId'];
				$postTitle 	=	$row['postTitle'];
				$postDetail = 	$row['postDetails'];
				$postDt 	=	$row['postCreated']; */
			}
		}
		else{
			echo $sql;
			$array = 'No records!';
		}
		$data['data'] = $array;

		echo json_encode($data);
	}

	
?>