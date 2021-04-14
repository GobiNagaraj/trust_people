<?php 
	ini_set("display_errors", 1);

	require '../vendor/autoload.php';
	use \Firebase\JWT\JWT;

	//include headers
	header("Access-Control-Allow-Origin: *");
	header("Access-Control-Allow-Methods: POST");
	header("Content-type: application/json; charset=utf-8");

	include_once '../model/db.php';
	$conn = db_connect();

	$response = array( 
    'status' => 0, 
    'message' => 'Form submission failed, please try again.'); 

	if(isset($_POST['post_first_name']))
	{
		for($counter = 0; $counter < count($_POST['post_category']); $counter++){

		$userIds = encrypt_decrypt($_POST['user_id']);
		$userId = $userIds['decrypted'];

		$firstName		=		remove_special_char(sanitize($conn, $_POST['post_first_name']));
		$lastName 		=		remove_special_char(sanitize($conn, $_POST['post_last_name']));
		$title 			=		sanitize($conn, $_POST['post_category'][$counter]);
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
		$userId				=		$userId;
		$createdTime 		=		date('Y-m-d h:i:s');

		// file validation
		$fileinfo = @getimagesize($_FILES["resume"]["tmp_name"]);
		$allowed_image_extension = array("pdf", "PDF");
		// Get image file extension
    	$file_extension = pathinfo($_FILES["resume"]["name"], PATHINFO_EXTENSION);
    	if (! in_array($file_extension, $allowed_image_extension)) {
    		http_response_code(500);
	        $response = array(
	        	"status" => 0,
	            "type" => "error",
	            "message" => "Please upload pdf file only."
	        );
	        echo json_encode($response);
	    }// Validate image file size
	    else if (($_FILES["resume"]["size"] > 20971520)) {
	    	http_response_code(500);
	        $response = array(
	        	"status" => 0,
	            "type" => "error",
	            "message" => "Please upload a file size less than 20 MB"
	        );
	        echo json_encode($response);
	    }else{
	    	// validate linked-in URL
	    	$urlPattern = "/^(?:(?:http|https):\/\/)?(?:www.)?linkedin.com\/in\/\w+()+/";
	    	if(!preg_match($urlPattern, $linkedUrl)){
	    		http_response_code(500);
		        $response = array(
		        	"status" => 0,
		            "type" => "error",
		            "message" => "Invalid Linkedin URL"
		        );
		        echo json_encode($response);
	    	}else{
	    		$linkedUrl = $linkedUrl;
	    	}

	    	$type = explode('.', $_FILES['resume']['name']);
			$type = $type[count($type) - 1];
			$fileName = uniqid(rand()) . '.' .$type;
			$url = '../resumeFiles/' . $fileName;

			if($_FILES['resume']['name'] == ''){
				$fileName = '';
			}
			
			move_uploaded_file($_FILES["resume"]["tmp_name"], $url);
			if (empty(trim($title))) continue;
			$sql = "INSERT INTO `post_details_tbl` (`post_first_name`, `post_last_name`, `title_discussion`, `job_location_country`, `job_location_state`, `job_location_city`, `job_role`, `vendor_name`, `linked_url`, `date_back_out`, `ratings`, `backout`, `resume`, `details`, `created_by`, `status`, `created_at`) VALUES ('".$firstName."', '".$lastName."', '".$title."', '".$jobLocationCnty."', '".$jobLocationSte."', '".$jobLocationCity."', '".$jobRole."', '".$vendorName."', '".$linkedUrl."', '', '".$rating."', '', '".$fileName."', '".$details."', '".$userId."', '".$status."', '".$createdTime."')";
			$result = execute_query($conn, $sql);

			if($result)
			{			
				$iss = "localhost";
			    $iat = time();
			    $nbf = $iat + 10;
			    $exp = $iat + 20;
			    $aud = "submitPost";
			    $user_arr_data = array(
			    	"post_first_name" => $_POST['post_first_name'],
			    	"post_last_name" => $_POST['post_last_name']
			    );

			    $secret_key = "owt125";

		        $payload_info = array(
		        	"iss"=> $iss,
		            "iat"=> $iat,
		            "nbf"=> $nbf,
		            "exp"=> $exp,
		            "aud"=> $aud,
		            "data"=> $user_arr_data
		        );

		        $jwt = JWT::encode($payload_info, $secret_key, 'HS512');

		        http_response_code(200);
		        echo json_encode(array(
		            "status" => 1,
		            "jwt" => $jwt,
		            "message" => "Form data submitted successfully!"
		        ));
				/*$response['status'] = 1; 
	            $response['message'] = 'Form data submitted successfully!';*/ 
			}
			else{
				/*$response['message'] = $sql; */
				http_response_code(404);
		        echo json_encode(array(
		        	"status" => 0,
		            "message" => "fail"
		        ));
			}
	    }
		/*echo json_encode($response);*/
		}
	}
	
	if(isset($_POST['delete_my_post'])){
		$postId = $_POST['delete_post'];
		$userId = $_POST['user_id'];

		$deletePost = execute_query($conn, "DELETE FROM `post_details_tbl` WHERE post_id = '".$postId."'");
		if($deletePost){
			$delActivity = execute_query($conn, "DELETE FROM `social_details_tbl` WHERE post_id = '".$postId."'");
			if($delActivity){
				$_SESSION['success'] = 'Your post has been deleted successfully!';
				header('Location: ../view/profile/?userId='.base64_encode($userId));
			}else{
				$_SESSION['error'] = 'Something went to wrong!';
				header('Location: ../view/profile/?userId='.base64_encode($userId));
			}
		}else{
			$_SESSION['error'] = 'Something went to wrong!';
			header('Location: ../view/profile/?userId='.base64_encode($userId));
		}
	}
?>