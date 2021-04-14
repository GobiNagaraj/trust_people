<?php 
	include_once '../model/db.php';
	$conn = db_connect();

	$valid = array();
	/*code for yes i'm field*/
	if(isset($_POST['yes_iam']))
	{
		$userId 		= 	$_POST['userId'];
		$postId 		=	$_POST['postId'];
		$registerId 	=	$_POST['registerId'];
		$yes 			= 	$_POST['yes_iam'];
		$status 		=	'1';

		$selectQuery = execute_query($conn, "SELECT COUNT(yes_iam) AS cntPostId FROM `social_details_tbl` WHERE user_id = '$userId' AND post_id = '$postId' AND register_id = '$registerId'");
		while($getSelectQuery = mysqli_fetch_array($selectQuery)){
			$heartCount = $getSelectQuery['cntPostId'];
			//echo $heartCount;
		}
		if($heartCount == 1){
			//echo "already inserted";
			$deleteHeart = "DELETE FROM `social_details_tbl` WHERE user_id = '$userId' AND post_id = '$postId' AND register_id = '$registerId' AND yes_iam = '1'";
			$heartQuery = execute_query($conn, $deleteHeart);
			if($heartQuery)
			{
				$getSocialDetails = "SELECT COUNT(S.`yes_iam`) AS cntYes, COUNT(S.`similar_exp`) AS cntExp, COUNT(S.`comments`) AS cntCmt FROM `social_details_tbl` AS S WHERE S.post_id = '".$postId."' ";
			  	$getQuery = execute_query($conn, $getSocialDetails);
				while($setSocial = mysqli_fetch_assoc($getQuery)){
					$cntyes = $setSocial['cntYes'];
				}
				$valid['status'] = $cntyes;
				$valid['msg'] 	 = 'unfollow';
				echo json_encode($valid);
			}
			else
			{
				echo "unfollow fail";
			}

		}else{
			$sql = "INSERT INTO `social_details_tbl` (`user_id`, `post_id`, `register_id`, `yes_iam`, `status`) VALUES ('$userId', '$postId', '$registerId', '$yes', '$status')";
			$query = execute_query($conn, $sql);

			if($query)
			{
				$getSocialDetails = "SELECT COUNT(S.`yes_iam`) AS cntYes, COUNT(S.`similar_exp`) AS cntExp, COUNT(S.`comments`) AS cntCmt FROM `social_details_tbl` AS S WHERE S.post_id = '".$postId."' ";
			  	$getQuery = execute_query($conn, $getSocialDetails);
				while($setSocial = mysqli_fetch_assoc($getQuery)){
					$cntyes = $setSocial['cntYes'];
				}
				$valid['status'] = $cntyes;
				$valid['msg'] 	 = 'success';
				echo json_encode($valid);
			}
			else
			{
				echo "fail";
			}
		}
	}

	/*if(isset($_POST['same']))
	{
		$userId 		= 	$_POST['userId'];
		$postId 		=	$_POST['postId'];
		$registerId 	=	$_POST['registerId'];
		$same 			= 	$_POST['same'];
		$status 		=	'1';

		$selectQueryLike = execute_query($conn, "SELECT COUNT(similar_exp) AS cntPostId FROM `social_details_tbl` WHERE user_id = '$userId' AND post_id = '$postId' AND register_id = '$registerId'");
		while($getSelectQueryLike = mysqli_fetch_array($selectQueryLike)){
			$likeCount = $getSelectQueryLike['cntPostId'];
			echo $likeCount;
		}
		if($likeCount == 1){
			$deleteLike = "DELETE FROM `social_details_tbl` WHERE user_id = '$userId' AND post_id = '$postId' AND register_id = '$registerId'";
			$likeQuery = execute_query($conn, $deleteLike);
			if($likeQuery)
			{
				echo "unlike";
			}
			else
			{
				echo "unlike fail";
			}
		}else{
			$sql = "INSERT INTO `social_details_tbl` (`user_id`, `post_id`, `register_id`, `similar_exp`, `status`) VALUES ('$userId', '$postId', '$registerId', '$same', '$status')";
			$query = execute_query($conn, $sql);

			if($query)
			{
				echo "success";
			}
			else
			{
				echo "fail";
			}
		}
	}*/

	/*code for follow field*/
	if(isset($_POST['follow']))
	{
		$userId 		= 	$_POST['userId'];
		$registerId 	=	$_POST['registerId'];
		$follow			= 	$_POST['follow'];
		$followerStatus = 	$_POST['followerStatus'];

		$sql = "INSERT INTO `social_details_tbl` (`user_id`, `register_id`, `followers`, `follower_status`) VALUES ('$userId', '$registerId', '$follow', '$followerStatus')";
		$query = execute_query($conn, $sql);

		if($query)
		{
			$valid['status'] = true;
			$valid['message'] = "You're following!";
		}
		else
		{
			$valid['status'] = false;
			$valid['message'] = "Somthing went wrong!";
		}
		echo json_encode($valid);
	}

	if(isset($_POST['unfollow']))
	{
		$userId 		= 	$_POST['userId'];
		$registerId 	=	$_POST['registerId'];

		$sql = "DELETE FROM `social_details_tbl` WHERE user_id = '$userId' AND register_id = '$registerId' AND followers = '1' ";
		$query = execute_query($conn, $sql);

		if($query)
		{
			echo $sql;
			$valid['status'] = true;
			$valid['message'] = "You're Unfollowing!";
		}
		else
		{	
			echo $sql;
			$valid['status'] = false;
			$valid['message'] = "Somthing went wrong!";
		}
		echo json_encode($valid);
	}



?>