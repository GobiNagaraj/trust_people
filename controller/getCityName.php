<?php 
	include_once '../model/db.php';
	$conn = db_connect();

	$data = array();
	if(isset($_POST['state_id'])){
		$stateId = $_POST['state_id'];
		$showCity = execute_query($conn, "SELECT city_id, city_name, city_code FROM `company_cities_tbl` WHERE status = '1' AND city_code = '$stateId'");
		if(mysqli_num_rows($showCity) > 0){
			while($r = mysqli_fetch_assoc($showCity)){
				$data[] = $r;
			}
			echo json_encode($data);
		}
	}

?>