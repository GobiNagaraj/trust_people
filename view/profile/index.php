<?php 
	include_once '../../model/db.php';
	$conn = db_connect();

	$userId = $_SESSION['data']['register_id'];
    if($userId == null)
  	{
    	header('Location: ../../');
  	}	

  	$encryptedUserId = encrypt_decrypt($userId);
  	$encryptedUserId = $encryptedUserId['encrypted'];

  	$decryptedUserId = encrypt_decrypt($encryptedUserId);
  	$decryptedUserId = $decryptedUserId['decrypted'];

	if(isset($decryptedUserId))
	{
	  	$user_id = $decryptedUserId;

	  	$sql = "SELECT R.register_id, R.first_name, R.last_name, R.reg_title_id, R.title, R.email_address, R.country_code, R.mobile_number, R.user_image, R.company_name, R.company_website, R.company_state_id, R.company_city_id, R.company_address, R.created_at, R.mobile_privacy, R.email_privacy, U.about_info, U.description, T.title_name FROM `register_tbl` AS R LEFT JOIN `user_personal_details_tbl` AS U ON U.register_id = R.register_id LEFT JOIN `title_tbl` AS T ON T.title_id = R.reg_title_id WHERE R.register_id = '$user_id' AND R.status = '1'";

	  	$query = execute_query($conn, $sql);
	  	while($row = mysqli_fetch_assoc($query))
	  	{
	  		$registerId 	=	$row['register_id'];
	  		$firstName 		= 	$row['first_name'];
	  		$lastName 		= 	$row['last_name'];
	  		$reg_title_id 	=	$row['reg_title_id'];
	  		$designation	=	$row['title'];
	  		$titleName 		=	$row['title_name'];
	  		$userImage 	    = 	$row['user_image'];
	  		$email 			=	$row['email_address'];
	  		$cntryCode 		=	$row['country_code'];
	  		$mobileNumber   = 	$row['mobile_number'];
	  		$companyName 	= 	$row['company_name'];
	  		$website 		=	$row['company_website'];
	  		$cmpState 		=	$row['company_state_id'];
	  		$cmpCity 		=	$row['company_city_id'];
	  		$companyAddress = 	$row['company_address'];
	  		$mobilePrivacy  = 	$row['mobile_privacy'];
	  		$emailPrivacy   = 	$row['email_privacy'];
	  		$createdAt 		= 	$row['created_at'];
	  		$abtInfo 		= 	$row['about_info'];
	  		$description 	=	$row['description'];
	  	}

	  	$abtInfos = explode("-", $abtInfo);
	  	$information = implode("/", $abtInfos);

	  	$getPostCnt = execute_query($conn, "SELECT COUNT(`post_id`) AS posts FROM post_details_tbl JOIN register_tbl ON register_tbl.register_id = post_details_tbl.created_by WHERE post_details_tbl.created_by = '$user_id' AND post_details_tbl.job_location_country = 'US' AND post_details_tbl.status='1'");
	  	while($post = mysqli_fetch_assoc($getPostCnt)){
	  		$postCnt 		= 	$post['posts'];
	  	}

	  	$getFollowersCnt = execute_query($conn, "SELECT COUNT(`followers`) AS followers FROM social_details_tbl JOIN register_tbl ON social_details_tbl.user_id = register_tbl.register_id WHERE social_details_tbl.register_id = '$user_id' AND social_details_tbl.follower_status = '1'");
	  	while($followers = mysqli_fetch_assoc($getFollowersCnt)){
	  		$followersCnt 		= 	$followers['followers'];
	  	}

	  	$getFollowingCnt = execute_query($conn, "SELECT COUNT(`followers`) AS following FROM social_details_tbl JOIN register_tbl ON register_tbl.register_id = social_details_tbl.user_id WHERE social_details_tbl.user_id = '$user_id' AND social_details_tbl.follower_status = '1'");
	  	while($following = mysqli_fetch_assoc($getFollowingCnt)){
	  		$followingCnt 	=	$following['following'];
	  	}
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Trust People Home Page</title>
	<link rel="shortcut icon" type="image/x-icon" href="../../assets/images/fav-icon.png"/>
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<link rel="stylesheet" type="text/css" href="../../assets/css/bootstrap.min.css">
	<script src="../../assets/js/jquery.min.js"></script>
	<script src="../../assets/js/bootstrap.min.js"></script>

	<link href="../../assets/css/font-awesome.css" rel="stylesheet" type="text/css" />
	<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,300italic,regular,italic,600,700,700italic" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Arimo" rel="stylesheet">
	<!-- custom css -->
	<link rel="stylesheet" type="text/css" href="../../assets/css/custom.css">
	<link rel="stylesheet" type="text/css" href="../../assets/css/profile-tabs.css">
	<link rel="stylesheet" type="text/css" href="../../assets/css/edit-profile.css">

	<script>
	    $(document).ready(function(){
	        $('[data-toggle="tooltip"]').tooltip();
	    });
	</script>
	<!-- Google Tag Manager -->

	<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
	new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
	j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
	'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
	})(window,document,'script','dataLayer','GTM-K8DR8QW');</script>

	<!-- End Google Tag Manager -->
