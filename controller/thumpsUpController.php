<?php 
	include_once '../model/db.php';
	$conn = db_connect();

	if(isset($_POST['same']))
	{
		$userId 		= 	$_POST['userId'];
		$postId 		=	$_POST['postId'];
		$registerId 	=	$_POST['registerId'];
		$same 			= 	$_POST['same'];
		$status 		=	'1';

		$selectQuery = execute_query($conn, "SELECT COUNT(similar_exp) AS cntPostId FROM `social_details_tbl` WHERE user_id = '$userId' AND post_id = '$postId' AND register_id = '$registerId'");
		while($getSelectQuery = mysqli_fetch_array($selectQuery)){
			$heartCount = $getSelectQuery['cntPostId'];
		}
		if($heartCount == 1){
			$deleteHeart = "DELETE FROM `social_details_tbl` WHERE user_id = '$userId' AND post_id = '$postId' AND register_id = '$registerId' AND similar_exp = '1'";
			$heartQuery = execute_query($conn, $deleteHeart);
			if($heartQuery)
			{
				$getSocialDetails = "SELECT COUNT(S.`yes_iam`) AS cntYes, COUNT(S.`similar_exp`) AS cntExp, COUNT(S.`comments`) AS cntCmt FROM `social_details_tbl` AS S WHERE S.post_id = '".$postId."' ";
			  	$getQuery = execute_query($conn, $getSocialDetails);
				while($setSocial = mysqli_fetch_assoc($getQuery)){
					$cntSame = $setSocial['cntExp'];
				}
				$validd['status'] = $cntSame;
				$validd['msg'] 	 = 'unlike';
				echo json_encode($validd);
			}
			else
			{
				echo "unfollow fail";
			}

		}else{
			$sql = "INSERT INTO `social_details_tbl` (`user_id`, `post_id`, `register_id`, `similar_exp`, `status`) VALUES ('$userId', '$postId', '$registerId', '$same', '$status')";
			$query = execute_query($conn, $sql);

			if($query)
			{
				$getSocialDetails = "SELECT COUNT(S.`yes_iam`) AS cntYes, COUNT(S.`similar_exp`) AS cntExp, COUNT(S.`comments`) AS cntCmt FROM `social_details_tbl` AS S WHERE S.post_id = '".$postId."' ";
			  	$getQuery = execute_query($conn, $getSocialDetails);
				while($setSocial = mysqli_fetch_assoc($getQuery)){
					$cntSame = $setSocial['cntExp'];
				}
				$validd['status'] = $cntSame;
				$validd['msg'] 	 = 'success';
				echo json_encode($validd);
			}
			else
			{
				echo "fail";
			}
		}
	}
?>