<style>
	.edit-post-text{
		margin: 0px 70px;
	}
	.job_state, .edit-post-rating{
		margin: 0px;
		width: 180%;
	}
	.post-city-txt {
	    width: 115%;
	    margin-left: -25px;
	}
	.edit-resume{
		margin: 0px 20px;
	}
</style>
<?php 
	include_once '../model/db.php';
	$conn = db_connect();

	$json = array();
	if(isset($_POST['edit_post_id'])){
		$post_id = $_POST['edit_post_id'];

		$sql = "SELECT P.`post_id`, P.`post_first_name`, P.`post_last_name`, P.`job_role`, P.`vendor_name`, P.`linked_url`, P.`ratings`, P.`resume`, P.`title_discussion`, P.`details`, P.`job_location_state`, P.`job_location_city`, S.`state_name`, C.`city_name`, M.`story_name` FROM `post_details_tbl` AS P JOIN `company_states_tbl` AS S ON S.`state_code` = P.`job_location_state` JOIN `company_cities_tbl` AS C ON C.`city_id` = P.`job_location_city` LEFT JOIN `story_category_master_tbl` AS M ON M.`story_category_id` = P.`title_discussion` WHERE P.`post_id` = '".$post_id."'";

		$result = execute_query($conn, $sql);
		$response = '';
		if($result){
			while($row = mysqli_fetch_assoc($result)){
				$post_edit_id 	=	$row['post_id'];
				$postFName 		=	$row['post_first_name'];
				$postLName 		=	$row['post_last_name'];
				$postJobRole 	=	$row['job_role'];
				$postVendor 	=	$row['vendor_name'];
				$postLinkedin 	=	$row['linked_url'];
				$postRatings 	=	$row['ratings'];
				$postResume 	=	$row['resume'];
				$postTitle 		=	$row['title_discussion'];
				$postDetails 	=	$row['details'];
				$postState 		=	$row['job_location_state'];
				$postCity 		=	$row['job_location_city'];
				$postStateName	=	$row['state_name'];
				$postCityName	=	$row['city_name'];
				$postStoryName 	=	$row['story_name'];
			}
				//$json[] = $row;

				$response .= '<form id="editPost-form" enctype="multipart/form-data">
			    <div class="modal-content">
			    <input type="hidden" name="post_edit_id" value="'.$post_edit_id.'" >
			      <div class="modal-header">
			        <button type="button" class="close" data-dismiss="modal">&times;</button>
			        <h4 class="modal-title"><span class="post_now">Edit Post</span></h4>
			      </div>
			      <div class="modal-body">
			      <label>Please edit the details about your experience with a candidate</label><br><br>
			<div class="row form-group">
				<div class="col-md-4">
					<label>Candidate First Name</label> <span id="mandatory">*</span>
				</div>
				<div class="col-md-6">
					<input type="text" name="post_first_name" id="post_first_name" class="form-control edit-post-text txtPost" required autocomplete="off" value="'.$postFName.'">
				</div>
			</div>
			<div class="row form-group">
				<div class="col-md-4">
					<label>Candidate Last Name</label> <span id="mandatory">*</span>
				</div>
				<div class="col-md-6">
					<input type="text" name="post_last_name" id="post_last_name" class="form-control edit-post-text txtPost" required autocomplete="off" value="'.$postLName.'">
				</div>
			</div>
			<div class="row form-group">
				<div class="col-md-4">
					<label>Job Location</label> <span id="mandatory">*</span>
				</div>
				<div class="col-md-6 job_location_country">
					<div class="col-md-4">
						<input type="hidden" name="job_location" id="job_location" class="form-control edit-post-text" value="US" placeholder="US" readonly>';
						$response .= '<select class="form-control edit-post-text job_state" id="job_state" name="job_state" required>
							<option value="">Select State</option>';
							$selected = '';
							$state = execute_query($conn, "SELECT state_id, state_name, state_code FROM `company_states_tbl` WHERE status = '1'");
								while($getState = mysqli_fetch_assoc($state)){ 
									if($getState["state_code"] == $postState){
										$selected = "selected";
									}else{
										$selected = "";
									}
						$response .= '<option value="'.$getState["state_code"].'" '.$selected.'>'.$getState["state_name"].'('.$getState["state_code"].')</option>';
							}
						$response .= '</select>';
					$response .= '</div>
					<div class="col-md-6 post_city"><input type="hidden" name="post_cmp_id" value="'.$postCity.'" id="post_cmp_id">';
						$response .= '<select class="form-control edit-post-text post-city-txt" id="post_city" name="post_city" required>';
					$response .= '</select>';
					$response .= '</div>
				</div>
			</div>

			<div class="row form-group">
				<div class="col-md-4">
					<label>Job Role</label> <span id="mandatory">*</span>
				</div>
				<div class="col-md-6">
					<input type="text" name="job_role" id="job_role" class="form-control edit-post-text txtPost" required autocomplete="off" value="'.$postJobRole.'">
				</div>
			</div>

			<div class="row form-group">
				<div class="col-md-4">
					<label>Vendor Name</label>
				</div>
				<div class="col-md-6">
					<input type="text" name="vendor_name" id="vendor_name" class="form-control edit-post-text txtPost" autocomplete="off" value="'.$postVendor.'">
				</div>
			</div>

			<div class="row form-group">
				<div class="col-md-4">
					<label>Candidate LinkedIn Url <span id="mandatory">*</span></label> 
				</div>
				<div class="col-md-6">
					<input type="text" name="linked_url" id="linked_url" class="form-control edit-post-text txtPost" required autocomplete="off" value="'.$postLinkedin.'">
					<span class="linkedin_url"></span>
				</div>
			</div>
			<input type="hidden" class="edit-rating" id="edit-rating" value="'.$postRatings.'">';

			$response .= '<div class="row form-group" style="margin-top: -15px;">
				<div class="col-md-4">
					<label>Rating <span id="mandatory">*</span></label>
				</div>
				<div class="col-md-6">
					<div class="rate">
					<select class="form-control edit-post-rating" id="rating_val" name="rating_val" required>
					<option value="">Select Rating</option>';
						$selectRating = '';
					    for($r = 1; $r <= 5; $r++){
					    	if($postRatings == $r){
					    		$selectRating = 'selected';
					    	}else{
					    		$selectRating = '';
					    	}
					    	$response .= '<option value="'.$r.'" '.$selectRating.'>'.$r.'</option>';
					    }
					$response .= '</select></div>
				</div>
			</div>';

			$response .= '<div class="row form-group">
				<div class="col-md-4">
					<label>Resume </label>
				</div>
				<div class="col-md-6">';
					$response .= '<input type="hidden" name="resume_file" id="resume_file" value="'.$postResume.'"><input type="file" name="resume" id="resume" class="form-control edit-post-text txtPost editResume" accept=".pdf" autocomplete="off">
					<span class="image_validation" style="margin: 0px 70px; font-size: 11px;"></span>
				</div>';
				if($postResume != ""){
					$response .= '<div class="col-md-1 edit-resume"><a href="../viewPdf.php?r='.$postResume.'" target="_blank" class="btn btn-sm btn-danger"><i class="fa fa-download"></i></a></div>';
				}
			$response .= '</div>
			<div class="row form-group positive-story">
				<div class="col-md-4">
					<label>Story Title</label> <span id="mandatory">*</span>
				</div>
				<div class="col-md-6">';
					$response .= '<select class="form-control edit-post-text txtPost positive_category" name="post_category[]" id="positive_category">
						<option value="">Select Category Name</option>';
							$showStory = execute_query($conn, "SELECT * FROM `story_category_master_tbl` WHERE status = '1' LIMIT 18, 6");
							$selectedStory = '';
							while($story = mysqli_fetch_assoc($showStory)){
								if($story["story_category_id"] == $postTitle){
									$selectedStory = "selected";
								}else{
									$selectedStory = "";
								}
					$response .= '<option value="'.$story["story_category_id"].'" '.$selectedStory.'>'.$story["story_name"].'</option>';
					}
					if(!is_numeric($postTitle)){
						$selectedStory = "selected";
						$story["story_category_id"] = '18';
					}
					$response .= '<option value="18" '.$selectedStory.'>Others</option></select>';					
				$response .= '</div>
			</div>';
			$response .= '<div class="row form-group negative-story">
				<div class="col-md-4">
					<label>Category Name</label> <span id="mandatory">*</span>
				</div>
				<div class="col-md-6">';
					$response .= '<select class="form-control edit-post-text txtPost post_category" name="post_category[]" id="post_category">
						<option value="">Select Category Name</option>';
							$showStory = execute_query($conn, "SELECT * FROM `story_category_master_tbl` WHERE status = '1' LIMIT 0, 17");
							$selectedStory = '';
							while($story = mysqli_fetch_assoc($showStory)){
								if($story["story_category_id"] == $postTitle){
									$selectedStory = "selected";
								}else{
									$selectedStory = "";
								}
					$response .= '<option value="'.$story["story_category_id"].'" '.$selectedStory.'>'.$story["story_name"].'</option>';
					}
					if(!is_numeric($postTitle)){
						$selectedStory = "selected";
						$story["story_category_id"] = '18';
					}
					$response .= '<option value="18" '.$selectedStory.'>Others</option></select>';
				$response .= '</div>
			</div>
			<div class="row form-group other_category" style="display: none;">
				<div class="col-md-4">
					<label>Sub Category Name</label> <span id="mandatory">*</span>
				</div>
				<div class="col-md-6">
					<input type="text" name="sub_category" id="sub_category" class="form-control edit-post-text txtPost sub_category" value="'.$postTitle.'">
				</div>
			</div>
			<div class="row form-group">
				<div class="col-md-4">
					<label>Story</label> <span id="mandatory">*</span>
				</div>
				<div class="col-md-6">
					<textarea class="details_area txtPost" name="details" id="details" rows="6" cols="6" required autocomplete="off">'.$postDetails.'</textarea>
				</div>
			</div>
			<span id="mandatory">* Fields are mandatory</span>
			</div>
			    <div class="modal-footer">
			      	<input type="submit" name="post_now" id="post-btn" value="Submit" class="btn btn-primary">
			        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
			    </div>
			</div>
		    </form>';
		}
		//$data['data'] = $json;
		//echo json_encode($data);
		echo $response;
	}

