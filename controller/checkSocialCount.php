<?php 
	include_once '../model/db.php';
	$conn = db_connect();

	$check = array('status' => false, 'message' => array());
	if(isset($_POST['yes']))
	{
		$user_id = $_POST['userId'];
		$post_id = $_POST['postId'];

		$sql = "SELECT COUNT(yes_iam) AS yes FROM `social_details_tbl` WHERE user_id = '$user_id' AND post_id = '$post_id'";
		$query = execute_query($conn, $sql);

		while($row = mysqli_fetch_assoc($query)){
			if($row['yes'] == 1){
				$check['status'] = false;
				$check['message'] = "fail!";
			}else{
				$check['status'] = true;
				$check['message'] = "success!";
			}
		}
		echo json_encode($check);
	}

	if(isset($_POST['same']))
	{
		$user_id = $_POST['userId'];
		$post_id = $_POST['postId'];

		$sql = "SELECT COUNT(similar_exp) AS same FROM `social_details_tbl` WHERE user_id = '$user_id' AND post_id = '$post_id'";
		$query = execute_query($conn, $sql);

		while($row = mysqli_fetch_assoc($query)){
			if($row['same'] == 1){
				$check['status'] = false;
				$check['message'] = "fail!";
			}else{
				$check['status'] = true;
				$check['message'] = "success!";
			}
		}
		echo json_encode($check);
	}

?>