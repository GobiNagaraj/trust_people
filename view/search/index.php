<?php 
	include_once '../../model/db.php';
	$conn = db_connect();

	$userId = 	$_SESSION['data']['register_id'];
    if($userId == null)
  	{
    	header('Location: ../../');
  	}	

  	$encryptedUserId = encrypt_decrypt($userId);
  	$userId = $encryptedUserId['encrypted'];

  	$decryptedUserId = encrypt_decrypt($userId);
  	$userId = $decryptedUserId['decrypted'];

  	$selectNav = execute_query($conn, "SELECT first_name, last_name, user_image, flag FROM `register_tbl` WHERE register_id = '$userId'");

	while($rows = mysqli_fetch_assoc($selectNav))
	{
  		$currentUserImage 	= 	$rows['user_image'];
  	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Trust People Search Page</title>
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
	<link rel="stylesheet" type="text/css" href="../../assets/css/home-individual.css">

	<?php include '../home/post_popup.php'; ?>
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
		  border:1px solid #f1f1f1;
		  padding: 5px;
		}
		ul{
	        padding: 0;
	        list-style: none;
	    }
	    ul li{
	        display: inline-block;
	        position: relative;
	        line-height: 21px;
	        text-align: left;
	    }
	    ul li a{
	        display: block;
	        padding: 8px 25px;
	        color: #333;
	        text-decoration: none;
	    }
	    ul li a:hover{
	        color: #fff;
	        background: #939393;
	    }
	    ul li ul.dropdown{
	        min-width: 100%;
	        background: #1f4177;
	        display: none;
	        position: absolute;
	        z-index: 999;
	        left: 0;
	        padding: 5px;
	        color: #fff;
	        border-radius: 10px;
	    	font-size: 13px;
	    }
	    ul li:hover ul.dropdown{
	        display: block;
	    }
	    ul li ul.dropdown li{
	        display: block;
	    }
	</style>
	<style>
	form.example input[type=text] {
	  	padding: 15px;
	    /*border: 1px solid grey;*/
	    float: left;
	    width: 85%;
	    background-color: #fff;
	    /*border-left: none;
	    border-radius: 25px 0px 0px 25px;*/
	}

	form.example button {
		margin: 0px auto;
	    height: 34.5px;
	  	float: left;
	    width: 15%;
	    padding: 0px;
	    background: #fff;
	    color: #1f4177;
	    cursor: pointer;
	    border-left: none;
	    border: 1px solid grey;
	    border-radius: 0px 25px 25px 0px;
	}

	form.example button:hover {
	  background: #fff;
	  color: #1f4177;
	}

	form.example::after {
	  content: "";
	  clear: both;
	  display: table;
	}
	.search_by_unknown{
		margin-top: 33px;
	}
	.unknown_center_div{
		margin: 20px 0px 0px 320px;
	}
	</style>
	<script>
		$(document).ready(function(){
	        $('[data-toggle="tooltip"]').tooltip({
	        	placement : 'bottom'
	        });
	    });
	</script>
	<div class="header-nav">
		<?php include_once '../header/nav_bar.php'; ?>
	</div>

	<div class="main">
		<div class="container">
			<div class="col-md-12 enterpriseDiv">
				<div class="col-md-3">
				</div>
				<div class="col-md-9">
					<div class="col-md-8">
						<?php include_once '../search/search_box.php'; ?>
					</div>
					<div class="col-md-3 pull-right pencil-div">
						<span class="pencil">
							<i class="fa fa-pencil" data-toggle="modal" data-target="#postModal" style="cursor: pointer;"></i>&nbsp;&nbsp;&nbsp;<a class="pencil-post" data-toggle="modal" data-target="#postModal" style="cursor: pointer;">Create Post</a>
						</span>
					</div>
				</div>
			</div>
			<br>
			<hr style="width: 100%;">

			<div class="col-md-12">
				<?php 
				if(isset($_POST['search'])){

					$searchType = sanitize($conn, trim($_POST['search_type']));
					$sql = "SELECT R.`register_id` AS registerId, R.`first_name` AS firstName, R.`last_name` AS lastName, R.`user_image` AS userImage, P.`post_id` AS postId, P.`post_first_name` AS postFname, P.`post_last_name` AS postLname, P.`title_discussion` AS postTitle, P.`job_role` AS jobRole, P.`vendor_name` AS vendorName, P.`linked_url` AS linkedUrl, P.`details` AS postDetails, P.`date_back_out` AS backOutDate, P.`resume` AS resume, P.`ratings` AS rating, P.`created_at` AS postCreated, P.`updated_at` AS postUpdated, S.`state_name` AS stateName, C.`city_name` AS cityName, M.`story_name` AS storyName FROM `register_tbl` AS R LEFT JOIN `post_details_tbl` AS P ON R.`register_id` = P.`created_by` JOIN `company_states_tbl` AS S ON S.`state_code` = P.`job_location_state` JOIN `company_cities_tbl` AS C ON C.`city_id` = P.`job_location_city` LEFT JOIN `story_category_master_tbl` AS M ON M.`story_category_id` = P.`title_discussion` WHERE R.`status` = '1' AND P.`status` = '1'";

			  		switch($searchType){
			  			case 'post_name':
			  				$sql .= " AND R.`first_name` LIKE '%".$search."%' OR R.`last_name` LIKE '%".$search."%'";
			  				break;
			  			case 'candidate_name':
			  				$sql .= " AND CONCAT(P.`post_first_name`,' ',P.`post_last_name`) LIKE '%".$search."%'";
			  				break;
			  			case 'title':
			  				$sql .= " AND P.`title_discussion` LIKE '%".$search."%'";
			  				break;
			  			case 'location':
			  				$sql .= " AND S.`state_name` LIKE '%".$search."%' OR C.`city_name` LIKE '%".$search."%'";
			  				break;
			  			case 'all':
			  				$sql .= " AND CONCAT(R.`first_name`,' ',R.`last_name`) LIKE '%".$search."%' OR CONCAT(P.`post_first_name`,' ',P.`post_last_name`) LIKE '%".$search."%' OR P.`title_discussion` LIKE '%".$search."%' OR P.`job_location_country` LIKE '%".$search."%' OR S.`state_name` LIKE '%".$search."%' OR C.`city_name` LIKE '%".$search."%'";
			  				break;
			  		}
			  		$result = execute_query($conn, $sql);
			  		/*echo $sql;
			  		exit();*/
				?>
            	<?php 
				$i = 1;
				if(mysqli_num_rows($result) > 0){
				while($search_row = mysqli_fetch_assoc($result))
		  		{
			  		$registerId 	= 	$search_row['registerId'];
			  		$fname 			= 	$search_row['firstName'];
			  		$lname 			= 	$search_row['lastName'];
			  		$userImage 		= 	$search_row['userImage'];
			  		$postId 		=	$search_row['postId'];
			  		$postFname  	= 	$search_row['postFname'];
			  		$postLname  	= 	$search_row['postLname'];
			  		if($search_row['storyName'] == null){
			  			$postTitle = $search_row['postTitle'];
			  		}else{
			  			$postTitle = $search_row['storyName'];
			  		}
			  		//$postTitle 		=	$search_row['postTitle'];
			  		//$jobLocation 	=	$search_row['jobLocation'];
			  		$jobState 		=	$search_row['stateName'];
			  		$jobCity 		=	$search_row['cityName'];
			  		$jobRole 		=	$search_row['jobRole'];
			  		$vendorName 	=	$search_row['vendorName'];
			  		$linkedUrl 		=	$search_row['linkedUrl'];
			  		$backDate 		=	$search_row['backOutDate'];
			  		$rating 	  	=   $search_row['rating'];
			  		$resume 		=	$search_row['resume'];
			  		$postDetails	=	$search_row['postDetails'];
			  		$createdAt 		= 	$search_row['postCreated'];
			  		$updatedAt  	= 	$search_row['postUpdated'];

			  		$date = strtotime($createdAt);
			  		$createdAt = date('M d, Y h:i A', $date);

			  		if($updatedAt == NULL){
			  			$updatedAt = $createdAt;
			  		}else{
			  			$updatedAt = $updatedAt;
			  		}

			  		$dates = strtotime($updatedAt);
			  		$updatedAt = date('M d, Y h:i A', $dates);

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
			<div class="col-md-11 repeatedDivs search_result">
				<input type="hidden" name="userId" id="userId" value="<?php echo $userId; ?>">
				<input type="hidden" name="postId" id="postId" value="<?php echo $postId; ?>">
				<?php 
					$showUser = '#';
					$checkUser = execute_query($conn, "SELECT * FROM `social_details_tbl` WHERE (user_id = '".$userId."' OR user_id = '".$userId."' AND register_id = '".$registerId."' OR register_id = '".$registerId."') AND follower_status = '1'");
					while($getUser = mysqli_fetch_array($checkUser)){ 
						if(mysqli_num_rows($checkUser) > 0){
							$showUser = "../profile/userProfile.php?regId=".base64_encode($registerId)."";
						}else{
							$showUser = "#";
						}
					}
				?>
				<div class="col-md-2">
					<a href="<?php echo $showUser; ?>">
						<?php if($userImage == NULL){ ?>
						<img class="userImgs" src="../../userImage/user.png" alt="<?php echo $fname."-".$lname; ?>">
						<?php }else{ ?>
						<img class="userImgs" src="../../userImage/<?php echo $userImage; ?>" alt="<?php echo $fname."-".$lname; ?>">
						<?php
							}
						?>
					</a><br>
				</div>
				<div class="col-md-10 center-content">
					<input type="hidden" name="userId" class="userFollowId_<?php echo $registerId; ?>" value="<?php echo $userId; ?>">
					<input type="hidden" name="registerId" class="registerFollowId_<?php echo $registerId; ?>" value="<?php echo $registerId; ?>">
					<h5 class="home-headline"><a href="<?php echo $showUser; ?>" class="home-headline"><?php echo ucfirst($fname).' '.ucfirst($lname);?></a>
						<!-- <i class="fa fa-check-circle text-success online-icon"></i> -->
						<?php if($registerId != $userId){ if($followerId == 1) {   }else if($followerIds == 1){ ?>
						<label class="btn btn-primary btn-xs" style="cursor: pointer;">Request Sent</label>
						<?php }else{ ?><label class="btn btn-primary btn-xs follow_<?php echo $registerId; ?>" style="cursor: pointer;" onClick="follow_btn(<?php echo $registerId; ?>)"> <i class="fa fa-plus"></i> Connect </label><?php } } ?>
					</h5>
					<h3 class="h3Forenterprise"><?php echo $postTitle; ?></h3>
					<hr style="margin-top: 0px; margin-bottom: 5px;">
					<?php if ($linkedUrl != ''){ $linkedUrl = $linkedUrl; }else { $linkedUrl = ''; } ?>
					<table width="100%" style="color: #0045ab;">
						<tr>
							<td width="10%"><b>Candidate Name : </b></td>
							<td width="20%"><?php echo $postFname. " " .$postLname; ?>&nbsp;&nbsp;&nbsp;<?php for($k = 1; $k <= $rating; $k++){ ?><i class="fa fa-star" style="color: #f2bb13;"></i><?php } ?></td>
							<td width="20%"><?php if ($resume != ''){ ?><a href="../viewPdf.php?r=<?php echo $resume; ?>" target="_blank" class="btn btn-sm btn-danger" data-toggle="tooltip" title="View Resume"><i class="fa fa-file"></i></a>&nbsp;<?php } if ($linkedUrl != ''){ ?><a href="<?php echo $linkedUrl; ?>" target="_blank" class="btn btn-sm btn-info" data-toggle="tooltip" title="View Profile"> <i class="fa fa-linkedin"></i></a><?php } ?></td>
						</tr>
					</table><br>
					<table width="100%" style="color: #0045ab;">
						<tr>
							<td width="14%"><b>Applied Role : </b></td>
							<td width="25%"><?php echo $jobRole; ?></td>
							<?php if($vendorName != null){ ?>
							<td width="14%"><b>Vendor Name : </b></td>
							<td width="25%"><?php echo $vendorName; ?></td>
							<?php } ?>
							<td width="12%"><b>Location : </b></td>
							<td width="20%"><?php echo $jobState.', '.$jobCity; ?></td>
						</tr>
					</table>
					<p class="enterpriseCnt" style="margin-top: 12px;"><?php echo $postDetails; ?></p>
				</div>
				<hr class="comment-hr">
				<div class="col-md-12">
					<div class="col-md-6 posted-dt">
						<label>Post Date : <?php echo $updatedAt; ?></label>
					</div>
					<div class="col-md-6 social-icons-home">
					 	<input type="hidden" name="userId" id="userId_<?php echo $postId; ?>" value="<?php echo $userId; ?>">
						<input type="hidden" name="postId" id="postId_<?php echo $postId; ?>" value="<?php echo $postId; ?>">
						<input type="hidden" name="registerId" id="registerId_<?php echo $postId; ?>" value="<?php echo $registerId; ?>">
						<?php 
							$demoCnt = execute_query($conn, "SELECT COUNT(yes_iam) AS yes, COUNT(similar_exp) AS same, COUNT(comments) AS cmt FROM `social_details_tbl` WHERE user_id = '".$userId."' AND post_id = '".$postId."' AND register_id = '".$registerId."'");
							while($demo = mysqli_fetch_assoc($demoCnt)){
								$countofYes 	= 	$demo['yes'];
								$countofSame	=	$demo['same'];
								$countofCmt		=	$demo['cmt'];
							} 
						?>
						<ul>
				        	<li><span id="yes_cnt" class="yesCount_<?php echo $postId; ?>"><?php echo $cntYes; ?></span>&nbsp;&nbsp;&nbsp;
						<?php if($countofYes == 0){ ?>
						 	<span class="activeHeart_<?php echo $postId; ?>" style="cursor: pointer;" onclick="postYes(<?php echo $postId; ?>);"><i class="fa fa-thumbs-o-up" id="activeHeartIcon_<?php echo $postId; ?>"></i><span class="trust-lbl" onmouseover="getTrustableList(<?php echo $postId; ?>)"> Trustable</span>&nbsp;&nbsp;&nbsp;</span>
						<?php }if($countofYes >= 1){ ?>
						 	<span style="cursor: pointer;" onclick="postYes(<?php echo $postId; ?>);"><i class="fa fa-thumbs-up like-symbol" id="activeHeartIcon_<?php echo $postId; ?>"></i><span class="trust-lbl" onmouseover="getTrustableList(<?php echo $postId; ?>)"> Trustable</span>&nbsp;&nbsp;&nbsp;</span>
						<?php } ?>
						<ul class="dropdown trust_list_<?php echo $postId; ?>"></ul>
						</li>
						<li><span id="same_cnt" class="sameCount_<?php echo $postId; ?>"><?php echo $cntSimilar; ?> </span>&nbsp;&nbsp;&nbsp;
						<?php if($countofSame == 0){ ?>
						<span class="activeLike_<?php echo $postId; ?>" onclick="postSame(<?php echo $postId; ?>)" style="cursor: pointer;"><i class="fa fa-thumbs-o-down" id="activeLikeIcon_<?php echo $postId; ?>"></i><span class="un-trust-lbl" onmouseover="getUnTrustableList(<?php echo $postId; ?>)"> Untrustable</span>&nbsp;&nbsp;&nbsp;</span><?php } if($countofSame >= 1){ ?> <span style="cursor: pointer;" onclick="postSame(<?php echo $postId; ?>)"><i class="fa fa-thumbs-down like-symbol" id="activeLikeIcon_<?php echo $postId; ?>"></i><span class="un-trust-lbl" onmouseover="getUnTrustableList(<?php echo $postId; ?>)"> Untrustable</span>&nbsp;&nbsp;&nbsp;</span><?php } ?>
						<ul class="dropdown un_trust_list_<?php echo $postId; ?>"></ul>
						</li>
						<span id="cmts_cnt" class="cmtCount_<?php echo $postId; ?>"><?php echo $cntCmt; ?></span>&nbsp;&nbsp;&nbsp;
						<a data-toggle="collapse" href="#collapseExample_<?php echo $postId; ?>" role="button" aria-expanded="false" aria-controls="collapseExample" title="Comments" onclick="getCommentDiv(<?php echo $postId; ?>);"><i class="fa fa-comment" style="color: #337ab7"></i><span class="comment-lbl" data-toggle="tooltip" title="Comments"> Comments</span></a></ul>

							<div class="content collapse" id="collapseExample_<?php echo $postId; ?>">
								<div class="col-md-12 liveCmt">
									<div class="col-md-2">
										<?php  if($currentUserImage == NULL){ ?>
										<img class="cmtUserImg" src="../../userImage/user.png" alt="<?php echo $fname."-".$lname;?> ">
										<?php }else{ ?>
										<img class="cmtUserImg" src="../../userImage/<?php echo $currentUserImage; ?>" alt="<?php echo $fname."-".$lname;?>">
										<?php } ?>
									</div>
									<div class="col-md-7 liveText">
										<div class="input-group">
										    <span class="input-group-addon" style="background-color: #f5f5f5;"><i class="fa fa-edit"></i></span>
										    <textarea class="form-control cmt-txt" name="comments" id="comments<?php echo $postId; ?>" style="background-color: #f5f5f5; border-left: none;"></textarea>
										</div>
									</div>
									<div class="col-md-3">
										<button class="btn btn btn-comment" type="submit" name="submit" id="addComment" onClick="add_comment(<?php echo $postId; ?>)"><i class="fa fa-check"></i></button>
									</div>
								</div>
								<br>
								<div class="commentsDiv_<?php echo $postId; ?> liveCmt-msg"></div>
							</div>
						</div>
					</div>
			</div>
			<?php
			  	} $i++; } }else{
			  	$searchConnect = execute_query($conn, "SELECT * FROM `register_tbl` LEFT JOIN `post_details_tbl` ON post_details_tbl.created_by = register_tbl.register_id WHERE register_tbl.first_name = '".$search."'");
			  	if(mysqli_num_rows($searchConnect) > 0){
			  		while($row = mysqli_fetch_assoc($searchConnect)){ 
			  			$register_id 	= 	$row['register_id'];
				  		$first_name 	= 	$row['first_name'];
				  		$last_name 		= 	$row['last_name'];
				  		$user_image 	= 	$row['user_image'];
			  			?>
			  			<?php 
							$showUser = '#';
							$checkUser = execute_query($conn, "SELECT * FROM `social_details_tbl` WHERE (user_id = '".$userId."' OR user_id = '".$userId."' AND register_id = '".$register_id."' OR register_id = '".$register_id."') AND follower_status = '1'");
							$cntResult = mysqli_num_rows($checkUser);
							if($cntResult > 0){
							/*while($getUser = mysqli_fetch_array($checkUser)){*/ 
									$showUser = "#";
								/*}*/
							}else{
									$showUser = "../profile/userProfile.php?regId=".base64_encode($register_id)."";
								}
							if($cntResult != 0){
						?>
			  			<div class="col-md-6 repeatedDivs search_result unknown_center_div">
							<div class="col-md-4">
								<a href="<?php echo $showUser; ?>">
									<?php if($user_image == NULL){ ?>
									<img class="userImgs" src="../../userImage/user.png" alt="<?php echo $first_name."-".$last_name; ?>">
									<?php }else{ ?>
									<img class="userImgs" src="../../userImage/<?php echo $user_image; ?>" alt="<?php echo $first_name."-".$last_name; ?>">
									<?php
										}
									?>
								</a><br>
							</div>
							<div class="col-md-6 center-content search_by_unknown">
								<input type="hidden" name="userId" class="userFollowId_<?php echo $register_id; ?>" value="<?php echo $userId; ?>">
								<input type="hidden" name="registerId" class="registerFollowId_<?php echo $register_id; ?>" value="<?php echo $register_id; ?>">
								<h5 class="home-headline"><a href="<?php echo $showUser; ?>" class="home-headline"><?php echo ucfirst($first_name).' '.ucfirst($last_name);?></a>
									<!-- <i class="fa fa-check-circle text-success online-icon"></i> -->
									<?php 
									$getFollowerss = execute_query($conn, "SELECT COUNT(social_details_tbl.followers) AS follower FROM `social_details_tbl` JOIN `register_tbl` ON social_details_tbl.register_id = register_tbl.register_id WHERE social_details_tbl.user_id = '$userId' AND register_tbl.register_id = '$register_id' AND social_details_tbl.follower_status = '1' AND social_details_tbl.followers IS NOT NULL");
								  	while($followers = mysqli_fetch_array($getFollowerss)){ $followerIds = $followers['follower']; }
								  	
								  	$getFollowersss = execute_query($conn, "SELECT COUNT(social_details_tbl.followers) AS follower FROM `social_details_tbl` JOIN `register_tbl` ON social_details_tbl.register_id = register_tbl.register_id WHERE social_details_tbl.user_id = '$userId' AND register_tbl.register_id = '$register_id' AND social_details_tbl.follower_status = '0' AND social_details_tbl.followers IS NOT NULL");
								  	while($followerss = mysqli_fetch_array($getFollowersss)){ $followerIdss = $followerss['follower']; }
									?>
									<?php if($register_id != $user_id){ if($followerIds == 1) {   }else if($followerIdss == 1){ ?>
									<label class="btn btn-primary btn-xs" style="cursor: pointer;">Request Sent</label>
									<?php }else{ ?><label class="btn btn-primary btn-xs follow_<?php echo $register_id; ?>" style="cursor: pointer;" onClick="follow_btn(<?php echo $register_id; ?>)"> <i class="fa fa-plus"></i> Connect </label><?php } } ?>
								</h5>
							</div>
						</div>
			  	<?php
			  	} } }else{ echo "<h4 style='text-align: center;'>Sorry, we haven't found any results matching this search</h4>"; } } }
			?>
                <div class="col-md-3 advertisement">
                	<!-- <div class=""><img src="../../assets/images/right-div-img.png" class="ads-img"></div> -->
				</div>
        	</div>
		</div>
	</div>

	<script src="../../assets/js/comments-details.js"></script>
	<script>
		/*var coll = document.getElementsByClassName("collapsible");
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
		}*/
		
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
					window.location.href = "";
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
			//var user_id = $("#userId_"+i).val();
			var post_id = $("#postId_"+i).val();
			//var reg_id = $("#registerId_"+i).val();
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
	</script>
	<script>
	window.onload = function() {
	    document.addEventListener("contextmenu", function(e){
	        e.preventDefault();
	        if(event.keyCode == 123) {
	        disableEvent(e);
	    }
	    }, false);
	 function disableEvent(e) {
	        if(e.stopPropagation) {
	            e.stopPropagation();
	        } else if(window.event) {
	            window.event.cancelBubble = true;
	        }
	    }
	}
	$(document).contextmenu(function() { return false;});
	</script>
</body>
</html>