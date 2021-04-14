<?php 
	$userId = 	$_SESSION['data']['register_id'];

	$userIds = encrypt_decrypt($userId);
	$userId = $userIds['encrypted'];
?>

<style>
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

<!-- Modal -->
<div id="postModal" class="modal fade bd-example-modal-xl" role="dialog">
  <div class="modal-dialog modal-xl">

  	<form id="post-form" enctype="multipart/form-data">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><span class="post_now">Post Now</span></h4>
      </div>
      <div class="modal-body">
		<input type="hidden" name="user_id" value="<?php echo $userId; ?>">
		<label>Please enter the details about your experience with a candidate</label><br><br>
			<div class="row form-group">
				<div class="col-md-4">
					<label>Candidate First Name</label> <span id="mandatory">*</span>
				</div>
				<div class="col-md-6">
					<input type="text" name="post_first_name" id="post_first_name" class="form-control txtPost" required autocomplete="off">
				</div>
			</div>
			<div class="row form-group">
				<div class="col-md-4">
					<label>Candidate Last Name</label> <span id="mandatory">*</span>
				</div>
				<div class="col-md-6">
					<input type="text" name="post_last_name" id="post_last_name" class="form-control txtPost" required autocomplete="off">
				</div>
			</div>
			<div class="row form-group">
				<div class="col-md-4">
					<label>Job Location</label> <span id="mandatory">*</span>
				</div>
				<div class="col-md-6 job_location_country">
					<div class="col-md-4">
						<input type="hidden" name="job_location" id="job_location" class="form-control" value="US" placeholder="US" readonly>
						<select class="form-control job_state" id="job_state" name="job_state" required>
							<option value="">Select State</option>
							<?php $state = execute_query($conn, "SELECT state_id, state_name, state_code FROM `company_states_tbl` WHERE status = '1'");
								while($getState = mysqli_fetch_assoc($state)){ ?>
							<option value="<?php echo $getState['state_code'];?>" ><?php echo $getState['state_name'] ?> (<?php echo $getState['state_code'] ?>)</option>
							<?php } ?>
						</select>
					</div>
					<div class="col-md-6 post_city">
						<select class="form-control post-city-txt" id="post_city" name="post_city" required>
						<option value="">Select City</option>
					</select>
					</div>
				</div>
			</div>

			<!-- <div class="row form-group job_city">
				<div class="col-md-6"></div>
				<div class="col-md-6">
					<select class="form-control post_city" id="post_city" name="post_city">
						<option value="">Select City</option>
					</select>
				</div>
			</div> -->

			<div class="row form-group">
				<div class="col-md-4">
					<label>Job Role</label> <span id="mandatory">*</span>
				</div>
				<div class="col-md-6">
					<input type="text" name="job_role" id="job_role" class="form-control txtPost" required autocomplete="off">
				</div>
			</div>

			<div class="row form-group">
				<div class="col-md-4">
					<label>Vendor / Supplier Name</label>
				</div>
				<div class="col-md-6">
					<input type="text" name="vendor_name" id="vendor_name" class="form-control txtPost" autocomplete="off">
				</div>
			</div>

			<div class="row form-group">
				<div class="col-md-4">
					<label>Candidate LinkedIn Url <span id="mandatory">*</span></label> 
				</div>
				<div class="col-md-6">
					<input type="text" name="linked_url" id="linked_url" class="form-control txtPost" required autocomplete="off">
					<span class="linkedin_url"></span>
				</div>
			</div>

			<!-- <div class="row form-group">
				<div class="col-md-4">
					<label>Date of Discussion <span id="mandatory">*</span></label>
				</div>
				<div class="col-md-6">
			        <input type="date" name="date_back_out" class="form-control txtPost" required autocomplete="off">
				</div>
			</div> -->

			<div class="row form-group" style="margin-top: -15px;">
				<div class="col-md-4">
					<label>Rating <span id="mandatory">*</span></label>
				</div>
				<!-- <div class="col-md-6 postNow-radio">
					<input type="radio" name="backout" value="positive" checked> <span> Positive</span>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<input type="radio" name="backout" value="negative"> <span> Negative</span>
				</div> -->
				<div class="col-md-6">
					<input type="hidden" name="rating_val" id="rating_val">
					<div class="rate">
					    <input type="radio" id="star5" name="rate" value="5" />
					    <label class="star" for="star5" title="5 stars">5 stars</label>
					    <input type="radio" id="star4" name="rate" value="4" />
					    <label class="star" for="star4" title="4 stars">4 stars</label>
					    <input type="radio" id="star3" name="rate" value="3" />
					    <label class="star" for="star3" title="3 stars">3 stars</label>
					    <input type="radio" id="star2" name="rate" value="2" />
					    <label class="star" for="star2" title="2 stars">2 stars</label>
					    <input type="radio" id="star1" name="rate" value="1" required />
					    <label class="star" for="star1" title="1 stars" required>1 star</label>
					</div>
				</div>
			</div>

			<div class="row form-group">
				<div class="col-md-4">
					<label>Resume </label>
				</div>
				<div class="col-md-6">
					<input type="file" name="resume" id="resume" class="form-control txtPost" accept=".pdf" autocomplete="off">
					<span class="image_validation" style="margin: 0px 70px; font-size: 11px;"></span>
				</div>
			</div>
			<div class="row form-group positive-story">
				<div class="col-md-4">
					<label>Story Title</label> <span id="mandatory">*</span>
				</div>
				<div class="col-md-6">
					<select class="form-control txtPost positive_category pc1" name="post_category[]">
						<option value="">Select Story Title</option>
						<?php 
							$showCategory = execute_query($conn, "SELECT * FROM `story_category_master_tbl` WHERE status = '1' LIMIT 18, 6");
							while($negative = mysqli_fetch_assoc($showCategory)){
						?>
						<option value="<?php echo $negative['story_category_id']; ?>"><?php echo $negative['story_name']; ?></option>
						<?php } ?>
						<option value="18">Others</option>
					</select>
				</div>
			</div>

			<div class="row form-group negative-story">
				<div class="col-md-4">
					<label>Story Title</label> <span id="mandatory">*</span>
				</div>
				<div class="col-md-6">
					<select class="form-control txtPost post_category_sel pc1" name="post_category[]">
						<option value="">Select Story Title</option>
						<?php 
							$showStory = execute_query($conn, "SELECT * FROM `story_category_master_tbl` WHERE status = '1' LIMIT 0, 17");
							while($story = mysqli_fetch_assoc($showStory)){
						?>
						<option value="<?php echo $story['story_category_id']; ?>"><?php echo $story['story_name']; ?></option>
						<?php } ?>
						<option value="18">Others</option>
					</select>
				</div>
			</div>
			<div class="row form-group other_category" style="display: none;">
				<div class="col-md-4">
					<label>Sub Category Name</label> <span id="mandatory">*</span>
				</div>
				<div class="col-md-6">
					<input type="text" name="sub_category" id="sub_category" class="form-control txtPost sub_category">
				</div>
			</div>
			<div class="row form-group">
				<div class="col-md-4">
					<label>Story</label> <span id="mandatory">*</span>
				</div>
				<div class="col-md-6">
					<textarea class="details_area txtPost" name="details" id="details" rows="6" cols="6" required autocomplete="off"></textarea>
				</div>
			</div>
			<span id="mandatory">* Fields are mandatory</span>
      </div>
      <div class="modal-footer">
      	<input type="submit" name="post_now" id="post-btn" value="Submit" class="btn btn-primary submit-btn">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
      </div>
  	</div>
      </form>
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
      		<span class="content-msg">Your post have been posted successfully!</span>
      	</div>
      </div>
      	<div class="modal-footer">
	        <button type="button" class="btn btn-info post-success" data-dismiss="modal">Close</button>
	    </div>
    </div>
  </div>
