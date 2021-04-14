<?php 
	include_once '../model/db.php';
	$conn = db_connect();

	$valid = array('success' => false, 'message' => array());
	if(isset($_POST['currentPassword']))
	{
		$userId = $_POST['userId'];
		$decryptedUserId = encrypt_decrypt($userId);
		$userId = $decryptedUserId['decrypted'];

		$password 	= 	remove_special_char(sanitize($conn, $_POST['currentPassword']));
		$sql = "SELECT `encrypted_password` FROM `register_tbl` WHERE register_id = '$userId'";
		$query = execute_query($conn, $sql);

		while($row = mysqli_fetch_assoc($query)){
			$count = mysqli_num_rows($query);
			if($count > 0){
				$valid['success'] = true;
				$valid['message'] = $row['encrypted_password'];
			}
			else{
				$valid['success'] = false;
				$valid['message'] = "Password do not match!!";
			}
		}
		echo json_encode($valid);
	}
?>