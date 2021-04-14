<?php 
	include_once '../../model/db.php';
	$conn = db_connect();

	$user_id = 	$_SESSION['data']['register_id'];

	$selectNav = execute_query($conn, "SELECT first_name, last_name, user_image, flag FROM `register_tbl` WHERE register_id = '$user_id'");

	while($rows = mysqli_fetch_assoc($selectNav))
	{
  		$first_name 	= 	$rows['first_name'];
  		$last_name 		= 	$rows['last_name'];
  		$user_image 	= 	$rows['user_image'];
  		$flag 			=	$rows['flag'];
  	}
  	
	$showFollowerCnt = execute_query($conn, "SELECT COUNT(followers) AS showFollowers FROM `social_details_tbl` WHERE register_id = '$user_id' AND follower_status = '0'");
	while($showCnt = mysqli_fetch_array($showFollowerCnt)){ $showCount = $showCnt['showFollowers']; }

	$getFollowerRequest = execute_query($conn, "SELECT S.followers AS follower, S.user_id AS followerId, S.register_id AS followingRegId, S.follower_status, R.register_id, R.first_name AS followerFname, R.last_name followerLname, R.user_image AS userImage FROM `social_details_tbl` AS S JOIN `register_tbl` AS R ON R.register_id = S.user_id WHERE R.status = '1' AND S.follower_status = '0' AND S.register_id = '$user_id'");
?>

<style type="text/css">
	.badge-notify{
	   background: #da534f;
	   position:relative;
	   top: -12px;
	   left: -16px;
	}
	.logo-img{
		width: 37%;
    	margin-top: -11px;
	}
</style>
<div class="topnav" id="myTopnav">
  <!-- <a href="#"> -->
  	<!-- <?php 
  	$userFlag = $_SESSION['data']['flag'];
  	if($userFlag == '1'){ ?>
  		<img src="../../assets/images/trustpeople_logo_png.png" alt="trust_people_logo" class="nav_logo">
	<?php }else{ ?>
		<img src="../../assets/images/trustpeople_logo_png.png" alt="trust_people_logo" class="nav_logo">
	<?php } ?> -->
	<a class="navbar-brand" href="../home/" style="color: #fff;"><img src="../../assets/images/trust_people_logo.png" alt="Trust-People-Logo" class="logo-img"></a>  		
  <!-- </a> -->
	<!-- <div class="dropdown">
	    <button class="dropbtn">
	      <i class="fa fa-caret-down"></i>
	    </button>
	    <div class="dropdown-content">
	      <a href="../../" class="web-logout">Logout</a>
	      <div class="dropdown-divider" style="border-bottom: 1px solid #d8d8d8;"></div>
	      <a href="../../" class="web-logout">Deactivate my account</a>
	    </div>
	</div> --> 

	<div class="dropdown btn-group mobile-dp-logout">
		<a href="#" class="nav_lbl dropbtn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-caret-down mb-view-dp"></i></a>
	    <div class="dropdown-menu settings-dropdown">
  	        <a href="../../logout.php" class="web-logout" style="width: 100%;">Logout</a>
	    </div>
	</div>
  <?php 
	if($user_image == NULL){ ?>
	<a href="../profile/?userId=<?php echo base64_encode($user_id); ?>" class="imageA"><img class="userImg" src="../../userImage/user.png" alt="<?php echo $first_name."-".$last_name; ?>">&nbsp;&nbsp;<?php echo ucfirst($first_name). " " .ucfirst($last_name); ?></a>
	<?php
		}else{ ?>
	<a href="../profile/?userId=<?php echo base64_encode($user_id); ?>" class="imageA"><img class="userImg" src="../../userImage/<?php echo $user_image; ?>" alt="<?php echo $first_name."-".$last_name; ?>">&nbsp;&nbsp;<?php echo ucfirst($first_name). " " .ucfirst($last_name); ?></a>
	<?php } ?>

	<div class="dropdown btn-group mobile-notification">
		<a href="#" class="nav_lbl dropbtn" <?php if($showCount != 0){ ?>data-toggle="dropdown"<?php } ?> aria-haspopup="true" aria-expanded="false"><i class="fa fa-bell"></i> <?php if($showCount != 0){ ?><span class="badge badge-notify" style="font-size:10px;"><?php echo $showCount; ?></span><?php } ?></a>
	    <div class="dropdown-menu notification-dropdown">
	    	<div style="text-align: center;color: #1f4177;padding: 5px;">Connection Request List</div>
	    	<div class="dropdown-divider" style="border-bottom: 1px solid #d8d8d8;"></div>
	    	<?php 
	  			while($followerReq = mysqli_fetch_assoc($getFollowerRequest)){
	  				$image = $followerReq['userImage'];
	  			if($image == NULL){
	  				$image = "user.png";
	  			}else{
	  				$image = $image;
	  			}
	  		?>
	        <div class="notify"><a href="../profile/userProfile.php?regId=<?php echo $followerReq['register_id'] ?>"><img src="../../userImage/<?php echo $image; ?>" alt="<?php echo $followerReq['followerFname']. " ".$followerReq['followerLname']; ?>" class="notify-drop-img"> &nbsp;<span class="notify-drop-name" style="margin: 0px;"><?php echo $followerReq['followerFname']. " ".$followerReq['followerLname']; ?></span></a><button style="float: right; margin: -30px 70px; " class="accept_fol_request btn-primary" data-userid="<?php echo $followerReq['followerId'] ?>" data-regid="<?php echo $followerReq['followingRegId'] ?>" data-reqsts='1'>Accept</button> <button style="float: right; margin: -30px 8px;" class="cancel_fol_request btn-default" data-userid="<?php echo $followerReq['followerId'] ?>" data-regid="<?php echo $followerReq['followingRegId'] ?>" data-reqsts='0'>Decline</button></div>
	        <div class="dropdown-divider" style="border-bottom: 1px solid #d8d8d8;"></div>
	    <?php } ?>
	    </div>
	</div>

	<a href="../home/" class="mobile-home">Home </a>
	<a href="../../logout.php" class="mobile-logout">Logout</a>
  	<a href="javascript:void(0);" style="font-size:20px; color: #fff !important;" class="icon" onclick="myFunction()">&#9776;</a>
</div>

<script>
	/*$(document).ready(function(){
        setInterval(function() {
            $("#myTopnav").load("../header/nav_bar.php");
        }, 10000);
    });*/

	function myFunction() {
	  var x = document.getElementById("myTopnav");
	  if (x.className === "topnav") {
	    x.className += " responsive";
	  } else {
	    x.className = "topnav";
	  }
	}

	$(document).ready(function(){
		function getData(){
			$.ajax({
				type: 'post',
				url: '../header/notify.php',
				success: function(data){
					#("#mobile-notification").html(data);
				}
			})
		}

		getData();
		setInterval(function(){
            getData(); 
        }, 1000);
	});
</script>