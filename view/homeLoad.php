<?php 
	include_once '../model/db.php';
	$conn = db_connect();

	$user_id = 	$_SESSION['data']['register_id'];

	$result = array('msg' => array());
	$getPostCount = execute_query($conn, "SELECT COUNT(post_id) AS postCount FROM `post_details_tbl`");
	while($showCnt = mysqli_fetch_array($getPostCount)){ $showCount = $showCnt['postCount']; }
	if($showCount != ''){
		$result['msg'] = $showCount;
	}else{
		$result['msg'] = 'no post';
	}
	echo json_encode($result);
?>