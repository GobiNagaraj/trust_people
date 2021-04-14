<?php 
	include_once '../model/db.php';
	$conn = db_connect();

	$response = array( 
    'status' => 0, 
    'message' => 'Form submission failed, please try again.'); 

	if(isset($_POST['post_first_name']))
	{
		$postId 		=		$_POST['post_edit_id'];
		for($counter = 0; $counter < count($_POST['post_category']); $counter++)
		{

		$firstName		=		remove_special_char(sanitize($conn, $_POST['post_first_name']));
		$lastName 		=		remove_special_char(sanitize($conn, $_POST['post_last_name']));
		$title 			=		remove_special_char(sanitize($conn, $_POST['post_category'][$counter]));
		$subCat 		=		remove_special_char(sanitize($conn, $_POST['sub_category']));

		if($title == '18'){
			$title = $subCat;
		}else{
			$title = $title;
		}

		$jobLocationCnty 	=		remove_special_char(sanitize($conn, $_POST['job_location']));
		$jobLocationSte 	=		$_POST['job_state'];
		$jobLocationCity 	=		$_POST['post_city'];
		$jobRole 			=		remove_special_char(sanitize($conn, $_POST['job_role']));
		$vendorName 		=		remove_special_char(sanitize($conn, $_POST['vendor_name']));
		$linkedUrl			=		remove_special_char(sanitize($conn, $_POST['linked_url']));
		$rating 			=		remove_special_char(sanitize($conn, $_POST['rating_val']));
		$details 			=		remove_special_char(sanitize($conn, $_POST['details']));
		$status				=		'1';
		$updatedTime 		=		date('Y-m-d h:i:s');
		$exitResume 		=		$_POST['resume_file'];

		if($_FILES['resume']['name'] != ''){
			$type = explode('.', $_FILES['resume']['name']);
			$type = $type[count($type) - 1];
			$fileName = uniqid(rand()) . '.' .$type;
			$url = '../resumeFiles/' . $fileName;
			move_uploaded_file($_FILES["resume"]["tmp_name"], $url);
		}else{
			$fileName = $exitResume;
		}

		if (empty(trim($title))) continue;
		$sql = "UPDATE `post_details_tbl` SET `post_first_name` = '".$firstName."', `post_last_name` = '".$lastName."', `title_discussion` = '".$title."', `job_location_country` = '".$jobLocationCnty."', `job_location_state` = '".$jobLocationSte."', `job_location_city` = '".$jobLocationCity."', `job_role` = '".$jobRole."', `vendor_name` = '".$vendorName."', `linked_url` = '".$linkedUrl."', `ratings` = '".$rating."', `resume` = '".$fileName."', `details` = '".$details."', `updated_at` = '".$updatedTime."' WHERE `post_id` = '".$postId."' ";
		$result = execute_query($conn, $sql);

		if($result)
		{			
			$response['status'] = 1; 
            $response['message'] = 'Form data updated successfully!'; 
		}
		else{
			$response['message'] = $sql; 
		}
		echo json_encode($response);
		}
	}
?>