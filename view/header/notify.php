<?php 
	include_once '../../model/db.php';
	$conn = db_connect();

	$user_id = $_SESSION['data']['register_id'];

	$showFollowerCnt = execute_query($conn, "SELECT COUNT(followers) AS showFollowers FROM `social_details_tbl` WHERE register_id = '".$user_id."' AND follower_status = '0'");
	while($showCnt = mysqli_fetch_array($showFollowerCnt))
	{ 
		$showCount = $showCnt['showFollowers']; 

		$getFollowerRequest = execute_query($conn, "SELECT S.followers AS follower, S.user_id AS followerId, S.register_id AS followingRegId, S.follower_status, R.register_id, R.first_name AS followerFname, R.last_name followerLname, R.user_image AS userImage FROM `social_details_tbl` AS S JOIN `register_tbl` AS R ON R.register_id = S.user_id WHERE R.status = '1' AND S.follower_status = '0' AND S.register_id = '".$user_id."'");

		if(mysqli_num_rows($getFollowerRequest) > 0){
			while($followerReq = mysqli_fetch_assoc($getFollowerRequest)){

				if($followerReq['userImage'] == null){
					$image = 'user.png';
				}else{
					$image = $followerReq['userImage'];
				}

				echo '<a href="../profile/userProfile.php?regId='.base64_encode($followerReq['register_id']).'"><img src="../../userImage/'.$image.'" alt="'.$followerReq['followerFname']. " ".$followerReq['followerLname'].'" class="notify-drop-img"> &nbsp;<span class="notify-drop-name" style="margin: 0px;">'.$followerReq['followerFname']. " ".$followerReq['followerLname'].'</span></a><button style="float: right; margin: -30px 70px; " class="accept_fol_request btn-primary" data-userid="'.$followerReq['followerId'].'" data-regid="'.$followerReq['followingRegId'].'" data-reqsts="1" onclick="acceptRequest('.$followerReq['followerId'].')">Accept</button> <button style="float: right; margin: -30px 8px;" class="cancel_fol_request btn-default" data-userid="'.$followerReq['followerId'].'" data-regid="'.$followerReq['followingRegId'].'" data-reqsts="0" onclick="cancelRequest('.$followerReq['followerId'].')">Decline</button></div>
	        		<div class="dropdown-divider" style="border-bottom: 1px solid #d8d8d8;"></div><input type="hidden" value="'.$showCount.'" class="requestCount">';
			}
		}else{
			echo "<h5 style='text-align: center;'>You have no notifications yet</h5>";
		}
	}

	mysqli_close($conn);
?>