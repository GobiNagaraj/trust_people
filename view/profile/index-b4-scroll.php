<?php 
	include_once '../../model/db.php';
	$conn = db_connect();

	$userId = $_SESSION['data']['register_id'];
    if($userId == null)
  	{
    	header('Location: ../../');
  	}	

	if(isset($_GET['userId']))
	{
	  	$user_id = $_GET['userId'];

	  	$sql = "SELECT R.register_id, R.first_name, R.last_name, R.reg_title_id, R.title, R.email_address, R.country_code, R.mobile_number, R.user_image, R.company_name, R.company_website, R.created_at, U.about_info, U.description, T.title_name FROM `register_tbl` AS R LEFT JOIN `user_personal_details_tbl` AS U ON U.register_id = R.register_id LEFT JOIN `title_tbl` AS T ON T.title_id = R.reg_title_id WHERE R.register_id = '$user_id' AND R.status = '1'";

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
	  		$createdAt 		= 	$row['created_at'];
	  		$abtInfo 		= 	$row['about_info'];
	  		$description 	=	$row['description'];
	  	}

	  	$abtInfos = explode("-", $abtInfo);
	  	$information = implode("/", $abtInfos);

	  	$getPostCnt = execute_query($conn, "SELECT COUNT(`post_id`) AS posts FROM post_details_tbl JOIN register_tbl ON register_tbl.register_id = post_details_tbl.created_by WHERE post_details_tbl.created_by = '$user_id'");
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
	<link rel="shortcut icon" type="image/x-icon" href="../../assets/images/trust_people_fav.png"/>
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
</head>
<body style="font-family: Source Sans Pro;">
	<style>
		.collapsible {
		  cursor: pointer;
		}
		.content {
		  padding: 0 18px;
		  display: none;
		  overflow: hidden;
		  border:1px solid #f1f1f1;
		  padding: 5px;
		}
	</style>
	<div class="">
		<?php include_once '../common-popup.php'; ?>
		<?php include_once '../nav_bar.php'; ?>
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
			    	<?php 
			    	if(isset($_GET['userId'])){
			    		$userId = $_GET['userId'];
					/* Query for getting most recent Records */
					$sql = "SELECT R.`register_id` AS registerId, R.`first_name` AS firstName, R.`last_name` AS lastName, R.`user_image` AS userImage, R.`company_state_id` AS companyState, R.`company_city_id` AS companyCity, R.`company_address` AS companyAddress, P.`post_id` AS postId, P.`post_first_name` AS postFname, P.`post_last_name` AS postLname, P.`title_discussion` AS postTitle, P.`job_location_state`, P.`job_location_city`, P.`job_role` AS jobRole, P.`linked_url` AS linkedUrl, P.`details` AS postDetails, P.`date_back_out` AS backOutDate, P.`ratings` AS rating, P.`resume` AS resume, P.`created_at` AS postCreated, C.`city_name` AS jobCity, S.`state_name` AS jobState FROM `register_tbl` AS R JOIN `post_details_tbl` AS P ON R.register_id = P.`created_by` JOIN `company_states_tbl` AS S ON S.`state_code` = P.`job_location_state` JOIN `company_cities_tbl` AS C ON C.`city_id` = P.`job_location_city` WHERE R.`status` = '1' AND R.`register_id` = '$userId' ORDER BY P.`created_at` DESC";

					$query = execute_query($conn, $sql);

					?>
                	<?php 
					$i = 1;
					if(mysqli_num_rows($query) > 0){
					while($row = mysqli_fetch_assoc($query))
				  	{
				  		$registerId = 	$row['registerId'];
				  		$fname 		= 	$row['firstName'];
				  		$lname 		= 	$row['lastName'];
				  		$userImage 	= 	$row['userImage'];
				  		$cmpState 	=	$row['companyState'];
				  		$cmpCity 	=	$row['companyCity'];
				  		$companyAddress = $row['companyAddress'];
				  		$postId 	=	$row['postId'];
				  		$postFname  = 	$row['postFname'];
				  		$postLname  = 	$row['postLname'];
				  		$postTitle 	=	$row['postTitle'];
				  		$jobState 	=	$row['jobState'];
				  		$jobCity 	=	$row['jobCity'];
				  		$jobRole 	=	$row['jobRole'];
				  		$linkedUrl 	=	$row['linkedUrl'];
				  		$backDate 	=	$row['backOutDate'];
				  		$rating 	=	$row['rating'];
				  		$resume 	=	$row['resume'];
				  		$postDetails=	$row['postDetails'];
				  		$createdAt 	= 	$row['postCreated'];

				  		$date = strtotime($createdAt);
				  		$createdAt = date('M d, Y h:i A', $date);

				  		$dates = strtotime($backDate);
				  		$backOutDate = date('M d, Y', $dates);
				  		/*Query for to fetch the post count from the social details table*/
						$getSocialDetails = "SELECT COUNT(S.`yes_iam`) AS cntYes, COUNT(S.`similar_exp`) AS cntExp, COUNT(S.`comments`) AS cntCmt FROM `social_details_tbl` AS S WHERE S.post_id = '$postId' ";
					  	$getQuery = execute_query($conn, $getSocialDetails);
					  	while($setSocial = mysqli_fetch_assoc($getQuery)){
					  		$cntYes 	=	$setSocial['cntYes'];
					  		$cntSimilar = 	$setSocial['cntExp'];
					  		$cntCmt 	= 	$setSocial['cntCmt'];	

					  	$getFollowers = execute_query($conn, "SELECT COUNT(social_details_tbl.followers) AS follower FROM `social_details_tbl` JOIN `register_tbl` ON social_details_tbl.register_id = register_tbl.register_id WHERE social_details_tbl.user_id = '$userId' AND register_tbl.register_id = '$registerId' AND social_details_tbl.follower_status = '1' AND social_details_tbl.followers IS NOT NULL");
					  	while($follower = mysqli_fetch_array($getFollowers)){ $followerId = $follower['follower']; }
					  	
					  	$getFollowerss = execute_query($conn, "SELECT COUNT(social_details_tbl.followers) AS follower FROM `social_details_tbl` JOIN `register_tbl` ON social_details_tbl.register_id = register_tbl.register_id WHERE social_details_tbl.user_id = '$userId' AND register_tbl.register_id = '$registerId' AND social_details_tbl.follower_status = '0' AND social_details_tbl.followers IS NOT NULL");
					  	while($followers = mysqli_fetch_array($getFollowerss)){ $followerIds = $followers['follower']; }
				?>
				<div class="col-md-10 repeatedDiv-profile search_result">
					<input type="hidden" name="userId" id="userId" value="<?php echo $userId; ?>">
					<input type="hidden" name="postId" id="postId" value="<?php echo $postId; ?>">
					<!-- <div class="col-md-2">
						<a href="../profile/userProfile.php?regId=<?php echo $registerId;?>">
							<?php if($userImage == NULL){ ?>
							<img class="userImgs" src="../../userImage/user.png" alt="<?php echo $fname."-".$lname; ?>">
							<?php }else{ ?>
							<img class="userImgs" src="../../userImage/<?php echo $userImage; ?>" alt="<?php echo $fname."-".$lname; ?>">
							<?php
								}
							?>
						</a><br>
					</div> -->
					<div class="col-md-12">
							<?php if($registerId != $userId){?><?php if($followerId == 1) { ?><a href="#" data-userid="<?php echo $userId?>" data-registerid="<?php echo $registerId;?>" class="btn btn-primary btn-xs un_follow_btn"> Following </a> <?php }else if($followerIds == 1){?><br>
							<a href="#" class="btn btn-primary btn-xs">Request Sent</a>
							<?php }else{ ?><a href="#" data-userid="<?php echo $userId?>" data-registerid="<?php echo $registerId;?>" class="btn btn-primary btn-xs follow_btn"> Follow </a><?php } }?>
						<h3 class="h3Forenterprise"><?php echo $postTitle; ?></h3>
						<hr style="margin-top: 0px; margin-bottom: 5px;">
						<?php if ($linkedUrl != ''){ $linkedUrl = $linkedUrl; }else { $linkedUrl = ''; } ?>
						<table width="100%" style="color: #0045ab;">
							<tr>
								<td width="6%"><b>Candidate Name : </b></td>
								<td width="20%"><?php echo $postFname. " " .$postLname; ?>&nbsp;&nbsp;&nbsp;<?php for($k = 1; $k <= $rating; $k++){ ?><i class="fa fa-star" style="color: #f2bb13;"></i><?php } ?></td>
								<td width="20%"><?php if ($resume != ''){ ?><a href="../../resumeFiles/<?php echo $resume; ?>" target="_blank" class="btn btn-sm btn-danger"><i class="fa fa-download"></i></a><?php } ?>&nbsp;<?php if ($linkedUrl != ''){ ?><a href="<?php echo $linkedUrl; ?>" target="_blank" class="btn btn-sm btn-info"> <i class="fa fa-linkedin"></i></a><?php } ?></td>
							</tr>
						</table><br>
						<table width="100%" style="color: #0045ab;">
							<tr>
								<td width="7%"><b>Applied role : </b></td>
								<td width="27%"><?php echo $jobRole; ?></td>
								<td width="6%"><b>Location : </b></td>
								<td width="20%"><?php echo $jobState. "," .$jobCity; ?></td>
							</tr>
						</table>
						<p class="enterpriseCnt" style="margin-top: 10px;"><?php echo $postDetails; ?></p>
						<div class="col-md-5 profile-div-left">
							<label>Post Date : <?php echo $createdAt; ?></label>
						</div>
						<div class="col-md-5 profile-div-right">
							<input type="hidden" name="user_id" id="user_id_<?php echo $i; ?>" value="<?php echo $userId; ?>">
							<input type="hidden" name="post_id" id="post_id_<?php echo $i; ?>" value="<?php echo $postId; ?>">
							<input type="hidden" name="register_id" id="register_id_<?php echo $i; ?>" value="<?php echo $registerId; ?>">
							<?php 
								$demoCnt = execute_query($conn, "SELECT COUNT(yes_iam) AS yes, COUNT(similar_exp) AS same, COUNT(comments) AS cmt FROM `social_details_tbl` WHERE user_id = '$userId' AND post_id = '$postId' AND register_id = '$registerId'");
								while($demo = mysqli_fetch_assoc($demoCnt)){
									$countofYes 	= 	$demo['yes'];
									$countofSame	=	$demo['same'];
									$countofCmt		=	$demo['cmt'];
								} ?>
								<span id="yes_cnt" class="yesCount_<?php echo $i;?>"><?php echo $cntYes; ?> </span>&nbsp;&nbsp;
								<?php if($countofYes == 0){ ?>
								 	<span class="activeHeart_<?php echo $i;?>" style="cursor: pointer;" title="Yes. I am with you." onclick="postYes(<?php echo $i;?>);"><i class="fa fa-heart-o" id="inActiveHeartIcon_<?php echo $i;?>"></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
								<?php }if($countofYes == 1){ ?>
								 	<span style="cursor: pointer;" title="Yes. I am with you."><i class="fa fa-heart like-heart" id="activeHeartIcon_<?php echo $i;?>"></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><?php } ?>
								<span id="same_cnt" class="sameCount_<?php echo $i;?>"><?php echo $cntSimilar; ?></span>&nbsp;&nbsp;
								<?php if($countofSame == 0){ ?>
								<span class="activeLike_<?php echo $i;?>" title="I have similar experience." onclick="postSame(<?php echo $i;?>)" style="cursor: pointer;"><i class="fa fa-thumbs-o-up" id="inActiveLikeIcon_<?php echo $i;?>"></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><?php } if($countofSame == 1){ ?><span style="cursor: pointer;" title="I have similar experience."><i class="fa fa-thumbs-up like-symbol" id="activeLikeIcon_<?php echo $i;?>"></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><?php } ?>
								<span id="cmts_cnt"><?php echo $cntCmt; ?></span>
								<a class="collapsible" type="button" title="Comments" onclick="getCommentDiv(<?php echo $i; ?>);"><i class="fa fa-comment" style="color: #337ab7"></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a>
								<div class="content content-profile row">
									<div id="commentsDiv_<?php echo $i; ?>"></div>
								</div>
							</div>
						</div>
					</div>
					<?php
						$i++;
							}
						}
						}else{ echo "<h4 style='text-align: center;'>There is no posts</h4>"; }
					}
					?>
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
				            <!-- <div class="col-md-2 mobile-auth">
				            	<input type="checkbox" name=""> Show Public
				            </div> -->
					  	</div>
					  	<div class="col-md-12">
					  		<div class="col-md-4">
					  			<label class="abt-status-lbl">About your status :</label>
					  		</div>
					  		<div class="col-md-6 your-status">
					  			<textarea class="abt_info_box abt-status-box" name="about_information" rows="6" cols="6" placeholder="Enter your status with '-' (ex: Project Manager - Developer - Java)" data-toggle="tooltip" title="About your status"><?php if(empty($abtInfo)){ echo ""; }else{ echo $abtInfo; } ?></textarea>
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
					  		if($reg_title_id == ''){
								$reg_title_id = '5';
							}else{
								$reg_title_id = $reg_title_id;
							}

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
							<div class="col-md-6">
					  			<input type="text" name="working" value="<?php echo $email; ?>" placeholder="Email Address" class="form-control editProfile mobile-view-txt" data-toggle="tooltip" title="Business email" readonly>
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
					  	<input type="hidden" name="password_user_id" id="user_id" value="<?php echo $userId; ?>">
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
					  			<a href="userProfile.php?regId=<?php echo $follower['register_id']; ?>"><img src="../../userImage/<?php echo $image; ?>" alt="<?php echo $follower['first_name']. " ".$follower['last_name']; ?>" class="notifyImg"></a>
					  		</div>
					  		<div class="col-md-4 name-connection">
					  			<?php echo $follower['first_name']. " ".$follower['last_name']; ?>
					  		</div>
					  		<div class="col-md-3 remove-connection">
					  			<a href="#" data-userid="<?php echo $user_id; ?>" data-registerid="<?php echo $follower['register_id']; ?>" data-removeconn="1" class="btn btn-primary btn-xs remove_connection_btn"> <i class="fa fa-user-times"></i> Remove</a>
					  			<!-- <a href="userProfile.php?regId=<?php echo $follower['register_id']; ?>" class="btn btn-xs btn-info"><i class="fa fa-file"></i> View</a> -->
					  		</div>
				  		</div>
				  		<hr class="request-hr">
					  	<?php } }else{ echo "<h4 style='text-align: center;'>You have no connections not yet</h4>"; } ?>
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
	      		<input type="hidden" name="deactivate_account" id="deactivate_account" value="<?php echo $userId; ?>">
	      	</div>
	      </div>
	        <div class="modal-footer">
		      	<input type="submit" id="deactivate" value="Delete" name="deactivate" class="btn btn-danger">
		        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		    </div>
	    </div>
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
				if(value.userImage == null){
					user_image = 'user.png';
				}else{
					user_image = value.userImage;
				}
				rows = rows + '<div class="col-md-12 commentDiv"><div class="col-md-2">';
				rows = rows + '<img src="../../userImage/'+user_image+'" class="commentsUserImg">';	
				rows = rows + '</div><div class="col-md-8">';
				rows = rows + '<p class="commentPara">'+value.comments+'</p></div></div>';
			});
			$("#commentsDiv_"+b).html(rows);
		}

		function getCommentDiv(i){
			//var user_id = $("#user_id_"+i).val();
			var post_id = $("#post_id_"+i).val();
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

		var coll = document.getElementsByClassName("collapsible");
		var i;

		for (i = 0; i < coll.length; i++) {
		  coll[i].addEventListener("click", function() {
		    this.classList.toggle("active");
		    var content = this.nextElementSibling;
		    if (content.style.display === "block") {
		      content.style.display = "none";
		    } else {
		      content.style.display = "block";
		    }
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
		});

		$("select").change(function(){
	        $(this).find("option:selected").each(function(){
	            var optionValue = $(this).attr("value");
	            if(optionValue == '6'){
	                $(".title-div").show();
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
			  	if(data === 'success'){
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