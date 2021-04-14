<?php 
	include_once '../model/db.php';
	$conn = db_connect();

	$trustedData = array();
	$untrustData = array();
	if(isset($_POST['trustPostId'])){
		$postId = $_POST['trustPostId'];

		$sql = "SELECT R.`first_name` AS firstName, R.`last_name` AS lastName FROM `register_tbl` AS R JOIN `social_details_tbl` AS S ON S.`user_id` = R.`register_id` WHERE S.`post_id` = '".$postId."' AND S.`yes_iam` = '1' ORDER BY S.`created_at`";
		$result = execute_query($conn, $sql);
		$count = mysqli_num_rows($result);
		if($count > 0){
			while($row = mysqli_fetch_assoc($result)){
				$trustedData[] = $row;
			}
			echo json_encode($trustedData);
		}else{
			echo '';
		}
	}

	if(isset($_POST['UnTrustPostId'])){
		$unTrustPostId = $_POST['UnTrustPostId'];

		$unTrustsql = "SELECT R.`first_name` AS firstName, R.`last_name` AS lastName FROM `register_tbl` AS R JOIN `social_details_tbl` AS S ON S.`user_id` = R.`register_id` WHERE S.`post_id` = '".$unTrustPostId."' AND S.`similar_exp` = '1' ORDER BY S.`created_at`";
		$unTrustresult = execute_query($conn, $unTrustsql);
		$unTrustcount = mysqli_num_rows($unTrustresult);
		if($unTrustcount > 0){
			while($unTrustrow = mysqli_fetch_assoc($unTrustresult)){
				$untrustData[] = $unTrustrow;
			}
			echo json_encode($untrustData);
		}else{
			echo '';
		}
	}

?>