<?php 
	include_once '../model/db.php';
	$conn = db_connect();

	if(isset($_POST['followStatus']))
	{
		$userId 		=	$_POST['userId'];
		$regId  		= 	$_POST['regId'];
		$followStatus	=	$_POST['followStatus'];

		$updateFollowStatus = execute_query($conn, "UPDATE `social_details_tbl` SET `follower_status` = '$followStatus' WHERE user_id = '$userId' AND register_id = '$regId' AND post_id IS NULL ");
		if($updateFollowStatus){
			$insertFollow = execute_query($conn, "INSERT `social_details_tbl` (`user_id`, `register_id`, `followers`, `follower_status`) VALUES ('$regId', '$userId', '1', '1')");
			if($insertFollow){
				echo "success";	
			}else{
				echo "fail";
			}	
		}
		else{
			echo "fail";
		}
	}

	if(isset($_POST['unfollowStatus']))
	{
		$userId 		=	$_POST['userId'];
		$regId  		= 	$_POST['regId'];
		$followStatus	=	$_POST['unfollowStatus'];

		$updateFollowStatus = execute_query($conn, "DELETE FROM `social_details_tbl` WHERE user_id = '$userId' AND register_id = '$regId' AND `follower_status` = '0' ");
		if($updateFollowStatus){
			echo "success";
		}
		else{
			echo "fail";
		}
	}

	if(isset($_POST['removeStatus']))
	{
		$userId 		=	$_POST['userId'];
		$registerId		=	$_POST['registerId'];
		$removeConn		=	$_POST['removeStatus'];

		$removeConnection = execute_query($conn, "DELETE FROM `social_details_tbl` WHERE user_id = '$userId' AND register_id = '$registerId' AND `follower_status` = '$removeConn'");
		if($removeConnection){
			$removeConnected = execute_query($conn, "DELETE FROM `social_details_tbl` WHERE user_id = '$registerId' AND register_id = '$userId' AND `follower_status` = '$removeConn'");
			if($removeConnection){
				echo "success";
			}else{
				echo "fail";
			}			
		}else{
			echo "fail";
		}
	}
?>