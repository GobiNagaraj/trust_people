<style>
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
<?php
	include_once '../../model/db.php';
	$conn = db_connect();
	$userId = 	$_SESSION['data']['register_id'];

	$user = execute_query($conn, "SELECT user_image FROM `register_tbl` WHERE register_id = '$userId'");
	while($getImage = mysqli_fetch_assoc($user)){
		$user_image = $getImage['user_image'];
	}
	
if(isset($_POST["limit"], $_POST["start"]))
{
	$postRegId = $_POST["register_id"];
	/* Query for getting most recent Records */
	$sql = "SELECT R.`register_id` AS registerId, R.`first_name` AS firstName, R.`last_name` AS lastName, R.`user_image` AS userImage, P.`post_id` AS postId, P.`post_first_name` AS postFname, P.`post_last_name` AS postLname, P.`title_discussion` AS postTitle, P.`job_location_country` AS jobLocation, P.`job_role` AS jobRole, P.`vendor_name` AS vendorName, P.`linked_url` AS linkedUrl, P.`details` AS postDetails,P.`ratings` AS rating, P.`date_back_out` AS backOutDate, P.`resume` AS resume, P.`created_at` AS postCreated, P.`updated_at` AS postUpdated, S.`state_name` AS stateName, C.`city_name` AS cityName, M.`story_name` AS storyName FROM `register_tbl` AS R JOIN `post_details_tbl` AS P ON R.register_id = P.`created_by` JOIN `company_states_tbl` AS S ON S.state_code = P.job_location_state JOIN `company_cities_tbl` AS C ON C.city_id = P.job_location_city LEFT JOIN `story_category_master_tbl` AS M ON M.`story_category_id` = P.`title_discussion` WHERE R.`status` = '1' AND R.`register_id` = '".$postRegId."' AND P.`status` = '1' AND P.`job_location_country` = 'US' ORDER BY P.`created_at` DESC LIMIT ".$_POST["start"].", ".$_POST["limit"]."";
	$query = execute_query($conn, $sql);

	while($row = mysqli_fetch_assoc($query))
  	{
  		$registerId = 	$row['registerId'];
  		$fname 		= 	$row['firstName'];
  		$lname 		= 	$row['lastName'];
  		$userImage 	= 	$row['userImage'];
  		$postId 	=	$row['postId'];
  		$postFname  = 	$row['postFname'];
  		$postLname  = 	$row['postLname'];
  		if($row['storyName'] == null){
  			$postTitle = $row['postTitle'];
  		}else{
  			$postTitle = $row['storyName'];
  		}
  		//$postTitle 	=	$row['postTitle'];
  		$jobLocation=	$row['jobLocation'];
  		$jobState 	=	$row['stateName'];
  		$jobCity 	=	$row['cityName'];
  		$jobRole 	=	$row['jobRole'];
  		$vendorName = 	$row['vendorName'];
  		$linkedUrl 	=	$row['linkedUrl'];
  		$rating 	= 	$row['rating'];
  		$backDate 	=	$row['backOutDate'];
  		$resume 	=	$row['resume'];
  		$postDetails=	$row['postDetails'];
  		$createdAt 	= 	$row['postCreated'];
  		$updatedAt  = 	$row['postUpdated'];

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
		$getSocialDetails = "SELECT COUNT(S.`yes_iam`) AS cntYes, COUNT(S.`similar_exp`) AS cntExp, COUNT(S.`comments`) AS cntCmt FROM `social_details_tbl` AS S WHERE S.post_id = '".$postId."' ";
	  	$getQuery = execute_query($conn, $getSocialDetails);
	  	while($setSocial = mysqli_fetch_assoc($getQuery)){
	  		$cntYes 	=	$setSocial['cntYes'];
	  		$cntSimilar = 	$setSocial['cntExp'];
	  		$cntCmt 	= 	$setSocial['cntCmt'];	

	  	$getFollowers = execute_query($conn, "SELECT COUNT(social_details_tbl.followers) AS follower FROM `social_details_tbl` JOIN `register_tbl` ON social_details_tbl.register_id = register_tbl.register_id WHERE social_details_tbl.user_id = '".$userId."' AND register_tbl.register_id = '".$registerId."' AND social_details_tbl.follower_status = '1' AND social_details_tbl.followers IS NOT NULL");
	  	while($follower = mysqli_fetch_array($getFollowers)){ $followerId = $follower['follower']; }
	  	
	  	$getFollowerss = execute_query($conn, "SELECT COUNT(social_details_tbl.followers) AS follower FROM `social_details_tbl` JOIN `register_tbl` ON social_details_tbl.register_id = register_tbl.register_id WHERE social_details_tbl.user_id = '".$userId."' AND register_tbl.register_id = '".$registerId."' AND social_details_tbl.follower_status = '0' AND social_details_tbl.followers IS NOT NULL");
	  	while($followers = mysqli_fetch_array($getFollowerss)){ $followerIds = $followers['follower']; }

echo '<div class="col-md-10 repeatedDiv-profile search_result">
	<div class="col-md-2">
	</div>
	<div class="col-md-12">
		<h3 class="h3Forenterprise">'.$postTitle.'</h3>
		<hr style="margin-top: 0px; margin-bottom: 5px;">';
		 if ($linkedUrl != ''){ $linkedUrl = $linkedUrl; }else { $linkedUrl = ''; } 
		echo '<table width="100%" style="color: #0045ab;">
			<tr>
				<td width="10%"><b>Candidate Name : </b></td>
				<td width="20%">'.$postFname.' '.$postLname.'&nbsp;&nbsp;&nbsp;'; for($k = 1; $k <= $rating; $k++){ echo '<i class="fa fa-star" style="color: #f2bb13;"></i>'; } echo '</td>
				<td width="20%">'; if ($resume != ''){ ; echo '<a href="../viewPdf.php?r='.$resume.'" target="_blank" class="btn btn-sm btn-danger" data-toggle="tooltip" title="View Resume"><i class="fa fa-file"></i></a>&nbsp;'; } if ($linkedUrl != ''){ echo '<a href="'.$linkedUrl.'" target="_blank" class="btn btn-sm btn-info" data-toggle="tooltip" title="View Profile"> <i class="fa fa-linkedin"></i></a>'; } echo '</td>
			</tr>
		</table><br>
		<table width="100%" style="color: #0045ab;">
			<tr>
				<td width="14%"><b>Applied Role : </b></td>
				<td width="25%">'.$jobRole.'</td>';
				if($vendorName != null){
					echo '<td width="14%"><b>Vendor Name : </b></td>
						  <td width="25%">'.$vendorName.'</td>';
				}
				echo'<td width="12%"><b>Location : </b></td>
				<td width="20%">'.$jobState.', '.$jobCity.'</td>
			</tr>
		</table>
		<p class="enterpriseCnt" style="margin-top: 12px;">'.$postDetails.'</p>
		<hr style="border-top: 1px solid #f7f7f7;">
		<div class="col-md-5 profile-div-left">
			<label>Post Date :  '.$updatedAt.' </label>
		</div>
		<div class="col-md-5 profile-div-right">';
		  echo '<input type="hidden" name="userId" id="userId_'.$postId.'" value="'.$userId.'">
				<input type="hidden" name="postId" id="postId_'.$postId.'" value="'.$postId.'">
				<input type="hidden" name="registerId" id="registerId_'.$postId.'" value="'.$registerId.'">';
			 
				$demoCnt = execute_query($conn, "SELECT COUNT(yes_iam) AS yes, COUNT(similar_exp) AS same, COUNT(comments) AS cmt FROM `social_details_tbl` WHERE user_id = '$userId' AND post_id = '".$postId."' AND register_id = '".$registerId."'");
				while($demo = mysqli_fetch_assoc($demoCnt)){
					$countofYes 	= 	$demo['yes'];
					$countofSame	=	$demo['same'];
					$countofCmt		=	$demo['cmt'];
				} 
				echo '<ul>
				        <li><span id="yes_cnt" class="yesCount_'.$postId.'">'.$cntYes.'</span>&nbsp;&nbsp;&nbsp;';
				 if($countofYes == 0){
				 	echo '<span class="activeHeart_'.$postId.'" style="cursor: pointer;" data-toggle="tooltip" title="Trustable" onclick="postYes('.$postId.');"><i class="fa fa-thumbs-o-up" id="activeHeartIcon_'.$postId.'"></i><span class="trust-lbl" onmouseover="getTrustableList('.$postId.')"> Trustable</span>&nbsp;&nbsp;&nbsp;</span>';
				 }if($countofYes >= 1){
				 	echo '<span style="cursor: pointer;" data-toggle="tooltip" title="Trustable" onclick="postYes('.$postId.');"><i class="fa fa-thumbs-up like-symbol" id="activeHeartIcon_'.$postId.'"></i><span class="trust-lbl" onmouseover="getTrustableList('.$postId.')"> Trustable</span>&nbsp;&nbsp;&nbsp;</span>';
				 }
				 echo '<ul class="dropdown trust_list_'.$postId.'"></ul>
				        </li>';	

				echo '<li><span id="same_cnt" class="sameCount_'.$postId.'">'.$cntSimilar.' </span>&nbsp;&nbsp;&nbsp;';
				 if($countofSame == 0){ 
				echo '<span class="activeLike_'.$postId.'" data-toggle="tooltip" title="Untrustable" onclick="postSame('.$postId.')" style="cursor: pointer;"><i class="fa fa-thumbs-o-down" id="activeLikeIcon_'.$postId.'"></i><span class="un-trust-lbl" onmouseover="getUnTrustableList('.$postId.')"> Untrustable</span>&nbsp;&nbsp;&nbsp;</span>'; } if($countofSame >= 1){ echo '<span style="cursor: pointer;" data-toggle="tooltip" title="Untrustable" onclick="postSame('.$postId.')"><i class="fa fa-thumbs-down like-symbol" id="activeLikeIcon_'.$postId.'"></i><span class="un-trust-lbl" onmouseover="getUnTrustableList('.$postId.')"> Untrustable</span>&nbsp;&nbsp;&nbsp;</span>';  }
				echo '<ul class="dropdown un_trust_list_'.$postId.'"></ul>
					</li>';
				echo '<span id="cmts_cnt" class="cmtCount_'.$postId.'">'.$cntCmt.'</span>&nbsp;&nbsp;&nbsp;<a data-toggle="collapse" href="#collapseExample_'.$postId.'" role="button" aria-expanded="false" aria-controls="collapseExample" onclick="getCommentDiv('.$postId.');"><i class="fa fa-comment" style="color: #337ab7"></i><span class="comment-lbl" data-toggle="tooltip" title="Comments"> Comments</span></a></ul></div><br>';
				echo '<div class="content collapse" id="collapseExample_'.$postId.'">
					<div class="col-md-12 liveCmt">
						<div class="col-md-2">';
							 if($user_image == NULL){ 
							echo '<img class="cmtUserImg" src="../../userImage/user.png" alt="'. $fname.'"-"'.$lname.'; ">';
							 }else{ 
							echo '<img class="cmtUserImg" src="../../userImage/'.$user_image.'" alt="'.$fname.'"-"'.$lname.'">';
								}
						echo '</div>
						<div class="col-md-7 liveText">
							<div class="input-group">
							    <span class="input-group-addon" style="background-color: #f5f5f5;"><i class="fa fa-edit"></i></span>
							    <textarea class="form-control cmt-txt" name="comments" id="comments'.$postId.'" style="background-color: #f5f5f5; border-left: none; margin: 0px;"></textarea>
							</div>
						</div>
						<div class="col-md-3">
							<button class="btn btn btn-comment" type="submit" name="submit" id="addComment" onClick="add_comment('.$postId.')"><i class="fa fa-check"></i></button>
						</div>
					</div>
					<br>
					<div class="commentsDiv_'.$postId.' liveCmt-msg"></div>
				</div>
			</div>
		</div>
	</div>
</div>';
  	} } }
?>

<script>
    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>