</div>
<script> 
    $(document).ready(function(e) { 
    	$(".positive-story").hide();
    	$(".negative-story").hide();
    	
    	$(".image_validation").css('color', 'red').html('Please attach a pdf file only');
        $(".btn-danger").on('click', function(){
        	$("#post-form").trigger("reset");
        });

        /* form handling */
        $("#post-form").on('submit', function(e){
        	e.preventDefault();

        	$.ajax({
        		type: 'post',
        		url: '../../controller/postController.php',
        		data: new FormData(this),
	            dataType: 'json',
	            contentType: false,
	            cache: false,
	            processData:false,
	            beforeSend: function(){
	                $('#post-btn').attr("disabled","disabled");
	                $("#post-btn").prop("value", "Submitting...");
	            },
	            success: function(response){
					if(response.status == 1){
	                    //$('#fupForm')[0].reset();
						$("#postModal").modal('hide');
						$("#post-form").trigger("reset");
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
        	/*setInterval(function(){
				$(".tab-content").load('../../controller/fetchPost.php');
			}, 1000);*/
        });

        $("#linked_url").on('blur change', function(){
        	url = $("#linked_url").val();
			var pattern = /^(?:(?:http|https):\/\/)?(?:www.)?linkedin.com\/in\/\w+()+/;
			if(pattern.test(url)) {
			    $("#linked_url").css('border','1px solid green');
			    $(".linkedin_url").html("");
			    return true;
			}
			else {
			    $("#linked_url").css('border','1px solid red').focus();
			    $(".linkedin_url").css('color','red').html("Enter valid Linkedin url");
			    return false;
			}
			return pattern.test(url);
        });
    });


    $(function(){
		$(".rate > label").on("click", function(event)
		{
		    radio_value = $(this).prev("input[type='radio']").val();
		    //alert(radio_value);
		    $("#rating_val").val(radio_value);

		    if((radio_value >= 1) && (radio_value <= 2)){
		    	$(".negative-story").show();
		    	$(".positive-story").hide();
		    }

		    if((radio_value >= 3) && (radio_value <= 5)){
		    	$(".negative-story").hide();
		    	$(".positive-story").show();
		    }
		});
	});

	$("#job_state").change(function(){
		var stateCode = $("#job_state").val();
		var city = '<option value="">Select City</option>';
		
		if(stateCode != ''){
			$.ajax({
	        	url: '../../controller/getCityName.php',
	        	type: 'post',
	        	data: { 'state_id' : stateCode },
	        	dataType: 'json',
	        	success:function(data){
	        		$.each( data, function( key, value ) {
	        			city += '<option value="'+value.city_id+'">'+value.city_name+'</option>';
	        		});
	        		$("#post_city").html(city);
	        	}
	        });
		}
		else {
          $('#post_city').html(city);
        }
	});

	$(".post_category_sel").change(function(){
		var postCategory = $(".post_category_sel").val();
        
		if(postCategory == '18'){
			$(".other_category").show();
			$(".sub_category").focus();
		}else{
			$(".other_category").hide();
		}
	});

	$(".positive_category").change(function(){
		var positiveCat = $(".positive_category").val();

		if(positiveCat == '18'){
			$(".other_category").show();
			$(".sub_category").focus();
		}else{
			$(".other_category").hide();
		}
	});

	$(".post-success").on('click', function(){
		window.location.href = '';
	});

	$("#resume").bind('change', function(){
		var size=(this.files[0].size);
        var exte=(this.files[0].name);
        fextension = exte.substring(exte.lastIndexOf('.')+1);
        validExtensions = ["pdf","PDF"];

        if ($.inArray(fextension, validExtensions) == -1){
            $(".image_validation").css('color', 'red').html('Please upload pdf file only');
            this.value = "";
            return false;
        }else{
        	if(size > 20971520) {
	            $(".image_validation").css('color', 'red').html('Please upload a file size less than 20 MB');
	            $("#resume").val('');
	            return false
	        }
	        $(".image_validation").html('');
	        return true;
        }
	});

	$(".submit-btn").on('click', function(){
	   var categoryVal = $(".pc1").val();
	   
	   if(categoryVal == ''){
	       $(".pc1").css('border','solid red 1px').focus();
	   }
	});
</script> 