<?php 
	include_once 'setup.php';

	$output = array('file' => false);

	function check_input($data){
		$data = trim($data);
		$data = htmlspecialchars($data);
		$data = stripcslashes($data);
		return $data;
	}

	
	$userImage = check_input($_POST['file']);

	if(isset($_GET['action'])){
		$action = $_GET['action'];
	}

	if($action == 'profilePhoto'){
		$sql = pg_query($conn, "SELECT * FROM image_upload ");
		$files = array();
		while($row = pg_fetch_assoc($sql)){
			array_push($files, $row);
		}
		$output['files'] = $files;
	}

	if($userImage == ''){
		$output['file'] = true;
		$output['message'] = 'Image is Required!';
	}

	else{
		// File name
		$filename = $_FILES['file']['name'];

		// Valid file extensions
		$valid_extensions = array("jpg","jpeg","png","pdf", "jfif");

		// File extension
		$extension = pathinfo($filename, PATHINFO_EXTENSION);

		// Check extension
		if(in_array(strtolower($extension),$valid_extensions) ) {

		   // Upload file
		   if(move_uploaded_file($_FILES['file']['tmp_name'], "uploads/".$filename)){
		      echo 1;
		   }else{
		      echo 0;
		   }
		}else{
		   echo 0;
		}

		$sql = <<<EOF
			INSERT INTO image_upload (userimage) VALUES ('$filename');
		EOF;
		$result = pg_query($conn, $sql);

		if($result){
			$output['message']='Form Submitted Successfully!';
		}else{
			$output['message']='Something went to wrong!';
		}		
	}

	header("Content-type: application/json");
	echo json_encode($output);
	die();

?>