<?php 
	session_start();

	header("X-Frame-Options: SAMEORIGIN");
	
	function db_connect(){
		$hostname = "localhost";
		$username = "root";
		$password = "";
		$dbname = "trust_people_db";
		
		/* demo db connection */
		/*$hostname = "160.153.72.98";
		$username = "trust_us_user";
		$password = "trust_us_user";
		$dbname = "trust_people_us_db";*/

		/* live db connection */
		/*$hostname = "160.153.72.98";
		$username = "trustpeople2020";
		$password = "trustpeople2020";
		$dbname = "trustpeople";*/
		
		$conn = mysqli_connect($hostname, $username, $password, $dbname);
		if($conn){
			return $conn;
			//echo "Success";
		}else{
			echo "Error" .mysqli_error();
		}
	}

	function sanitize($conn, $value){
		return mysqli_real_escape_string($conn, $value);
	}

	function remove_special_char($string){
		return htmlspecialchars($string);
	}

	function execute_query($conn, $value){
		return mysqli_query($conn, $value);
	}

	function encrypt_decrypt($user_password) {
		$ciphering = "aes-256-cbc";
		$iv_length = openssl_cipher_iv_length($ciphering);
		$options = 0;
		$encryption_iv = '!@#$%^&*()_-+=[}';
		$encryption_key = "DigtialPractice";
		$encryption = openssl_encrypt($user_password, $ciphering,
		            $encryption_key, $options, $encryption_iv);
		// echo "<br>";
		// echo "Encrypted String: " . $encryption;
		$decryption_iv = '!@#$%^&*()_-+=[}';
		$decryption_key = "DigtialPractice";
		$decryption=openssl_decrypt($user_password, $ciphering, 
		        $decryption_key, $options, $decryption_iv);
		// echo "<br>";
		// echo "Decrypted String: " . $decryption;

		return $datas = array(
								"encrypted" => $encryption,
								"decrypted" => $decryption
							);

	}

?>