</head>
<body style="font-family: Source Sans Pro;">
	<!-- Google Tag Manager (noscript) -->

	<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-W2TTP85"
	height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>

	<!-- End Google Tag Manager (noscript) -->
	<style>
		.collapsible {
		  cursor: pointer;
		}
		.content {
	        padding: 0 18px;
	        display: none;
	        overflow: hidden;
	        border: 1px solid #f1f1f1;
	        padding: 5px;
	        width: 220%;
	        margin: 10px -495px;
	    }

	    *{
		    margin: 0;
		    padding: 0;
		}
		.rate {
		    float: left;
		    height: 35px;
		    margin-left: 65px;
		}
		.rate:not(:checked) > input {
		    position:absolute;
		    top:-9999px;
		}
		.rate:not(:checked) > label {
		    float:right;
		    width:1em;
		    overflow:hidden;
		    white-space:nowrap;
		    cursor:pointer;
		    font-size:25px;
		    color:#ccc;
		}
		.rate:not(:checked) > label:before {
		    content: '★ ';
		}
		.rate > input:checked ~ label {
		    color: #ffc400;    
		}
		.rate:not(:checked) > label:hover,
		.rate:not(:checked) > label:hover ~ label {
		    color: #ffc400;  
		}
		.rate > input:checked + label:hover,
		.rate > input:checked + label:hover ~ label,
		.rate > input:checked ~ label:hover,
		.rate > input:checked ~ label:hover ~ label,
		.rate > label:hover ~ input:checked ~ label {
		    color: #ffc400;
		}
		.star{ margin: 0px !important; }
		.modal{ top: 30px !important; }
	</style>

	<div class="">
		<?php include_once '../common-popup.php'; ?>
		<?php include_once '../header/nav_bar.php'; ?>
		<center><div class="container">
		<?php 
	        if (isset($_SESSION['success'])) 
	          {
	            switch ($_SESSION['success']) 
	            {
	                case $_SESSION['success']: 
	                echo "<script type='text/javascript'>
						$(document).ready(function(){
							$('.commonPopup').modal('show');
							$('.header-msg').html('Success Message');
							$('.content-msg').css('color', '#0045ab').html('".$_SESSION['success']."');
							$('.commonPopup').fadeOut(3000);
						});
					  </script>";
					unset($_SESSION['success']);
	                break;
	            }
	    	  }

	    	if (isset($_SESSION['error'])) 
	          {
	            switch ($_SESSION['error']) 
	            {
	                case $_SESSION['error']: 
	                echo "<script type='text/javascript'>
						$(document).ready(function(){
							$('.commonPopup').modal('show');
							$('.header-msg').html('Error Message');
							$('.content-msg').css('color', 'red').html('".$_SESSION['error']."');
							$('.commonPopup').fadeOut(3000);
						});
					  </script>"; 
					unset($_SESSION['error']);
	                break;
	            }
	    	  }
	    ?>
	    </div></center>
	</div>

	<div class="main">
		<div class="container">
			<div class="row">
			<div class="col-md-12 profileDiv">
				<div class="col-md-3 mobileProfile">
				<a class="update updateImage" href="#updateImage" data-toggle="modal" data-id="<?php echo $userId; ?>">
					<?php 
						if($userImage == NULL){ ?>
					<img class="profileImg" src="../../userImage/user.png">
					<?php
						}else{ ?>
					<img class="profileImg" src="../../userImage/<?php echo $userImage; ?>">
					<?php
						}
					?>
				</a>
					<br>
					<?php 
						$date = strtotime($createdAt);
						$createdDate = date("F Y", $date);
					?>
					<!-- - Joined <?php echo $createdDate; ?> <br><br> -->
					<!-- <a href="" class="btn btn-info btn-sm"> Follow</a> &nbsp;&nbsp;&nbsp;
					<a href="" class="btn btn-info btn-sm"> Message</a> -->
				</div>
				<div class="col-md-9">
					<!-- <a href="editProfile.php?userId=<?php echo $userId; ?>" class="pull-right" style="color: rgb(33, 150, 243);text-decoration: none;">Edit Profile</a> -->
					<h3 class="h3Profile"><?php echo ucfirst($firstName). " ".ucfirst($lastName); ?></h3>
					<h4><?php echo $information; ?></h4>
					<div class="col-md-6">
						<?php if($mobileNumber != ''){ ?><h4>Mobile Number : <?php echo $cntryCode; ?> - <?php echo $mobileNumber; ?></h4> <?php } ?>
					</div>
					<div class="col-md-6">
						<?php if($email != ''){ ?><h4>Email ID : <?php echo $email; ?></h4> <?php } ?>
					</div>
					<input type="hidden" id="post_count" value="<?php echo $postCnt; ?>">
					<h2 class="profileH2"><i class="fa fa-paper-plane"></i> Posts - <span id="totalPost"><?php echo $postCnt; ?></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-users"></i> Connections - <span id="totalFollowers"><?php echo $followersCnt; ?></span><!-- &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-user-plus"></i> Connected - <span id="totalFollowing"><?php echo $followingCnt; ?></span> --></h2>
				</div>
			</div>
			<br><br>
			<div role="tabpanel">

			  <!-- Nav tabs -->
			  <ul class="nav nav-tabs nav-justified nav-tabs-dropdown profile-dropdown" role="tablist">
			    <li role="presentation" class="li-posts"><a href="#post" aria-controls="post" role="tab" data-toggle="tab">My Posts</a></li>
			    <li role="presentation" class="li-profile"><a href="#profiles" aria-controls="profiles" role="tab" data-toggle="tab">Profile</a></li>
			    <li role="presentation" class="li-request"><a href="#requests" aria-controls="requests" role="tab" data-toggle="tab">Connections</a></li>
			  </ul>

			  <!-- Tab panes -->
			  <div class="tab-content">
			    <div role="tabpanel" class="tab-pane tab-post" id="post">
			    <span id="empty_post"><h4 style="text-align: center;">There is no posts</h4></span>
			    <div id="load_data_profile"></div>
			    <br>
			    <div id="load_data_profile_message"></div>	
				</div>
				    <?php 
						$showFollowerCnt = execute_query($conn, "SELECT COUNT(followers) AS showFollowers FROM `social_details_tbl` WHERE register_id = '$userId' AND follower_status = '0'");
						while($showCnt = mysqli_fetch_array($showFollowerCnt)){ $showCount = $showCnt['showFollowers']; }
					?>
					<?php 
						if(isset($_GET['sts'])){
							$showRequest = $_GET['sts'];
						}else{
							$showRequest = "";
						}
					?>
					<input type="hidden" id="show_request" value="<?php echo $showRequest; ?>">
			    <div role="tabpanel" class="tab-pane tab-profiles" id="profiles">
			    	<div class="tab">
					  <button class="tablinks information" onclick="openCity(event, 'info')" id="defaultOpen">Personal Information </button>
					  <button class="tablinks education" onclick="openCity(event, 'education')">Company Details </button>
					  <button class="tablinks password" onclick="openCity(event, 'account-settings')">Account Settings </button>
					  <button class="tablinks feedback" onclick="openCity(event, 'feedback')">Feedback </button>
					  <!-- <button class="tablinks delete-account" onclick="openCity(event, 'deleteaccount')">Delete My Account <span class="pull-right"> ></span></button> -->
					</div>

					<div id="info" class="tabcontent">
					  	<form class="abt_form" method="POST" action="../../controller/profileController.php">
					  	<input type="hidden" name="abt_user_id" value="<?php echo $userId; ?>">
					  	<h3 class="abt_lbl">Personal Information</h3>
					  	<div class="col-md-12" style="margin-top: 15px;">
						  	<div class="col-md-3 form-group">
						  		<label>Joined Date :</label>
						  	</div>
						  	<div class="col-md-9 form-group">
						  		<input type="text" name="date_of_joined" title="Joined Date" data-toggle="tooltip" value="<?php echo $createdDate; ?>" class="form-control doj-profile mobile-view-txt" readonly>
						  	</div>
					  	</div>
					  	<div class="col-md-12">
					  		<div class="col-md-4">
						  		<label>Contact Number :</label>
						  	</div>
					  		<div class="col-md-3">
					  			<?php 
					  			if($cntryCode == ''){
					  				$cntryCode = "";
					  			}else{
					  				$cntryCode = $cntryCode;
					  			}
					  			$selected = '';
					  			if($cntryCode == '+91'){
					  				$selected = "Selected";
					  			}else{
					  				$selected = "";
					  			}

					  			?>
						  		<select name="mobile_country_code" id="mobile_country_code" class="form-control mobile_country_code mobile-view-txt">
								<option data-countryCode="US" value="1" <?php echo $selected; ?>>United States (+1)</option>
								<option data-countryCode="IN" value="91" <?php echo $selected; ?>>India (+91)</option>
								<optgroup label="Other countries">
									<?php 
								  		$getCountry = execute_query($conn, "SELECT * FROM `country_list_tbl` WHERE status = '1'");
								  		while($country = mysqli_fetch_assoc($getCountry)){
								  	?>
									<option data-countryCode="<?php echo $country['country_code']; ?>" value="<?php echo $country['country_code_value']; ?>" <?php if($country['country_code_value'] == $cntryCode): ?> selected="selected" <?php endif; ?>><?php echo $country['country_code_name']. "(+".$country['country_code_value']. ")" ?></option>
								<?php }?>
								</optgroup>
								</select>
							</div>
							<div class="col-md-3">
				            	<input type="text" name="mobilenumber" minlength="10" maxlength="15" autocomplete="off" id="mobilenumber" class="form-control mobilenumber mobile-view-txt" value="<?php echo $mobileNumber; ?>" placeholder="Contact Number"data-toggle="tooltip" title="Mobile Number">
				            	<span class="check_mobile"></span>
				            </div>
				            <div class="col-md-2 mobile-auth">
				            	<?php 
				            	if($mobilePrivacy == 1){
				            		$checked = 'checked';
				            		$value = '1';
				            	}else{
				            		$checked = '';
				            		$value = '0';
				            	}
				            	?>
				            	<input type="hidden" name="mobile_privacy" id="mobile_privacy_val" value="<?php echo $value; ?>">
				            	<input type="checkbox" <?php echo $checked; ?> class="mobile_privacy"> Make Public
				            </div>
					  	</div>
					  	<div class="col-md-12">
					  		<div class="col-md-4">
					  			<label>Status :</label>
					  		</div>
					  		<div class="col-md-6 your-status">
					  			<textarea class="abt_info_box abt-status-box" name="about_information" rows="6" cols="6" placeholder="Enter your status with '-' (ex: Project Manager - Developer - Java)" data-toggle="tooltip" title="Status"><?php if(empty($abtInfo)){ echo ""; }else{ echo $abtInfo; } ?></textarea>
					  		</div>
					  	</div>
					  	<input type="submit" name="about_info" value="Update" class="btn btn-lg btn-info about_info_btn">
					  </form>
					</div>

					<div id="education" class="tabcontent">
					  <form class="abt_form tab-form" method="POST" action="../../controller/profileController.php">
					  	<input type="hidden" name="company_user_id" value="<?php echo $userId; ?>">
					  	<h3 class="abt_lbl">Company Details</h3>
					  	<?php 
					  		if($reg_title_id == '6'){
					  			$titleName = $titleName;
					  		}else{
					  			$titleName = '';
					  		}

					  		/*if($reg_title_id == ''){
								$reg_title_id = '5';
							}else{
								$reg_title_id = $reg_title_id;
							}*/

							if($designation == ''){
								$designation = $titleName;
							}else{
								$designation = $designation;
							}
						?>
						<div class="col-md-12 form-group">
							<div class="col-md-4">
								<label class="title-lbl">Designation :</label>
							</div>
							<div class="col-md-4">
								<select class="form-control edit-title mobile-view-txt" id="title_id" name="title_id" required>
									<?php 
										$title = execute_query($conn, "SELECT title_id, title_name FROM `title_tbl` WHERE status = '1'");
										while($getTitle = mysqli_fetch_assoc($title)){
											$titleID = $getTitle['title_id'];
											$titleNAME = $getTitle['title_name'];
									?>
									<option value="<?php echo $titleID; ?>" <?php if($titleID == $reg_title_id): ?> selected="selected" <?php endif; ?>><?php echo $titleNAME; ?></option>
								<?php } ?>
								</select>
							</div>
							<div class="col-md-4 title-div">
								<input type="text" name="designation" value="<?php echo $designation; ?>" placeholder="Designation" id="title_name" class="form-control edit-title-name mobile-view-txt" data-toggle="tooltip" title="Designation / Title">	
							</div>
						</div>
						<div class="col-md-12 form-group">
							<div class="col-md-6">
								<label>Business Email :</label>
							</div>
							<div class="col-md-4">
					  			<input type="text" name="working" value="<?php echo $email; ?>" placeholder="Email Address" class="form-control editProfile mobile-view-txt" data-toggle="tooltip" title="Business email" readonly>
					  		</div>
					  		<div class="col-md-2 email-auth">
					  			<?php 
				            	if($emailPrivacy == 1){
				            		$checked = 'checked';
				            		$value = '1';
				            	}else{
				            		$checked = '';
				            		$value = '0';
				            	}
				            	?>
				            	<input type="hidden" name="email_privacy" id="email_privacy_val" value="<?php echo $value; ?>">
				            	<input type="checkbox" class="email_privacy" <?php echo $checked; ?>> Make Public
				            </div>
					  	</div>
					  	<div class="col-md-12 form-group">
					  		<div class="col-md-6">
								<label>Company Name :</label>
							</div>
							<div class="col-md-6">
					  			<input type="text" name="company_name" value="<?php echo $companyName; ?>" placeholder="Company" class="form-control editProfile mobile-view-txt" data-toggle="tooltip" title="Company name" readonly>
					  		</div>
					  	</div>
					  	<div class="col-md-12 form-group">
					  		<div class="col-md-6">
								<label>Company Website :</label>
							</div>
							<div class="col-md-6">
					  			<input type="text" name="company_website" value="<?php echo $website; ?>" placeholder="Company" class="form-control editProfile mobile-view-txt" data-toggle="tooltip" title="Company website" readonly>
					  		</div>
					  	</div>
					  	<div class="col-md-12 form-group">
					  		<div class="col-md-6">
								<label>Company Address :</label>
							</div>
							<div class="col-md-6">
								<textarea class="form-control company_address" name="company_address" rows="6" cols="6" placeholder="Company Address" style="margin-top: 10px; height: 65px;" data-toggle="tooltip" title="Company Address"><?php if(empty($companyAddress)){ echo ""; }else{ echo $companyAddress; } ?></textarea>
					  		</div>
					  	</div>
					  	<div class="col-md-12 form-group">
							<div class="col-md-4">
								<label class="title-lbl">Company Location :</label>
							</div>
							<div class="col-md-4">
								<?php 
								if(isset($cmpState)){
									$cmpState = $cmpState;
								}else{
									$cmpState = '';
								}
								?>
								<input type="hidden" name="company_country" value="1">
								<select class="form-control edit-title mobile-view-txt company_state" id="company_state" name="company_state">
									<option value="">--- Select State ---</option>
									<?php $state = execute_query($conn, "SELECT state_id, state_name, state_code FROM `company_states_tbl` WHERE status = '1'");
										while($getState = mysqli_fetch_assoc($state)){ ?>
									<option value="<?php echo $getState['state_code'];?>" <?php if($cmpState == $getState['state_code']){ ?> selected="selected" <?php } ?>><?php echo $getState['state_name'] ?> (<?php echo $getState['state_code'] ?>)</option>
									<?php } ?>
								</select>
							</div>
							<div class="col-md-4">
								<?php 
								if(isset($cmpCity)){
									$cmpCity = $cmpCity;
								}else{
									$cmpCity = '';
								}
								?>
								<input type="hidden" name="city_cmp_id" value="<?php echo $cmpCity; ?>" id="city_cmp_id">
								<select class="form-control edit-title mobile-view-txt company_city" id="company_city" name="company_city">
									<!-- <option value="">Select City</option> -->
									<!-- <php 
									if(isset($cmpCity)){
										$getCity = execute_query($conn, "SELECT city_id, city_name FROM `company_cities_tbl` WHERE city_id = '$cmpCity'");
										while($cityQuery = mysqli_fetch_assoc($getCity)){
									?>
									<option value="<php echo $cityQuery['city_id']; ?>" <php if($cmpCity == $cityQuery['city_id']){ ?> selected="selected"  <php } ?>><php echo $cityQuery['city_name']; ?></option>
									<php } } ?> -->
								</select>
							</div>
						</div>
					  	<div class="col-md-12 form-group">
					  		<div class="col-md-6">
								<label>Company Description :</label>
							</div>
							<div class="col-md-6">
					  			<textarea class="form-control abt_info_box company-description" name="description" rows="6" cols="6" placeholder="Description" style="margin-top: 10px; height: 100px;" data-toggle="tooltip" title="Description"><?php if(empty($description)){ echo ""; }else{ echo $description; } ?></textarea>
					  		</div>
					  	</div>
					  	<input type="submit" name="update_education_details" value="Update" class="btn btn-lg btn-info about_info_btn update_company">
					  </form>
					</div>

					<div id="account-settings" class="tabcontent">
					  <form class="abt_form" method="POST" action="../../controller/profileController.php">
					  	<input type="hidden" name="password_user_id" id="user_id" value="<?php echo $encryptedUserId; ?>">
					  	<h3 class="abt_lbl">Change Password</h3>
					  	<input type="password" name="current_password" id="current_password" placeholder="Current Password" class="form-control change-password-input" onchange="comparePassword();" required>
					  	<span class="check_old_password"></span>
					  	<input type="password" name="new_password" id="new_password" onKeyUp="checkPasswordStrength();" maxlength="15" placeholder="New Password" class="form-control change-password-input" required>
					  	<div id="password-strength-status"></div>
					  	<input type="submit" name="update_password" id="update_password" value="Update" class="btn btn-lg btn-info about_info_btn">

						<h3 class="abt_lbl">Delete My Account</h3>
				    	<hr>
				    	<h4 class="delete-content">If you delete your Trustpeople account, you won't be able to retrieve the content or posts that you had shared. All your information will be deleted.</h4>
				    	<a href="#" data-toggle="modal" data-target="#deactivateAccount" class="btn btn-sm btn-danger delete-account-btn pull-right">Delete</a>
					  </form>
					</div>

					<!-- Feedback -->
					<div id="feedback" class="tabcontent">
					  <form class="abt_form" method="POST" action="../../controller/feedbackController.php">
					  	<input type="hidden" name="feedback_user_id" id="user_id" value="<?php echo $userId; ?>">
					  	<h3 class="abt_lbl">Feedback</h3>
					  	<br>
					  	<div class="col-md-12 form-group">
					  		<div class="col-md-5">
								<label>Title :</label>
							</div>
							<div class="col-md-7 feedback-txt-div">
					  			<input type="text" name="feedback_title" placeholder="Feedback Title" class="form-control editProfile mobile-view-txt" data-toggle="tooltip" title="Feedback Title" required>
					  		</div>
					  	</div>
					  	<div class="col-md-12 form-group">
					  		<div class="col-md-5">
								<label>Description :</label>
							</div>
							<div class="col-md-7 feedback-txt-div">
					  			<textarea name="feedback_description" class="form-control feedback_description" id="feedback_description" rows="6" cols="6" data-toggle="tooltip" title="Feedback Description" placeholder="Feedback Description" required></textarea>
					  		</div>
					  	</div>
					  	<input type="submit" name="update_feedback" id="update_feedback" value="Submit" class="btn btn-lg btn-info about_info_btn">
					  </form>
					</div>

			    </div>
	
			    <div role="tabpanel" class="tab-pane tab-request" id="requests">
					  <div class="abt_form">
					  	<input type="hidden" name="user_id" id="user_id" value="<?php echo $userId; ?>">
					  	<h3 class="abt_lbl">My Connections</h3>
					  	<?php 
						  	$showFollower = execute_query($conn, "SELECT R.`register_id`, R.`first_name`, R.`last_name`, R.`user_image` FROM social_details_tbl AS S JOIN register_tbl AS R ON S.user_id = R.register_id WHERE S.register_id = '$userId' AND S.follower_status = '1'");
						  	if(mysqli_num_rows($showFollower) > 0){
						  		while($follower = mysqli_fetch_assoc($showFollower)){
				  				$image = $follower['user_image'];

					  			if($image == NULL){
					  				$image = "user.png";
					  			}else{
					  				$image = $image;
					  			}
						?>
						<div class="col-md-9 pull-right connection-div" style="margin: 15px;">
					  		<div class="col-md-2" style="margin-top: -10px;">
					  			<a href="userProfile.php?regId=<?php echo base64_encode($follower['register_id']); ?>"><img src="../../userImage/<?php echo $image; ?>" alt="<?php echo $follower['first_name']. " ".$follower['last_name']; ?>" class="notifyImg"></a>
					  		</div>
					  		<div class="col-md-4 name-connection">
					  			<?php echo $follower['first_name']. " ".$follower['last_name']; ?>
					  		</div>
					  		<div class="col-md-3 remove-connection">
					  			<a href="#" data-toggle="modal" data-userid="<?php echo $user_id; ?>" data-registerid="<?php echo $follower['register_id']; ?>" data-removeconn="1" data-target="#removeConnection" class="btn btn-xs btn-primary pull-right remove_connection_btn"> <i class="fa fa-user-times"></i> Remove</a>
					  			<!-- <a href="#" data-userid="<?php echo $user_id; ?>" data-registerid="<?php echo $follower['register_id']; ?>" data-removeconn="1" class="btn btn-primary btn-xs remove_connection_btn"> <i class="fa fa-user-times"></i> Remove</a> -->
					  			<!-- <a href="userProfile.php?regId=<?php echo $follower['register_id']; ?>" class="btn btn-xs btn-info"><i class="fa fa-file"></i> View</a> -->
					  		</div>
				  		</div>
				  		<hr class="request-hr">
					  	<?php } }else{ echo "<h4 style='text-align: center;'>You have no connections yet</h4>"; } ?>
					  </div>
			    </div>

	<!-- Modal -->
	<div id="deactivateAccount" class="modal fade" role="dialog">
	  <div class="modal-dialog">
	    <!-- Modal content-->
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal">&times;</button>
	        <span class="forgot-header">Delete account?</span>	
	      </div>
	      <div class="modal-body">
	      	<div class="form-group">
	      		<span style="color: #0045ab;font-size: 16px;">Are you sure want to delete your account?</span>
	      		<input type="hidden" name="deactivate_account" id="deactivate_account" value="<?php echo $encryptedUserId; ?>">
	      	</div>
	      </div>
	        <div class="modal-footer">
		      	<input type="submit" id="deactivate" value="Delete" name="deactivate" class="btn btn-danger">
		        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		    </div>
	    </div>
	  </div>
	</div>

	<!-- Delete my post -->
	<div id="deletePost" class="modal fade" role="dialog">
	  <div class="modal-dialog">
	    <!-- Modal content-->
	    <form action="../../controller/postController.php" method="POST">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal">&times;</button>
	        <span class="forgot-header">Delete post?</span>	
	      </div>
	      <div class="modal-body">
	      	<div class="form-group">
	      		<span style="color: #0045ab;font-size: 16px;">Are you sure want to delete your post?</span>
	      		<input type="hidden" name="delete_post" id="delete_post">
	      		<input type="hidden" name="user_id" id="user_id" value="<?php echo $userId; ?>">
	      	</div>
	      </div>
	        <div class="modal-footer">
		      	<input type="submit" id="delete_my_post" value="Delete" name="delete_my_post" class="btn btn-danger">
		        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		    </div>
	    </div>
	    </form>
	  </div>
	</div>

