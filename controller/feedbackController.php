<?php 
	include_once '../model/db.php';
	$conn = db_connect();

	if(isset($_POST['update_feedback'])){
		$userId 	 = 		$_POST['feedback_user_id'];
		$title		 =		remove_special_char(sanitize($conn, $_POST['feedback_title']));
		$description = 		remove_special_char(sanitize($conn, $_POST['feedback_description']));

		$sendFeedback = execute_query($conn, "INSERT INTO `feedback_tbl` (`feedback_title`, `feedback_description`, `posted_by`) VALUES ('$title', '$description', '$userId')");

		$selectUser = execute_query($conn, "SELECT first_name, last_name FROM `register_tbl` WHERE register_id = '$userId'");
		while($row = mysqli_fetch_assoc($selectUser)){
			$first_name = $row['first_name'];
			$last_name = $row['last_name'];
		}
		$emailAddress = 'support@trustpeople.io';

		if($sendFeedback){
			$to = $emailAddress;
			$subject = "Feedback Details Trustpeople.io";

			$message = "
			<html>
			<head>
			<title>Feedback Details Trustpeople!</title>
			</head>
			<body>
			<div style='border: 1px solid #000; padding: 20px; width: 85%;'>
			<center><img src='https://trustpeople.io/assets/images/trust_people.png' alt='TRUST-PEOPLE'></center>
			<br><br>
			<table cellspacing='10' frame='box' style='text-align: left;'>
			<tr>
			<th>From :</th>
			<td>" .$first_name. " ". $last_name ."</td>
			</tr>
			<tr>
			<th>Email Address :</th>
			<td>" .$email_address. "</td>
			</tr>
			<tr>
			<th>Title :</th>
			<td>" .$title. "</td>
			</tr>
			<tr>
			<th>Description :</th>
			<td>" .$description. "</td>
			</tr>
			</table>
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
				$_SESSION['success'] = 'Your feedback have been submitted successfully!';
				header('Location: ../view/profile/?userId='.$userId.'&sts=feedback');
			}else{
				$_SESSION['error'] = 'Mail not sent.';
				header('Location: ../view/profile/?userId='.$userId.'&sts=feedback');
			}
		}else{
			$_SESSION['error'] = 'Something went wrong!';
			header('Location: ../view/profile/?userId='.$userId.'&sts=feedback');
		}
	}
 
?>