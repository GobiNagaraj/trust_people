<?php 
	include_once '../model/db.php';
	$conn = db_connect();

	$json = array();
	$valid = array('status' => false, 'message' => array());
	if(isset($_POST['comments']))
	{
		$userId = $_POST['userId'];
		$postId = $_POST['postId'];
		$registerId = $_POST['registerId'];
		$comment = remove_special_char(sanitize($conn, $_POST['comments']));
		$status = '1';

		$sql = "INSERT INTO `social_details_tbl` (`user_id`, `post_id`, `register_id`, `comments`, `status`) VALUES ('$userId', '$postId', '$registerId', '$comment', '$status') ";
		$query = execute_query($conn, $sql);

		$showCmtCnt = execute_query($conn, "SELECT COUNT(comments) AS cmt FROM `social_details_tbl` WHERE post_id = '".$postId."'");
		while($showComment = mysqli_fetch_assoc($showCmtCnt)){
			$getComment = $showComment['cmt'];
		}
		if($query){
			$valid['status'] = true;
			$valid['message'] = $getComment;
		}
		else{
			$valid['status'] = false;
			$valid['message'] = "Somthing went wrong!";
		}
		echo json_encode($valid);
	}

	if(isset($_POST['status']))
	{
		$status = $_POST['status'];
		$postId = $_POST['postId'];
		//$userId = $_POST['userId'];
		
		/* including user_id */
		//$sql = "SELECT R.`user_image` AS userImage, S.`comments` AS comments FROM `social_details_tbl` AS S JOIN `register_tbl` AS R ON R.register_id = S.user_id WHERE S.`comments` IS NOT NULL AND R.status = '$status' AND S.post_id = '$postId' AND S.user_id = '$userId' ORDER BY S.social_id DESC ";

		$sql = "SELECT R.`first_name` AS first_name, R.`last_name` AS last_name, R.`user_image` AS userImage, S.`comments` AS comments, S.`created_at` AS createdTime FROM `social_details_tbl` AS S JOIN `register_tbl` AS R ON R.register_id = S.user_id WHERE S.`comments` IS NOT NULL AND R.status = '$status' AND S.post_id = '$postId' ORDER BY S.social_id DESC ";
		$query = execute_query($conn, $sql);

		while($row = mysqli_fetch_assoc($query)){
			$json[] = $row;
		}

		$data['data'] = $json;

		echo json_encode($data);
	}

?>