?>

<script>

	$(function(){
		/*$(".rate > label").on("click", function(event)
		{
		    radio_value = $(this).prev("input[type='radio']").val();
		    //alert(radio_value);
		    $(".rating_val").val(radio_value);
		});*/
	});
	$(document).ready(function(){
		$(".positive-story").hide();
		$(".negative-story").hide();
		
		var editRating = $(".edit-rating").val();
		if((editRating >= 1) && (editRating <= 2)){
	    	$(".negative-story").show();
	    	$(".positive-story").hide();
	    }

	    if((editRating >= 3) && (editRating <= 5)){
	    	$(".negative-story").hide();
	    	$(".positive-story").show();
	    }

		$(".image_validation").css('color', 'red').html('Please attach a pdf file only');

		$("select.job_state").ready(function(){
	        var stateCode = $(".job_state").val();
			var city = '<option value="">Select City</option>';
			var post_cmp_id = $("#post_cmp_id").val();

			if(stateCode != ''){
				$.ajax({
		        	url: '../../controller/getCityName.php',
		        	type: 'post',
		        	data: { 'state_id' : stateCode },
		        	dataType: 'json',
		        	success:function(data){
		        		console.log(data);
		        		$.each( data, function( key, value ) {
		        			var city_id = value.city_id;
		        			var city_name = value.city_name;
		        			if(post_cmp_id == city_id){
		        				var select_city = "selected";
		        			}else{
		        				var select_city = "";
		        			}
		        			city += '<option value="'+city_id+'" '+select_city+'>'+city_name+'</option>';
		        		});
		        		$(".post-city-txt").html(city);
		        	}
		        });
			}
			else {
	          $('.post-city-txt').html(city);
	        }
	    });

	    $("select.job_state").change(function(){
	        var stateCode = $(this).children("option:selected").val();
			var city = '<option value="">Select City</option>';
			var post_cmp_id = $("#post_cmp_id").val();

			if(stateCode != ''){
				$.ajax({
		        	url: '../../controller/getCityName.php',
		        	type: 'post',
		        	data: { 'state_id' : stateCode },
		        	dataType: 'json',
		        	success:function(data){
		        		console.log(data);
		        		$.each( data, function( key, value ) {
		        			var city_id = value.city_id;
		        			var city_name = value.city_name;
		        			if(post_cmp_id == city_id){
		        				var select_city = "selected";
		        			}else{
		        				var select_city = "";
		        			}
		        			city += '<option value="'+city_id+'" '+select_city+'>'+city_name+'</option>';
		        		});
		        		$(".post-city-txt").html(city);
		        	}
		        });
			}
			else {
	          $('.post-city-txt').html(city);
	        }
	    });
	});

	$(".post_category").ready(function(){
		var getStoryId = $(".post_category").val();
		if(getStoryId == '18'){
			$(".other_category").show();
		}
	});

	$(".positive_category").ready(function(){
		var positiveStoryId = $(".positive_category").val();
		if(positiveStoryId == '18'){
			$(".other_category").show();
		}
	});

	$("select.post_category").change(function(){
		var postCategory = $(this).children("option:selected").val();
		if(postCategory == '18'){
			$(".other_category").show();
			$(".sub_category").focus().val('');
		}else{
			$(".other_category").hide();
		}
	});

	$("select.positive_category").change(function(){
		var positiveCategory = $(this).children("option:selected").val();
		if(positiveCategory == '18'){
			$(".other_category").show();
			$(".sub_category").focus().val('');
		}else{
			$(".other_category").hide();
		}
	});

	$("select.edit-post-rating").change(function(){
		var editPostCat = $(this).children("option:selected").val();

		if((editPostCat >= 1) && (editPostCat <= 2)){
	    	$(".negative-story").show();
	    	$(".positive-story").hide();
	    }

	    if((editPostCat >= 3) && (editPostCat <= 5)){
	    	$(".negative-story").hide();
	    	$(".positive-story").show();
	    }
	});

	$(".editResume").bind('change', function(){
		var size=(this.files[0].size);
        var exte=(this.files[0].name);
        //var fileName = $(".editResume").val();
        fextension = exte.substring(exte.lastIndexOf('.')+1);
        validExtensions = ["pdf","PDF"];

        if ($.inArray(fextension, validExtensions) == -1){
            $(".image_validation").css('color', 'red').html('Attachment should allow only pdf file.');
            this.value = "";
            return false;
        }else{
        	if(size > 20971520) {
	            $(".image_validation").css('color', 'red').html('Please upload a file size less than 20 MB');
	            $(".editResume").val('');
	            return false
	        }
	        $(".image_validation").html('');
	        $("#resume_file").val(exte);
	        return true;
        }
	});

	/* form handling */
        $("#editPost-form").on('submit', function(e){
        	e.preventDefault();

        	$.ajax({
        		type: 'post',
        		url: '../../controller/saveEditPostController.php',
        		data: new FormData(this),
	            dataType: 'json',
	            contentType: false,
	            cache: false,
	            processData:false,
	            beforeSend: function(){
	                $('#post-btn').attr("disabled","disabled");
	                $("#post-btn").prop("value", "Updated...");
	            },
	            success: function(response){
					if(response.status == 1){
	                    //$('#fupForm')[0].reset();
						$("#editPost").modal('hide');
						$(".postSuccess").modal('show');
	                }else{
	                	console.log(+response.message);
	                }
					$('#post-btn').removeAttr("disabled");
				},
				error: function(){
					console.log('error');
				}
        	});
        });
</script>