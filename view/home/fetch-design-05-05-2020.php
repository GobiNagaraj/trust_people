<?php
	$userId = 	$_SESSION['data']['register_id'];
	include_once '../../model/db.php';
	$conn = db_connect();
	
if(isset($_POST["limit"], $_POST["start"]))
{
	/* Query for getting most recent Records */
	$sql = "SELECT R.`register_id` AS registerId, R.`first_name` AS firstName, R.`last_name` AS lastName, R.`user_image` AS userImage, P.`post_id` AS postId, P.`post_first_name` AS postFname, P.`post_last_name` AS postLname, P.`title_discussion` AS postTitle, P.`job_location_country` AS jobLocation, P.`job_role` AS jobRole, P.`linked_url` AS linkedUrl, P.`details` AS postDetails,P.`ratings` AS rating, P.`date_back_out` AS backOutDate, P.`resume` AS resume, P.`created_at` AS postCreated, S.`state_name` AS stateName, C.`city_name` AS cityName FROM `register_tbl` AS R JOIN `post_details_tbl` AS P ON R.register_id = P.`created_by` JOIN `company_states_tbl` AS S ON S.state_code = P.job_location_state JOIN `company_cities_tbl` AS C ON C.city_id = P.job_location_city WHERE R.`status` = '1' AND P.`status` = '1' AND P.`job_location_country` = 'US' ORDER BY P.`created_at` DESC LIMIT ".$_POST["start"].", ".$_POST["limit"]."";
	$query = execute_query($conn, $sql);

	$i = 1;
	while($row = mysqli_fetch_assoc($query))
  	{
  		$registerId = 	$row['registerId'];
  		$fname 		= 	$row['firstName'];
  		$lname 		= 	$row['lastName'];
  		$userImage 	= 	$row['userImage'];
  		$postId 	=	$row['postId'];
  		$postFname  = 	$row['postFname'];
  		$postLname  = 	$row['postLname'];
  		$postTitle 	=	$row['postTitle'];
  		$jobLocation=	$row['jobLocation'];
  		$jobState 	=	$row['stateName'];
  		$jobCity 	=	$row['cityName'];
  		$jobRole 	=	$row['jobRole'];
  		$linkedUrl 	=	$row['linkedUrl'];
  		$rating 	= 	$row['rating'];
  		$backDate 	=	$row['backOutDate'];
  		$resume 	=	$row['resume'];
  		$postDetails=	$row['postDetails'];
  		$createdAt 	= 	$row['postCreated'];

  		$date = strtotime($createdAt);
  		$createdAt = date('M d, Y h:i A', $date);

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

echo '<div class="col-md-8 repeatedDivs search_result">
	<input type="hidden" name="userId" id="userId" value="'.$userId.'">
	<input type="hidden" name="postId" id="postId" value="'.$postId.'">
	<div class="col-md-2">
		<a href="../profile/userProfile.php?regId='.$registerId.'">';
			 if($userImage == NULL){ 
			echo '<img class="userImgs" src="../../userImage/user.png" alt="'.$fname.'"-"'.$lname.'">';
			 }else{ 
			echo '<img class="userImgs" src="../../userImage/'.$userImage.'" alt="'.$fname."-".$lname.'">';
				}
		echo '</a><br>
	</div>
	<div class="col-md-10">
		<h5 class="home-headline">'.ucfirst($fname).' '.ucfirst($lname).'
			<i class="fa fa-check-circle text-success online-icon"></i>';
			 if($registerId != $userId){ if($followerId == 1) {   }else if($followerIds == 1){
			echo '<a href="#" class="btn btn-primary btn-xs">Request Sent</a>
			 }else{ <a href="#" data-userid="'.$userId.'" data-registerid="'.$registerId.'" class="btn btn-primary btn-xs follow_btn"> <i class="fa fa-plus"></i> Connect </a>'; } }
		echo '</h5>
		<h3 class="h3Forenterprise">'.$postTitle.'</h3>
		<hr style="margin-top: 0px; margin-bottom: 5px;">';
		 if ($linkedUrl != ''){ $linkedUrl = $linkedUrl; }else { $linkedUrl = ''; } 
		echo '<table width="100%" style="color: #0045ab;">
			<tr>
				<td width="10%"><b>Candidate Name : </b></td>
				<td width="20%">'.$postFname.' '.$postLname.'&nbsp;&nbsp;&nbsp;'; for($k = 1; $k <= $rating; $k++){ echo '<i class="fa fa-star" style="color: #f2bb13;"></i>'; } echo '</td>
				<td width="20%">'; if ($resume != ''){ ; echo '<a href="../../resumeFiles/'.$resume.'#toolbar=0" target="_blank" class="btn btn-sm btn-danger"><i class="fa fa-download"></i></a>&nbsp;'; } if ($linkedUrl != ''){ echo '<a href="'.$linkedUrl.'" target="_blank" class="btn btn-sm btn-info"> <i class="fa fa-linkedin"></i></a>'; } echo '</td>
			</tr>
		</table><br>
		<table width="100%" style="color: #0045ab;">
			<tr>
				<td width="15%"><b>Applied role : </b></td>
				<td width="25%">'.$jobRole.'</td>
				<td width="12%"><b>Location : </b></td>
				<td width="20%">'.$jobState.', '.$jobCity.'</td>
			</tr>
		</table>
		<p class="enterpriseCnt" style="margin-top: 12px;">'.$postDetails.'</p>
	</div>
	<hr class="comment-hr">
	<div class="col-md-12">
		<div class="col-md-6 posted-dt">
			<label>Post Date :  '.$createdAt.' </label>
		</div>
		<div class="col-md-6 social-icons-home">
			<input type="hidden" name="user_id" id="user_id_'.$i.'" value="'.$userId.' ">
			<input type="hidden" name="post_id" id="post_id_'.$i.'" value="'.$postId.' ">
			<input type="hidden" name="register_id" id="register_id_'.$i.'" value="'.$registerId.' ">';
			 
				$demoCnt = execute_query($conn, "SELECT COUNT(yes_iam) AS yes, COUNT(similar_exp) AS same, COUNT(comments) AS cmt FROM `social_details_tbl` WHERE user_id = '$userId' AND post_id = '".$postId."' AND register_id = '".$registerId."'");
				while($demo = mysqli_fetch_assoc($demoCnt)){
					$countofYes 	= 	$demo['yes'];
					$countofSame	=	$demo['same'];
					$countofCmt		=	$demo['cmt'];
				} 
				echo '<span id="yes_cnt">'.$cntYes.' </span>&nbsp;&nbsp;';
				 if($countofYes == 0){
				echo '<a href="#"  title="Yes. I am with you." onclick="postYes('.$i.');"><i class="fa fa-heart-o"></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a>'; } if($countofYes == 1){  echo '<a href="#"  title="Yes. I am with you." ><i class="fa fa-heart like-heart"></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a>';  } 
				echo '<span id="same_cnt">'.$cntSimilar.' </span>&nbsp;&nbsp;';
				 if($countofSame == 0){ 
				echo '<a href="#" title="Ive had a similar experience." onclick="postSame('.$i.')"><i class="fa fa-thumbs-o-up"></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a>'; } if($countofSame == 1){ echo '<a href="#" title="Ive had a similar experience."><i class="fa fa-thumbs-up"></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a>';  } 
				echo '<span id="cmts_cnt">'.$cntCmt.'</span>&nbsp;&nbsp;
				<a class="collapsible" id="showDiv_'.$i.'" type="button" title="Comments" onclick="getCommentDiv('.$i.');"><i class="fa fa-comment" style="color: #337ab7"></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a>
				<div class="content row">
					<div class="col-md-12 liveCmt">
						<div class="col-md-2">';
							 if($userImage == NULL){ 
							echo '<img class="cmtUserImg" src="../../userImage/user.png" alt="'. $fname.'"-"'.$lname.'; ">';
							 }else{ 
							echo '<img class="cmtUserImg" src="../../userImage/'.$userImage.'" alt="'.$fname.'"-"'.$lname.'">';
								}
						echo '</div>
						<div class="col-md-7 liveText">
							<input type="hidden" name="userId" id="userId_'.$i.'" value="'.$userId.'">
							<input type="hidden" name="postId" id="postId_'.$i.'" value="'.$postId.'">
							<input type="hidden" name="registerId" id="registerId_'.$i.'" value="'.$registerId.'">
							<div class="input-group">
							    <span class="input-group-addon" style="background-color: #f5f5f5;"><i class="fa fa-edit"></i></span>
							    <textarea class="form-control cmt-txt" name="comments" id="comments'.$i.'" style="background-color: #f5f5f5; border-left: none;"></textarea>
							</div>
						</div>
						<div class="col-md-3">
							<button class="btn btn btn-comment" type="submit" name="submit" id="addComment" onClick="add_comment('.$i.')"><i class="fa fa-check"></i></button>
						</div>
					</div>
					<br>
					<div class="commentsDiv_'.$i.' liveCmt-msg"></div>
				</div>
			</div>
		</div>
</div>';
	$i++;
  	} }
}
?>