<?php 
	include_once '../../model/db.php';
	$conn = db_connect();

	$userId = $_SESSION['data']['register_id'];
    if($userId == null)
  	{
    	header('Location: ../../');
  	}	

  	$selectUser = execute_query($conn, "SELECT register_id, first_name, last_name, user_image FROM `register_tbl` WHERE register_id = '$userId'");
  	while($users = mysqli_fetch_assoc($selectUser)){
  		$first_name		= 	$users['first_name'];
  		$last_name		= 	$users['last_name'];
  		$user_image 	=	$users['user_image'];
  		$registerId 	=	$users['register_id'];
  	}
	if(isset($_GET['regId']))
	{
	  	$regId = base64_decode($_GET['regId']);

	  	$sql = "SELECT R.`register_id`, R.`first_name`, R.`last_name`, R.`reg_title_id`, R.`title`, R.`email_address`,R.`country_code`, R.`mobile_number`, R.`user_image`, R.`company_name`, R.`company_website`, R.`mobile_privacy`, R.`email_privacy`, T.`title_name`, U.`about_info` FROM `register_tbl` AS R LEFT JOIN `title_tbl` AS T ON T.`title_id` = R.`reg_title_id` LEFT JOIN `user_personal_details_tbl` AS U ON U.`register_id` = R.`register_id` WHERE R.`register_id` = '$regId' AND R.status = '1'";
	  	$query = execute_query($conn, $sql);
	  	while($row = mysqli_fetch_assoc($query))
	  	{
	  		$registerId 	=	$row['register_id'];
	  		$firstName		= 	$row['first_name'];
	  		$lastName		= 	$row['last_name'];
	  		$title  		= 	$row['title'];
	  		$titleName 		=	$row['title_name'];
	  		$emailId 		= 	$row['email_address'];
	  		$countryCode 	= 	$row['country_code'];
	  		$mobile 	 	= 	$row['mobile_number'];
	  		$userImage 		=	$row['user_image'];
	  		$companyName 	=	$row['company_name'];
	  		$website 		=	$row['company_website'];
	  		$fname 			= 	$row['first_name'];
	  		$lname 			= 	$row['last_name'];
	  		$mobPrivacy 	=	$row['mobile_privacy'];
	  		$emaPrivacy 	=	$row['email_privacy'];
	  		$abtInfo		=	$row['about_info'];
	  	}

	  	$abtInfos = explode("-", $abtInfo);
	  	$information = implode("/", $abtInfos);

	  	$getPostCnt = execute_query($conn, "SELECT COUNT(`post_id`) AS posts FROM post_details_tbl JOIN register_tbl ON register_tbl.register_id = post_details_tbl.created_by WHERE post_details_tbl.created_by = '$regId' AND post_details_tbl.job_location_country = 'US'");
	  	while($post = mysqli_fetch_assoc($getPostCnt)){
	  		$postCnt 		= 	$post['posts'];
	  	}

	  	$getFollowersCnt = execute_query($conn, "SELECT COUNT(`followers`) AS followers FROM social_details_tbl JOIN register_tbl ON social_details_tbl.user_id = register_tbl.register_id WHERE social_details_tbl.register_id = '$regId' AND social_details_tbl.follower_status = '1'");
	  	while($followers = mysqli_fetch_assoc($getFollowersCnt)){
	  		$followersCnt 		= 	$followers['followers'];
	  	}

	  	$getFollowingCnt = execute_query($conn, "SELECT COUNT(`followers`) AS following FROM social_details_tbl JOIN register_tbl ON register_tbl.register_id = social_details_tbl.user_id WHERE social_details_tbl.user_id = '$regId' AND social_details_tbl.follower_status = '1'");
	  	while($following = mysqli_fetch_assoc($getFollowingCnt)){
	  		$followingCnt 	=	$following['following'];
	  	}

	  	$getFollowers = execute_query($conn, "SELECT COUNT(social_details_tbl.followers) AS follower FROM `social_details_tbl` JOIN `register_tbl` ON social_details_tbl.register_id = register_tbl.register_id WHERE social_details_tbl.user_id = '".$userId."' AND register_tbl.register_id = '".$registerId."' AND social_details_tbl.follower_status = '1' AND social_details_tbl.followers IS NOT NULL");
	  	while($follower = mysqli_fetch_array($getFollowers)){ $followerId = $follower['follower']; }
	  	
	  	$getFollowerss = execute_query($conn, "SELECT COUNT(social_details_tbl.followers) AS follower FROM `social_details_tbl` JOIN `register_tbl` ON social_details_tbl.register_id = register_tbl.register_id WHERE social_details_tbl.user_id = '".$userId."' AND register_tbl.register_id = '".$registerId."' AND social_details_tbl.follower_status = '0' AND social_details_tbl.followers IS NOT NULL");
	  	while($followers = mysqli_fetch_array($getFollowerss)){ $followerIds = $followers['follower']; }
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Trust People User Profile Page</title>
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
	<div class="">
		<?php include_once '../header/nav_bar.php'; ?>
	</div>

	<div class="main">
		<div class="container">
			<input type="hidden" name="register_id" id="reg_id" value="<?php echo $regId; ?>">
			<input type="hidden" id="post_count" value="<?php echo $postCnt; ?>">
			<div class="col-md-12 profileDiv">
				<div class="col-md-3 mobileProfile">
					<?php 
						if($userImage == NULL){ ?>
					<img class="profileImg" src="../../userImage/user.png">
					<?php
						}else{ ?>
					<img class="profileImg" src="../../userImage/<?php echo $userImage; ?>">
					<?php
						}
					?>
					<br>
				</div>
				<div class="col-md-9">
					<h3 class="h3Profile"><?php echo ucfirst($firstName). " ".ucfirst($lastName); ?></h3>
					<h4><?php echo $information; ?></h4>
					<?php 
						if($title == ''){
							$title = $titleName;
						}else{
							$title = $title;
						}
					?>
					<div class="col-md-6">
						<?php if($title != ''){ ?><h4>Designation : <?php echo $title; ?></h4>	<?php }?>
					</div>
					<div class="col-md-6">
						<?php if($companyName != ''){ ?><h4>Company Name : <?php echo $companyName; ?></h4> <?php } ?>
					</div>
					<?php if($mobPrivacy == '1'){ ?>
					<div class="col-md-6">
						<?php if($mobile != ''){ ?><h4>Mobile Number : <?php echo $countryCode; ?> - <?php echo $mobile; ?></h4> <?php } ?>
					</div>
					<?php } ?>
					<?php if($emaPrivacy == '1'){ ?>
					<div class="col-md-6">
						<?php if($emailId != ''){ ?><h4>Email ID : <?php echo $emailId; ?></h4> <?php } ?>
					</div>
					<?php } ?>
					<h2 class="profileH2"><i class="fa fa-paper-plane"></i> Posts - <span id="totalPost"><?php echo $postCnt; ?></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-users"></i> Connections - <span id="totalFollowers"><?php echo $followersCnt; ?></span></h2>
				</div>
			</div>
			<span id="empty_post"><h4 style="text-align: center;">There is no posts</h4></span>
		    <div id="load_data_profile"></div>
		    <br>
		    <div id="load_data_profile_message"></div>
		</div>
	</div>

	<script src="../../assets/js/comments-details.js"></script>

	<script>
		$(document).ready(function(){
			if($("#post_count").val() > 0){
				$("#empty_post").hide();
				var limit = 3;
			 	var start = 0;
			 	var action = 'inactive';
			 	var reg_id = $("#reg_id").val();
			 	function load_country_data(limit, start)
			 	{	
			  		$.ajax({
			   		url:"userProfilePosts.php",
			   		method:"POST",
			   		data:{limit:limit, start:start, register_id:reg_id},
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
	</script>
</body>
</html>