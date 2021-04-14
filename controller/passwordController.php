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

	if(isset($_POST['registerEmail']))
	{	
		$regEmail 	= 	remove_special_char(sanitize($conn, $_POST['registerEmail']));
		$otp        =   rand(100000, 999999);

		$sql = "INSERT INTO `forgot_password_tbl` (`email_address`, `otp`, `auth_status`) VALUES ('$regEmail', '$otp', '0')";
		$query = execute_query($conn, $sql);
		if($query){
			$to = $regEmail;
			$subject = "Reset your Trustpeople password";

			$message = "
			<html>
			<head>
			<title>Reset your Trustpeople password</title>
			</head>
			<body>
			<div style='border: 1px solid #000; padding: 20px; width: 85%;'>
			<center><img src='https://trustpeople.io/assets/images/email-logo.png'></center>
			<br><br>
			<h3 style='color: #000; font-size: 30px;'>Reset your Trustpeople password</h3><hr style='border: 1px solid #f7f7f7;'>
			<p style='color: #000; font-size: 20px;'>Please return to your browser window and enter this 6-digit code to reset your password.</p>
			<p style='font-size: 28px;'>" .$otp. "</p>
			<br>
			<p style='color: #000; font-size: 14px;'> If you did not initiate this process, please disregard this email. Do not reply to this automated email.</p>
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
			if($mailStatus){
				$iss = "localhost";
			    $iat = time();
			    $nbf = $iat + 10;
			    $exp = $iat + 20;
			    $aud = "insertData";
			    $user_arr_data = array(
			    	"registerEmail" => $_POST['registerEmail']
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
				http_response_code(500);
		        echo json_encode(array(
		        	"status" => 0,
		            "message" => "fail"
		        ));
			}
		}
		else{
			http_response_code(404);
	        echo json_encode(array(
	        	"status" => 0,
	            "message" => "fail"
	        ));
		}
	}

	if(isset($_POST['updateEmail']))
	{
		$emailId = remove_special_char(sanitize($conn, $_POST['updateEmail']));
		$userPassword = remove_special_char(sanitize($conn, $_POST['updatePassword']));

		$method = 'aes-256-cbc';
		$key = substr(hash('sha256', $userPassword, true), 0, 32);
		$iv = chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0);

		$password = base64_encode(openssl_encrypt($userPassword, $method, $key, OPENSSL_RAW_DATA, $iv));

		$decryptedPassword = openssl_decrypt(base64_decode($password), $method, $key, OPENSSL_RAW_DATA, $iv);

		$updateForgottbl = execute_query($conn, "UPDATE `forgot_password_tbl` SET `auth_status` = '1' WHERE `email_address` = '$emailId' ");
		$sql = "UPDATE `register_tbl` SET `encrypted_password` = '$userPassword', `password` = '$password' WHERE `email_address` = '$emailId' ";
		$query = execute_query($conn, $sql);

		if($query){
			$iss = "localhost";
		    $iat = time();
		    $nbf = $iat + 10;
		    $exp = $iat + 20;
		    $aud = "resetPassword";
		    $user_arr_data = array(
		    	"updateEmail" => $_POST['updateEmail'],
		    	"updatePassword" => $_POST['updatePassword']
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