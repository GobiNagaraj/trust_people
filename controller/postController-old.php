<?php 
	include_once '../model/db.php';

	$conn = db_connect();
	/*if(isset($_POST['post_now']))
	{*/
		$firstName		=		sanitize($conn, $_POST['post_first_name']);
		$lastName 		=		sanitize($conn, $_POST['post_last_name']);
		$title 			=		sanitize($conn, $_POST['title_discussion']);
		$jobLocation 	=		sanitize($conn, $_POST['job_location']);
		$jobRole 		=		sanitize($conn, $_POST['job_role']);
		$linkedUrl		=		sanitize($conn, $_POST['linked_url']);
		//$dateBackout	=		sanitize($conn, $_POST['date_back_out']);
		$rating 		=		sanitize($conn, $_POST['rating_val']);
		$details 		=		sanitize($conn, $_POST['details']);
		$status			=		'1';
		$userId			=		$_POST['user_id'];
		$flag 			=		$_POST['user_flag'];

		//$dateFormat     = 	strtotime($dateBackout);
		//$backOutDate	=	date("m/d/Y", $dateFormat);

		$type = explode('.', $_FILES['resume']['name']);
		$type = $type[count($type) - 1];
		$fileName = uniqid(rand()) . '.' .$type;
		$url = '../resumeFiles/' . $fileName;

		if($_FILES['resume']['name'] == ''){
			$fileName = '';
		}
		
		move_uploaded_file($_FILES["resume"]["tmp_name"], $url);

		$sql = "INSERT INTO `post_details_tbl` (`post_first_name`, `post_last_name`, `title_discussion`, `job_location`, `job_role`, `linked_url`, `date_back_out`, `ratings`, `backout`, `resume`, `details`, `created_by`, `status`) VALUES ('".$firstName."', '".$lastName."', '".$title."', '".$jobLocation."', '".$jobRole."', '".$linkedUrl."', '', '".$rating."', '', '".$fileName."', '".$details."', '".$userId."', '".$status."')";
		$result = execute_query($conn, $sql);

		//$selectFlag = execute_query($conn, "SELECT `flag` FROM `register_tbl` WHERE register_id = '$userId'");

		if($result)
		{			
			$_SESSION['success'] = 'Your post has been posted successfully';
			header('Location: ../view/home/');
		}
		else{
			$_SESSION['error'] = 'Something went wrong!';
			header('Location: ../view/home/');
		}
		/*if (move_uploaded_file($_FILES["resume"]["tmp_name"], $url)) 
		{
	        $sql = "INSERT INTO `post_details_tbl` (`title_discussion`, `job_location`, `job_role`, `linked_url`, `date_back_out`, `backout`, `resume`, `details`, `created_by`, `status`) VALUES ('".$title."', '".$jobLocation."', '".$jobRole."', '".$linkedUrl."', '".$backOutDate."', '".$backout."', '".$fileName."', '".$details."', '".$userId."', '".$status."')";
			$result = execute_query($conn, $sql);

			$selectFlag = execute_query($conn, "SELECT `flag` FROM `register_tbl` WHERE register_id = '$userId'");

			if($result){
				while($row = mysqli_fetch_assoc($selectFlag))
				{
					if($row['flag'] == '1')
					{
						$_SESSION['success'] = 'Your post successfully posted!';
						header('Location: ../view/home/homeEnterprise.php');
					}
					elseif($row['flag'] == '2')
					{
						$_SESSION['success'] = 'Your post successfully posted!';
						header('Location: ../view/home/homeIndividual.php');
					}
					$_SESSION['success'] = 'Your post successfully posted!';
					header('Location: ../view/home/');
				}
			}
			else{
				$_SESSION['error'] = 'Something went wrong!';
				header('Location: ../view/home/');
			}
	    } 
	    else 
	    {
	    	$_SESSION['error'] = 'Sorry, there was an error uploading your file.!';
			header('Location: ../view/home/');
	   	}*/
	/*}*/

?>