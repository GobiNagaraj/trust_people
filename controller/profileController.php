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

	/*update profile image*/
	if(isset($_POST['upload_image_id']))
	{
		$userId = $_POST['upload_image_id'];
		
		$type = explode('.', $_FILES['user_image']['name']);
		$type = $type[count($type) - 1];
		$imageName = uniqid(rand()) . '.' .$type;
		$url = '../userImage/' . $imageName;

		if (move_uploaded_file($_FILES["user_image"]["tmp_name"], $url)) 
		{
	        $sql = "UPDATE `register_tbl` SET `user_image` = '$imageName' WHERE `register_id` = '$userId' ";
			$result = execute_query($conn, $sql);

			if($result){
				$_SESSION['success'] = 'Your profile image updated successfully';
				header('Location: ../view/profile/?userId='.base64_encode($userId));
			}
			else{
				$_SESSION['error'] = 'Something went wrong!';
				header('Location: ../view/profile/?userId='.base64_encode($userId));
			}
	    } 
	    else 
	    {
	       	$_SESSION['error'] = 'Sorry, there was an error uploading your file.';
			header('Location: ../view/profile/?userId='.base64_encode($userId));
	   	}
	}

	/*update details*/
	if(isset($_POST['about_info']))
	{
		$userId = $_POST['abt_user_id'];
		$abtInformation = remove_special_char(sanitize($conn, $_POST['about_information']));
		$mobileNumber = $_POST['mobilenumber'];
		$countryCode = $_POST['mobile_country_code'];
		$mobilePrivacy = $_POST['mobile_privacy'];

        $sql = "UPDATE `user_personal_details_tbl` SET `about_info` = '$abtInformation' WHERE `register_id` = '$userId' ";
		$result = execute_query($conn, $sql);

		if($mobileNumber != ''){
			$updateMobile = execute_query($conn, "UPDATE `register_tbl` SET `country_code` = '+".$countryCode."', `mobile_number` = '".$mobileNumber."', `mobile_privacy` = '".$mobilePrivacy."' WHERE register_id = '$userId'");
		}

		if($result){
			$_SESSION['success'] = 'Your details have been updated successfully!';
			header('Location: ../view/profile/?userId='.base64_encode($userId).'&sts=personal');
		}
		else{
			$_SESSION['error'] = 'Something went wrong!';
			header('Location: ../view/profile/?userId='.base64_encode($userId).'&sts=personal');
		}
	}

	if(isset($_POST['update_education_details']))
	{
		$userId = $_POST['company_user_id'];
		$titleId = $_POST['title_id'];
		$designation  =	 remove_special_char(sanitize($conn, $_POST['designation']));
		$description  =  remove_special_char(sanitize($conn, $_POST['description']));
		$countryId = $_POST['company_country'];
		$stateId = $_POST['company_state'];
		$cityId = $_POST['company_city'];
		$companyAddress = remove_special_char(sanitize($conn, $_POST['company_address']));
		$emailPrivacy = $_POST['email_privacy'];

		if($titleId != 6){
			$designation = '';
		}else{
			$designation = $designation;
		}

        $sql = "UPDATE `register_tbl` SET `reg_title_id` = '$titleId', `title` = '$designation', `company_country_id` = '$countryId', `company_state_id` = '$stateId', `company_city_id` = '$cityId', `company_address` = '$companyAddress', `email_privacy` = '$emailPrivacy' WHERE `register_id` = '$userId' ";

        $update = execute_query($conn, "UPDATE `user_personal_details_tbl` SET `description` = '$description' WHERE `register_id` = '$userId' ");
        
		$result = execute_query($conn, $sql);

		if($result){

			$_SESSION['success'] = 'Your details have been updated successfully!';
			header('Location: ../view/profile/?userId='.base64_encode($userId).'&sts=company');
		}
		else{
			$_SESSION['error'] = 'Something went wrong!';
			header('Location: ../view/profile/?userId='.base64_encode($userId).'&sts=company');
		}
	}

	if(isset($_POST['update_password']))
	{
		$userId 	=	$_POST['password_user_id'];
		$userPassword 	=	remove_special_char(sanitize($conn, $_POST['new_password']));

		$decryptedUserId = encrypt_decrypt($userId);
		$userId = $decryptedUserId['decrypted'];

		/*Decryption method for Password*/

		// CBC has an IV and thus needs randomness every time a message is encrypted
		$method = 'aes-256-cbc';

		$key = substr(hash('sha256', $userPassword, true), 0, 32);

		// Most secure key
		// IV must be exact 16 chars (128 bit)
		$iv = chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0);

		// User Entered password for Encryption
		$password = base64_encode(openssl_encrypt($userPassword, $method, $key, OPENSSL_RAW_DATA, $iv));

		// User Entered password for Decryption
		$decryptedPassword = openssl_decrypt(base64_decode($password), $method, $key, OPENSSL_RAW_DATA, $iv);

		$sql = "UPDATE `register_tbl` SET `password` = '$password', `encrypted_password` = '$userPassword' WHERE `register_id` = '$userId' ";
		$result = execute_query($conn, $sql);

		if($result){
			$iss = "localhost";
		    $iat = time();
		    $nbf = $iat + 10;
		    $exp = $iat + 20;
		    $aud = "updateUserPassword";
		    $user_arr_data = array(
		    	"password_user_id" => $_POST['password_user_id'],
		    	"new_password" => $_POST['new_password']
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
	            "message" => "success"
	        ));

			// $_SESSION['success'] = 'Password updated successfully!';
			// header('Location: ../view/profile/?sts=account');
			header('Location: ../logout.php');
		}
		else{
			http_response_code(404);
	        echo json_encode(array(
	        	"status" => 0,
	            "message" => "fail"
	        ));
			$_SESSION['error'] = 'Something went wrong!';
			header('Location: ../view/profile/?sts=account');
		}
	}

	if(isset($_POST['remove']))
	{
		$userId 		=	$_POST['remove_user_id'];
		$registerId		=	$_POST['remove_reg_id'];
		$removeConn		=	$_POST['remove_status'];

		$removeConnection = execute_query($conn, "DELETE FROM `social_details_tbl` WHERE user_id = '$userId' AND register_id = '$registerId' AND `follower_status` = '$removeConn'");
		if($removeConnection){
			$removeConnected = execute_query($conn, "DELETE FROM `social_details_tbl` WHERE user_id = '$registerId' AND register_id = '$userId' AND `follower_status` = '$removeConn'");
			if($removeConnection){
				$_SESSION['success'] = 'Your connection has been removed successfully!';
				header('Location: ../view/profile/?userId='.base64_encode($userId).'&sts=connection');
			}else{
				$_SESSION['error'] = 'Something went wrong!';
				header('Location: ../view/profile/?userId='.base64_encode($userId).'&sts=connection');
			}			
		}else{
			$_SESSION['error'] = 'Something went wrong!';
			header('Location: ../view/profile/?userId='.base64_encode($userId).'&sts=connection');
		}
	}
?>