<!-- Edit my post Modal -->
<div id="editPost" class="modal fade bd-example-modal-xl" role="dialog">

  <div class="modal-dialog modal-xl edit-post-modal">
  </div>

</div>

<div class="modal fade postSuccess" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
    <div class="modal-content">
    	<div class="modal-header">
	        <span class="header-msg">Success Message</span>	
	    </div>
      <div class="modal-body">
      	<div class="form-group">
      		<span class="content-msg">Your post have been updated successfully!</span>
      	</div>
      </div>
      	<div class="modal-footer">
	        <button type="button" class="btn btn-info post-success" data-dismiss="modal">Close</button>
	    </div>
    </div>
  </div>
</div>

	<!-- Remove connection details -->
	<!-- Modal -->
	<div id="removeConnection" class="modal fade" role="dialog">
	  <div class="modal-dialog">
	    <!-- Modal content-->
	    <form action="../../controller/profileController.php" method="POST">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal">&times;</button>
	        <span class="forgot-header">Remove connection?</span>	
	      </div>
	      <div class="modal-body">
	      	<div class="form-group">
	      		<span style="color: #0045ab;font-size: 16px;">Are you sure want to remove this connection?</span>
	      		<input type="hidden" name="remove_reg_id" id="remove_reg_id">
	      		<input type="hidden" name="remove_user_id" id="remove_user_id">
	      		<input type="hidden" name="remove_status" id="remove_status">
	      	</div>
	      </div>
	        <div class="modal-footer">
		      	<input type="submit" id="remove" value="Remove" name="remove" class="btn btn-danger">
		        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		    </div>
	    </div>
	    </form>
	  </div>
	</div>

	<div class="modal fade" id="updateImage" tabindex="-1" role="dialog" aria-labelledby="modalConfirmLabel" aria-hidden="true">
      	<div class="modal-dialog">
	        <div class="modal-content">
	        <form role="form" name="update-form" id="update-form" method="post" action="../../controller/profileController.php" enctype="multipart/form-data" onsubmit="document.getElementById('update_image').disabled=true; document.getElementById('update_image').value='Submitting, please wait...';">
	          <div class="modal-header">
	            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	            <h4 class="modal-title thin" id="modalConfirmLabel" style="font-family: Arimo; margin-left: 0px;">Update Profile Picture</h4>
	          </div>
	          <div class="modal-body">
	          	<input type="hidden" autocomplete="off" class="form-control editProfile" id="eImage" name="upload_image_id">
	              <div class="form-group">
	                <label for="eImage" style="font-family: Arimo; margin-left: 0px;">Select Image to Upload </label>
	                <input type="file" name="user_image" id="user_image" class="form-control editProfile" style="margin-left: 0px;" accept="image/*" required>
	                <span class="image_validation"></span>
	              </div>
	          </div>
	          <div class="modal-footer">
	          	<button class="btn btn-primary" type="submit" name="update_image" id="update_image">Update</button>
	            <button class="btn btn-danger" type="button" data-dismiss="modal" aria-hidden="true">Close</button>
	          </div>
	          </form>
	        </div><!-- /.modal-content -->
	      	</div><!-- /.modal-dialog -->
    </div><!-- /.modal --> 
			  </div>
			</div>
		</div>
	</div>
