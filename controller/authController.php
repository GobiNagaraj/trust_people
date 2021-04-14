<?php 
	//session_start();
	ini_set("display_errors", 1);

	require '../vendor/autoload.php';
	use \Firebase\JWT\JWT;

	//include headers
	header("Access-Control-Allow-Origin: *");
	header("Access-Control-Allow-Methods: POST");
	header("Content-type: application/json; charset=utf-8");

	include_once '../model/db.php';

	$conn = db_connect();

	/*code for sign-in*/
	if(isset($_POST['signin']))
	{	
		$username 			=		remove_special_char(sanitize($conn, $_POST['username']));
		$userPassword 		=		remove_special_char(sanitize($conn, $_POST['password']));
	
		$method = 'aes-256-cbc';
		$key = substr(hash('sha256', $userPassword, true), 0, 32);
		$iv = chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0);
		$password = base64_encode(openssl_encrypt($userPassword, $method, $key, OPENSSL_RAW_DATA, $iv));
		$decryptedPassword = openssl_decrypt(base64_decode($password), $method, $key, OPENSSL_RAW_DATA, $iv);

		$sql = "SELECT `register_id`, `first_name`, `last_name`, `flag`, `status`, `login_attempt` FROM `register_tbl` WHERE email_address = '".$username."'";
		$result=execute_query($conn, $sql);
		$count = mysqli_num_rows($result);

		if($count > 0){
			while($rows = mysqli_fetch_assoc($result)){
				$status = $rows['status'];
				$loginAttempt = $rows['login_attempt'];
				$loginAttempt = $loginAttempt+1;
			}

			if($status == '0'){
				$checkRegistered = execute_query($conn, "SELECT `register_id`, `first_name`, `last_name`, `flag`, `status`, `password` FROM `register_tbl` WHERE email_address = '".$username."' AND password = '".$password."' AND status = '".$status."'");
				if($checkRegistered){
					$_SESSION['error'] = 'Account is not activated. Please check your email inbox or spam folder and activate your account.';
					header('Location: ../sign_in.php');
				}
			}else if($status == '1'){
				$loginUser = execute_query($conn, "SELECT `register_id`, `first_name`, `last_name`, `flag`, `status`, `password`, `login_attempt` FROM `register_tbl` WHERE email_address = '".$username."' AND password = '".$password."' AND status = '".$status."'");

				$selectLoginAttempt = execute_query($conn, "SELECT `login_attempt` FROM `register_tbl` WHERE email_address = '".$username."'");
				while($row = mysqli_fetch_assoc($selectLoginAttempt)){
					$loginAttempt = $row['login_attempt'];
					$loginAttempt = $loginAttempt + 1;
				}
				$updateLoginAttempt = execute_query($conn, "UPDATE `register_tbl` SET `login_attempt` = '".$loginAttempt."' WHERE email_address = '".$username."' ");
				if($loginAttempt >= '5'){
					$updateUserStatus = execute_query($conn, "UPDATE `register_tbl` SET `status` = '2' WHERE email_address = '".$username."' ");
				}

				$user_data = mysqli_fetch_array($loginUser, MYSQLI_ASSOC);
				if(empty($user_data)){
					$_SESSION['error'] = 'Invalid Username or Password';
					header('Location: ../sign_in.php');	
				}
				else{
					$_SESSION['data'] = $user_data;
					header('Location: ../view/home/');
				}
			}else if($status == '2'){
				$_SESSION['error'] = 'Your account is currently deactivated. Please send mail to support@trustpeople.io. To activate your account.';
				header('Location: ../sign_in.php');
			}
		}else{
			/*$selectLoginAttempt = execute_query($conn, "SELECT `login_attempt` FROM `register_tbl` WHERE email_address = '".$username."'");
			while($row = mysqli_fetch_assoc($selectLoginAttempt)){
				$loginAttempt = $row['login_attempt'];
				$loginAttempt = $loginAttempt + 1;
			}
			$updateLoginAttempt = execute_query($conn, "UPDATE `register_tbl` SET `login_attempt` = '".$loginAttempt."' WHERE email_address = '".$username."' ");
			if($loginAttempt >= '5'){
				$updateUserStatus = execute_query($conn, "UPDATE `register_tbl` SET `status` = '2' WHERE email_address = '".$username."' ");
			}*/
			$_SESSION['error'] = 'This account does not exist. Please register your account.';
			header('Location: ../sign_in.php');
		}
		exit();
	}

	/*code for register*/
	if(isset($_POST['register']))
	{		
		$firstName 		= 	remove_special_char(sanitize($conn, $_POST['firstname']));
		$lastName 		= 	remove_special_char(sanitize($conn, $_POST['lastname']));
		$title 			= 	remove_special_char(sanitize($conn, $_POST['title']));
		$titleName		=	remove_special_char(sanitize($conn, $_POST['title_name']));
		$emailAddress	= 	remove_special_char(sanitize($conn, $_POST['email']));
		$companyName	= 	remove_special_char(sanitize($conn, $_POST['companyname']));
		$website 		= 	remove_special_char(sanitize($conn, $_POST['companywebsite']));
		$regPassword 	=	remove_special_char(sanitize($conn, $_POST['password']));
		$flag			=	'1';
		$status			=	'0';

		/*Decryption method for Password*/

		// CBC has an IV and thus needs randomness every time a message is encrypted
		$method = 'aes-256-cbc';

		$key = substr(hash('sha256', $regPassword, true), 0, 32);

		// Most secure key
		// IV must be exact 16 chars (128 bit)
		$iv = chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0);

		// User Entered password for Encryption
		$password = base64_encode(openssl_encrypt($regPassword, $method, $key, OPENSSL_RAW_DATA, $iv));

		// User Entered password for Decryption
		$decryptedPassword = openssl_decrypt(base64_decode($password), $method, $key, OPENSSL_RAW_DATA, $iv);

		$sql = "INSERT INTO `register_tbl` (`first_name`, `last_name`, `reg_title_id`, `title`, `email_address`, `mobile_number`, `company_name`, `company_website`, `encrypted_password`, `password`, `flag`, `status`) VALUES ('".$firstName."', '".$lastName."', '".$title."', '".$titleName."', '".$emailAddress."', '', '".$companyName."', '".$website."', '".$regPassword."', '".$password."', '".$flag."', '".$status."')";
		$query = execute_query($conn, $sql);

		$lastId = mysqli_insert_id($conn);
		$details = execute_query($conn, "INSERT INTO `user_personal_details_tbl` (`register_id`, `status`) VALUES ('$lastId', '1') ");

		/* Send Login link to Registered User */
		if($query)
		{
    		$method = 'aes-256-cbc';
    		$key = substr(hash('sha256', $emailAddress, true), 0, 32);
    
    		$iv = chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0);
    
    		$authEmail = base64_encode(openssl_encrypt($emailAddress, $method, $key, OPENSSL_RAW_DATA, $iv));

    		$encryptedEmail = encrypt_decrypt($emailAddress);
    		
			$to = $emailAddress;
			$subject = "Welcome to Trustpeople.io! Let's get started!";

			$message = "
			<html>
			<head>
			<title>Login Link from Trust People!</title>
			</head>
			<body>
			<div style='border: 1px solid #000; padding: 20px; width: 85%;'>
			<center><img src='https://trustpeople.io/assets/images/email-logo.png' alt='TRUST-PEOPLE'></center>
			<br><br>
			<span>Hi</span> <strong>". $firstName ." ". $lastName .",</strong>
			<p>We are happy to have you join our vibrant community. Now that you have created your trustpeople.io account, please verify it by clicking the activation link below.<p><br>
			<p><a href='https://trustpeople.io/?id=". $authEmail ."&ids=". $authEmail ."&id1=". $$encryptedEmail['encrypted'] ."'>Click here to Activate</a></p>
			<table cellspacing='10' frame='box'>
			<tr>
			<th>Username</th>
			<td>". $emailAddress ."</td>
			</tr>
			</table><br>
			<strong>Thank you!</strong>
			<strong>Trustpeople.io</strong>
			</div>
			</body>
			</html>
			";

			// Always set content-type when sending HTML email
			$headers = "MIME-Version: 1.0" . "\r\n";
			$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

			// More headers
			$headers .= 'From: support@trustpeople.io' . "\r\n";

			$mailStatus = mail($to,$subject,$message,$headers);
			if($mailStatus)
			{
        		$selectSQL = execute_query($conn, "SELECT * FROM `register_tbl` WHERE register_id = '$lastId'");
        		$user_data = mysqli_fetch_array($selectSQL, MYSQLI_ASSOC);
        
        		if(empty($user_data)){
        			http_response_code(404);
			        echo json_encode(array(
			        	"status" => 0,
			            "message" => "fail"
			        ));
        			$_SESSION['error'] = 'Something went wrong!!';
        			// header('Location: ../view/register/enterpriseRegister.php');	
        			header('Location: ../sign_up.php');	
        		}else{
        			//$_SESSION['data'] = $user_data;
        			$iss = "localhost";
				    $iat = time();
				    $nbf = $iat + 10;
				    $exp = $iat + 20;
				    $aud = "accountCreation";
				    $user_arr_data = array(
				    	"first_name" => $_POST['first_name'],
				    	"last_name" => $_POST['last_name'],
				    	"email_address" => $_POST['email_address'],
				    	"mobile_number" => $_POST['mobile_number'],
				    	"password" => $_POST['password']
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

        			$_SESSION['success'] = 'Account created successfully. We have sent you an activation email, please check your email inbox or spam folder and activate your account.';
        			//header('Location: ../view/register/enterpriseRegister.php');
        			header('Location: ../sign_up.php');	
        		}
			}
		}
	}

	if(isset($_POST['deactivate_user_id'])){
		$user_id = $_POST['deactivate_user_id'];
		$decryptedUserId = encrypt_decrypt($user_id);
		$user_id = $decryptedUserId['decrypted'];

		$deactivateUser = execute_query($conn, "UPDATE `register_tbl` SET status = '2' WHERE register_id = '$user_id'");
		$deactivatePost = execute_query($conn, "UPDATE `post_details_tbl` SET status = '2' WHERE created_by = '$user_id'");
		$deactivatePersonal = execute_query($conn, "UPDATE `user_personal_details_tbl` SET status = '2' WHERE register_id = '$user_id'");
		/*$deactivateSocial = execute_query($conn, "UPDATE `social_details_tbl` SET status = '2' WHERE register_id = '$user_id'");*/
		if($deactivateUser){
			$iss = "localhost";
		    $iat = time();
		    $nbf = $iat + 10;
		    $exp = $iat + 20;
		    $aud = "deactivateAccount";
		    $user_arr_data = array(
		    	"deactivate_user_id" => $_POST['deactivate_user_id']
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
		}else{
			http_response_code(404);
	        echo json_encode(array(
	        	"status" => 0,
	            "message" => "fail"
	        ));
		}
	}
	
?>