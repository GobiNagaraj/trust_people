<?php 
	include_once '../model/db.php';
	$conn = db_connect();

	if(isset($_POST['regEmail']))
	{
		$regEmail 	= 	remove_special_char(sanitize($conn, $_POST['regEmail']));
		$sql = "SELECT `email_address` FROM `register_tbl` WHERE email_address = '$regEmail' AND status = '1'";
		$query = execute_query($conn, $sql);

		$count = mysqli_num_rows($query);
		if($count > 0){
			echo "success";
		}
		else{
			echo "fail";
		}
	}

	if(isset($_POST['registerEmail']))
	{
		$regEmail 	= 	remove_special_char(sanitize($conn, $_POST['registerEmail']));
		$sql = "SELECT `email_address` FROM `register_tbl` WHERE email_address = '$regEmail' AND status = '1'";
		$query = execute_query($conn, $sql);

		$count = mysqli_num_rows($query);
		if($count > 0){
			echo "success";
		}
		else{
			echo "fail";
		}
	}
?>