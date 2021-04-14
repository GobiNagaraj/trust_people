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
		$sql = "SELECT `email_address` FROM `register_tbl` WHERE email_address = '$regEmail'";
		$query = execute_query($conn, $sql);

		$count = mysqli_num_rows($query);
		if($count > 0){
			$iss = "localhost";
		    $iat = time();
		    $nbf = $iat + 10;
		    $exp = $iat + 20;
		    $aud = "checkEmail";
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
		}
		else{
			/*echo "fail";*/
			http_response_code(404);
	        echo json_encode(array(
	        	"status" => 0,
	            "message" => "fail"
	        ));
		}
	}

	/* Query to check the OTP value */
	if(isset($_POST['registerOTP']))
	{
		// body
   		$otp 		=	$_POST['registerOTP'];
		$regEmail 	= 	remove_special_char(sanitize($conn, $_POST['otpEmail']));
		$sql = "SELECT `email_address`, `otp` FROM `forgot_password_tbl` WHERE email_address = '$regEmail' AND otp = '$otp' AND auth_status = '0'";
		$query = execute_query($conn, $sql);
		$count = mysqli_num_rows($query);
		if($count > 0){
			// echo "otp available";
			$iss = "localhost";
		    $iat = time();
		    $nbf = $iat + 10;
		    $exp = $iat + 20;
		    $aud = "updatepassword";
		    $user_arr_data = array(
		    	"registerOTP" => $_POST['registerOTP'],
		        "otpEmail" => $_POST['otpEmail']
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
	            "message" => "otp available"
	        ));
		}
		else{
			/*echo "error";*/
			http_response_code(404);
	        echo json_encode(array(
	        	"status" => 0,
	            "message" => "error"
	        ));
		}
	}
?>