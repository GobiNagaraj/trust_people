<?php 
	include_once '../../model/db.php';
	$conn = db_connect();

	$userId = 	$_SESSION['data']['register_id'];

	$showFollowerCnt = mysqli_query($conn, "SELECT followers, S.`followers` AS follower, S.`user_id` AS followerId, S.`register_id` AS followingRegId, S.`follower_status`, R.`register_id`, R.`first_name` AS followerFname, R.`last_name` AS followerLname, R.`user_image` AS userImage FROM `social_details_tbl` AS S JOIN `register_tbl` AS R ON R.`register_id` = S.`user_id` WHERE R.`status` = '1' AND S.`follower_status` = '0' AND S.`register_id` = '".$userId."'");
	
//	$result = '';
	$result = array();

	while($showCnt = mysqli_fetch_array($showFollowerCnt)){ 
		$result = $showCnt;	 
		//$result .= '<a href="../profile/userProfile.php?regId='.$showCnt["register_id"].'"><img src="../../userImage/'.$showCnt["user_image"].'" alt="'.$showCnt["followerFname"].'" "'.$showCnt["followerLname"].'" class="notify-drop-img"> &nbsp;<span class="notify-drop-name" style="margin: 0px;">'.$showCnt["followerFname"].'" "'.$showCnt["followerLname"].'"</span></a>';
	}
	echo json_encode($result);
?>