</div>

	<script src="../../assets/js/comments-details.js"></script>
	<script src="../../assets/js/profile-tabs.js"></script>
	<script src="../../assets/js/axios.min.js"></script>
	<script src="../../assets/js/vue.js"></script>

	<script>
		$(document).ready(function(){
			$("#update_password").prop('disabled', true);
		});

		$(".post-success").on('click', function(){
			window.location.href = '';
		});
		
		function add_comment(g){
			var userId = $("#userId_"+g).val();
			var postId = $("#postId_"+g).val();
			var registerId = $("#registerId_"+g).val();
			var commentVal = $("#comments"+g).val(); 

			if(commentVal === ''){
				$("#comments"+g).css("border", "1px solid red").focus();
				return false;
			}
			else{
				$.ajax({
					type: 'POST',
					url: '../../controller/commentsController.php',
					data: { comments: commentVal, userId: userId, postId: postId, registerId: registerId },
					dataType: 'json',
				}).done(function(data){
					//window.location.href = "";
					//console.log(data);
					$("#comments"+g).val('');
					$(".cmtCount_"+g).html(data.message);
					getPageData(g);
				});
				return true;
			}
		}

		function getPageData(a){
			var postId = $("#postId_"+a).val();
			var userId = $("#userId_"+a).val();
			var status = '1';
			$.ajax({
				type: 'POST',
		    	url: '../../controller/commentsController.php',
		    	data: { status: status, postId: postId, userId: userId },
		    	dataType: 'json',
			}).done(function(data){
				manageRows(data.data,a);
			});
		}

		function manageRows(data,b) {
			//$("#comments"+b).val("");
			var	rows = '';
			var user_image = '';
			$.each( data, function( key, value ) {
				const months = ["January", "February", "March", "April", "May", "June",
				"July", "August", "September", "October", "November", "December"];

				let current_datetime = new Date(value.createdTime)
				var hours = current_datetime.getHours();
				var minutes = current_datetime.getMinutes();
				var ampm = hours >= 12 ? 'pm' : 'am';

				let createdDt = months[current_datetime.getMonth()] + "," +current_datetime.getDate() +  " " + current_datetime.getFullYear() + " " + hours + ":" + minutes + " " + ampm
				
				if(value.userImage == null){
					user_image = 'user.png';
				}else{
					user_image = value.userImage;
				}
				rows = rows + '<div class="col-md-12 commentDiv"><div class="col-md-4">';
				rows = rows + '<img src="../../userImage/'+user_image+'" class="commentsUserImg">&nbsp;&nbsp;<span style="font-size: 11px;">'+value.first_name+' '+value.last_name+'</span>';	
				rows = rows + '</div><div class="col-md-8">';
				rows = rows + '<p class="commentPara">'+value.comments+'</p><span class="pull-right" style="font-size: 11px;">'+createdDt+'</span></div>';
				rows = rows + '</div>';
			});
			$(".commentsDiv_"+b).html(rows);
		}

		function getCommentDiv(i){
			//var user_id = $("#user_id_"+i).val();
			var post_id = $("#postId_"+i).val();
			//var reg_id = $("#register_id_"+i).val();
			var status = '1';
			$.ajax({
				type: 'POST',
		    	url: '../../controller/commentsController.php',
		    	data: { status: status, postId: post_id },
		    	dataType: 'json',
			}).done(function(data){
				console.log(data);
				manageRows(data.data,i);
			});
		}

		$("#update_password").on('click', function(){
			var userId 	= $("#user_id").val();
			var currentPassword = $("#current_password").val();
			
			$.ajax({
				type: 'POST',
				url: '../../controller/checkPassword.php',
				data: { userId: userId, currentPassword: currentPassword},
				dataType: 'json',	
			}).done(function(data){
				var fetchPassword = data.message;
				if(fetchPassword != currentPassword)
				{
					$("#current_password").focus();
					$(".check_old_password").html("Password doesn't match!");
		            $("#current_password").css("border", "1px solid red");
		            return false;
				}else{
					$(".check_old_password").html("");
		            $("#current_password").css("border", "1px solid green");
		            return true;
				}
			});

			var number = /([0-9])/;
		    var alphabets = /([a-zA-Z])/;
		    var special_characters = /([~,!,@,#,$,%,^,&,*,-,_,+,=,?,>,<])/;
		    if($('#new_password').val().length<7) 
	        {
	       		$('#new_password').focus();
	     	    $('#password-strength-status').removeClass();
	        	$('#password-strength-status').addClass('weak-password');
	        	$('#password-strength-status').html("Weak (should be atleast 7 characters.)");
	        	return false;
	      	}else 
	      	{    
	        	if($('#new_password').val().match(number) && $('#new_password').val().match(alphabets) && $('#new_password').val().match(special_characters)) 
	        	{            
	          		$('#password-strength-status').removeClass();
	          		$('#password-strength-status').addClass('strong-password');
	          		$('#password-strength-status').html("Strong");
	          		return true;
	        	}else 
	        	{
	        		$('#new_password').focus();
	          		$('#password-strength-status').removeClass();
	          		$('#password-strength-status').addClass('medium-password');
	          		$('#password-strength-status').html("Medium (should include alphabets, numbers and special characters.)");
	          		return false;
	        	}
	      	}
		});

		function comparePassword(){
			var userId 	= $("#user_id").val();
			var currentPassword = $("#current_password").val();
			
			$.ajax({
				type: 'POST',
				url: '../../controller/checkPassword.php',
				data: { userId: userId, currentPassword: currentPassword},
				dataType: 'json',	
			}).done(function(data){
				var fetchPassword = data.message;
				if(fetchPassword != currentPassword)
				{
					$(".check_old_password").html("Password doesn't match!");
		            $("#current_password").css("border", "1px solid red").focus();
		            return false;
				}else{
					$(".check_old_password").html("");
		            $("#current_password").css("border", "1px solid green");
		            $("#update_password").prop('disabled', false);
		            return true;
				}
			});
		}

		function checkPasswordStrength(){
		    var number = /([0-9])/;
		    var alphabets = /([a-zA-Z])/;
		    var special_characters = /([~,!,@,#,$,%,^,&,*,-,_,+,=,?,>,<])/;
		    if($('#new_password').val().length<7) 
	        {
	       		$('#new_password').focus();
	     	    $('#password-strength-status').removeClass();
	        	$('#password-strength-status').addClass('weak-password');
	        	$('#password-strength-status').html("Weak (should be atleast 7 characters.)");
	        	return false;
	      	}else 
	      	{    
	        	if($('#new_password').val().match(number) && $('#new_password').val().match(alphabets) && $('#new_password').val().match(special_characters)) 
	        	{            
	          		$('#password-strength-status').removeClass();
	          		$('#password-strength-status').addClass('strong-password');
	          		$('#password-strength-status').html("Strong");
	          		return true;
	        	}else 
	        	{
	        		$('#new_password').focus();
	          		$('#password-strength-status').removeClass();
	          		$('#password-strength-status').addClass('medium-password');
	          		$('#password-strength-status').html("Medium (should include alphabets, numbers and special characters.)");
	          		return false;
	        	}
	      	}
	    }

	    $("#company_state").change(function(){
			var stateCode = $("#company_state").val();
			var city = '<option value="">Select City</option>';

			var city_cmp_id = $("#city_cmp_id").val();
			//alert(city_cmp_id);
			if(stateCode != ''){
				$.ajax({
		        	url: '../../controller/getCityName.php',
		        	type: 'post',
		        	data: { 'state_id' : stateCode },
		        	dataType: 'json',
		        	success:function(data){
		        		$.each( data, function( key, value ) {
		        			var city_id = value.city_id;
		        			var city_name = value.city_name;
		        			if(city_cmp_id == city_id){
		        				var select_city = "selected";
		        			}else{
		        				var select_city = "";
		        			}
		        			city += '<option value="'+city_id+'" '+select_city+'>'+city_name+'</option>';
		        		});
		        		$("#company_city").html(city);
		        	}
		        });
			}
			else {
	          $('#company_city').html(city);
	        }
		});

		$(document).ready(function(){
			var requestVal = $("#show_request").val();

			if(requestVal == ''){
				$(".li-posts").addClass('active');
				$(".tab-post").addClass('active in');
				/*$(".li-profile").addClass('active');
				$(".tab-profiles").addClass('active in');*/
				$(".information").addClass('active');
				$(".education").removeClass('active');
				$(".password").removeClass('active');
				$("#info").css('display', 'block');
				$("#education").css('display', 'none');
				$("#account-settings").css('display', 'none');
			}else if(requestVal == 'personal'){
				$(".li-profile").addClass('active');
				$(".tab-profiles").addClass('active in');
				$(".information").addClass('active');
				$(".education").removeClass('active');
				$(".password").removeClass('active');
				$("#info").css('display', 'block');
				$("#education").css('display', 'none');
				$("#account-settings").css('display', 'none');
			}else if(requestVal == 'company'){
				$(".li-profile").addClass('active');
				$(".tab-profiles").addClass('active in');
				$(".information").removeClass('active');
				$(".education").addClass('active');
				$(".password").removeClass('active');
				$("#info").css('display', 'none');
				$("#education").css('display', 'block');
				$("#account-settings").css('display', 'none');
			}else if(requestVal == 'account'){
				$(".li-profile").addClass('active');
				$(".tab-profiles").addClass('active in');
				$(".education").removeClass('active');
				$(".information").removeClass('active');
				$(".password").addClass('active');
				$("#info").css('display', 'none');
				$("#education").css('display', 'none');
				$("#account-settings").css('display', 'block');
			}else if(requestVal == 'feedback'){
				$(".li-profile").addClass('active');
				$(".tab-profiles").addClass('active in');
				$(".education").removeClass('active');
				$(".information").removeClass('active');
				$(".password").removeClass('active');
				$(".feedback").addClass('active');
				$("#info").css('display', 'none');
				$("#education").css('display', 'none');
				$("#account-settings").css('display', 'none');
				$("#feedback").css('display', 'block');
			}else if(requestVal == 'connection'){
				$(".li-request").addClass('active');
				$(".tab-request").addClass('active in');
			}

			var showTitle = $("#title_id").val();
			//alert(showTitle);
			if(showTitle == 6){
				$(".title-div").show();
			}

			if($("#post_count").val() > 0){
				$("#empty_post").hide();
				var limit = 3;
			 	var start = 0;
			 	var action = 'inactive';
			 	function load_country_data(limit, start)
			 	{	
			  		$.ajax({
			   		url:"profile.php",
			   		method:"POST",
			   		data:{limit:limit, start:start},
			   		cache:false,
			   		success:function(data)
			   		{
			    		$('#load_data_profile').append(data);
			    		if(data == '')
			    		{
			     		/*$('#load_data_profile_message').html("<button type='button' class='btn btn-info'>You have reached end of the page</button>");*/
			     		action = 'active';
			    		}
			    		else
			    		{
			     		/*$('#load_data_profile_message').html("<button type='button' class='btn btn-warning'>Please Wait....</button>");*/
			     		action = "inactive";
			    		}
			   		}
			  		});
			 	}

			 	if(action == 'inactive')
			 	{
			  		action = 'active';
			  		load_country_data(limit, start);
			 	}
			 	$(window).scroll(function(){
			  	if($(window).scrollTop() + $(window).height() > $("#load_data_profile").height() && action == 'inactive')
			  	{
			   		action = 'active';
			   		start = start + limit;
			   		setTimeout(function(){
			    		load_country_data(limit, start);
			   		}, 1000);
			  	}
				});
			}else{
				$("#empty_post").show();
			}
		});

		$(".edit-title").change(function(){
	        $(this).find("option:selected").each(function(){
	            var optionValue = $(this).attr("value");
	            if(optionValue == '6'){
	                $(".title-div").show();
	                $("#title_name").focus();
	            }
	            else{
	                $(".title-div").hide();
	            }
	        });
	    }).change();

	    $("#title_name").on('change', function(){
	    	if(("#title_name").val() == ''){
            	$("#title_name").css('border','1px solid red').focus();
            	$(".check_mandatory").css('color','red').html("Designation / Title is required.");
            }
	    });

		$("#deactivate").on('click', function(){
			var deactivate_user_id = $("#deactivate_account").val();

			$.post('../../controller/authController.php', {'deactivate_user_id' : deactivate_user_id}, function(data){
			  	if(data.message === 'success'){
			  			//$("#deactivateAccount").modal('hide');
			  			window.location.href = '../../';
						return true;
					} 
					else{
						alert('something went wrong');
						return false;
					} 
			});
		});

		$(document).on('click','.updateImage',function(){
		    var id = $(this).data('id');
		    $('#eImage').val(id);
		});

		function phone_validate(phno) 
		{ 
		    var regexPattern=new RegExp(/^[0-9]+$/);
		    return regexPattern.test(phno); 
		} 

		$("#mobilenumber").on('change', function(){
			var mobile = $("#mobilenumber").val();
			if(phone_validate(mobile)) 
		    { 
		       $("#mobilenumber").css('border','1px solid green');
			   $(".check_mobile").remove();
				return true;
		    } 
		    else 
		    {  
		       $("#mobilenumber").css('border','1px solid red').focus();
			   $(".check_mobile").css('color','red').html("Error! Contact number can contain only numbers from 0-9");
		       return false;
		    } 
		});

		$("#user_image").bind('change', function(){
			var size=(this.files[0].size);
	        var exte=(this.files[0].name);
	        fextension = exte.substring(exte.lastIndexOf('.')+1);
	        validExtensions = ["jpg","JPG","jpeg","JPEG","png","PNG"];

	        if ($.inArray(fextension, validExtensions) == -1){
                $(".image_validation").css('color', 'red').html('Please upload an image jpg, jpeg, png only');
                this.value = "";
                return false;
            }else{
            	if(size > 1044831) {
		            $(".image_validation").css('color', 'red').html('Please upload an image size less than 1 MB');
		            $("#user_image").val('');
		            return false
		        }
		        $(".image_validation").html('');
		        return true;
            }
		});

		$(".remove_connection_btn").on('click', function(){
			var removeId = $(this).data("registerid");
			var userId = $(this).data("userid");
			var removeSt = $(this).data("removeconn");
			$("#remove_reg_id").val(removeId);
			$("#remove_user_id").val(userId);
			$("#remove_status").val(removeSt);
		});

		$(document).ready(function(){
	        $('.mobile_privacy').click(function(){
	            if($(this).prop("checked") == true){
	                $("#mobile_privacy_val").val('1');
	            }
	            else if($(this).prop("checked") == false){
	                $("#mobile_privacy_val").val('0');
	            }
	        });

	        $('.email_privacy').click(function(){
	            if($(this).prop("checked") == true){
	                $("#email_privacy_val").val('1');
	            }
	            else if($(this).prop("checked") == false){
	                $("#email_privacy_val").val('0');
	            }
	        });
	    });
	</script>

	<script>
		function openCity(evt, cityName) {
		  var i, tabcontent, tablinks;
		  tabcontent = document.getElementsByClassName("tabcontent");
		  for (i = 0; i < tabcontent.length; i++) {
		    tabcontent[i].style.display = "none";
		  }
		  tablinks = document.getElementsByClassName("tablinks");
		  for (i = 0; i < tablinks.length; i++) {
		    tablinks[i].className = tablinks[i].className.replace(" active", "");
		  }
		  document.getElementById(cityName).style.display = "block";
		  evt.currentTarget.className += " active";
		}

		// Get the element with id="defaultOpen" and click on it
		document.getElementById("defaultOpen").click();
	</script>
</body>
</html>