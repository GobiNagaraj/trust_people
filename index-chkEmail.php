<?php 
  	session_destroy();

  	include_once 'model/db.php';
	$conn = db_connect();

	/*code for update Activation link for Enterprise Account*/
	if(isset($_GET['id1']))
	{
		$username 			=		sanitize($conn, $_GET['id1']);
		$status 			=		'1';
		
		$sql = "UPDATE `register_tbl` SET status = '".$status."' WHERE email_address = '".$username."'";
		$result=execute_query($conn, $sql);

		if($result){
			$_SESSION['activate'] = 'Your account is successfully activated';
			header('Location: ');	
		}
		else{
			$_SESSION['error'] = 'Your Acount link not yet activated!';
			header('Location: ');
		}
	}

	if(isset($_GET['to'])){
		$url = $_GET['to'];
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Trust People</title>
<link rel="shortcut icon" type="image/x-icon" href="assets/images/trust_people_fav.png"/>
<link rel="stylesheet" href="assets/css/bootstrap.min.css">
<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,300italic,regular,italic,600,700,700italic" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="assets/css/landing-page2.css">
<script src="assets/js/jquery.min.js"></script>

<script src="assets/js/jquery-1.11.1.min.js"></script>
 
<script src="assets/js/jquery-ui-1.11.1.min.js"></script>

<script src="assets/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.11.1/themes/smoothness/jquery-ui.css" />

<script type="text/javascript">
	// Prevent dropdown menu from closing when click inside the form
	$(document).on("click", ".navbar-right .dropdown-menu", function(e){
		e.stopPropagation();
	});
</script>
<style>
	.trust-left-box{
		width: 100%; 
		height: 535px;
		background: rgb(153, 222, 251);
		color:#fff;
		padding: 5%;	
		box-shadow:1px 2px 3px #f5f5f5;		
	}

	.trust-left-box p{
		transform: translate(0px,200px);
	 	text-align: center;	
	 	font-size: 30px;
	 	font-weight: bold;
	}
</style>
</head> 
<body>

<div class="modal fade authentication" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
    <div class="modal-content">
    	<div class="modal-header">
	        <span class="header-msg"></span>	
	    </div>
      <div class="modal-body">
      	<div class="form-group">
      		<span class="content-msg"></span>
      	</div>
      </div>
      	<div class="modal-footer">
	        <button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
	    </div>
    </div>
  </div>
</div>

<nav class="navbar navbar-default navbar-expand-lg navbar-light">
	<div class="navbar-header d-flex col">
		<a class="navbar-brand" href="#" style="color: #fff;"><b>Trust People</b></a>  
		<button type="button" data-target="#navbarCollapse" data-toggle="collapse" class="navbar-toggle navbar-toggler ml-auto">
			<span class="navbar-toggler-icon"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		</button>
	</div>
	<div id="navbarCollapse" class="collapse navbar-collapse justify-content-start">
		<form class="navbar-form form-inline pull-right" method="POST" action="controller/authController.php">
			<input type="text" class="form-control form-group login-input" name="username" placeholder="Business email address" required="required" autofocus>
			<input type="password" class="form-control form-group login-input" name="password" placeholder="Password" required="required">
			<input type="submit" class="btn btn-sm btn-primary form-group" name="signin" id="signin" value="Login">
		</form>
		<a href="#" data-toggle="modal" data-target="#forgotPassword" class="forgot-password-link">Forgot password?</a>
	</div>
</nav>
<div class="container col-md-12">
	<center>
	<?php 
        if (isset($_SESSION['error'])) 
          {
            switch ($_SESSION['error']) 
            {
                case $_SESSION['error']:
                echo "<script type='text/javascript'>
						$(document).ready(function(){
							$('.authentication').modal('show');
							$('.header-msg').html('Authentication Problem');
							$('.content-msg').html('".$_SESSION['error']."');
						});
					  </script>"; 
					  unset($_SESSION['error']);
                break;
            }
    	  }

    	  if (isset($_SESSION['success'])) 
          {
            switch ($_SESSION['success']) 
            {
                case $_SESSION['success']: 
                echo "<script type='text/javascript'>
						$(document).ready(function(){
							$('.authentication').modal('show');
							$('.content-msg').html('".$_SESSION['success']."');
						});
					  </script>"; 
				unset($_SESSION['success']);
                break;
            }
    	  }

    	  if (isset($_SESSION['activate'])) 
          {
            switch ($_SESSION['activate']) 
            {
                case $_SESSION['activate']: 
                echo "<script type='text/javascript'>
						$(document).ready(function(){
							$('.authentication').modal('show');
							$('.header-msg').html('Activation Details');
							$('.content-msg').html('".$_SESSION['activate']."');
						});
					  </script>"; 
				unset($_SESSION['activate']);
                break;
            }
    	  }
    ?>
    </center>
    <div class="col-md-6">
    	<img src="assets/images/bg4.png" class="bg-img" style="width: 95% !important;">
    </div>

    <div class="col-md-6 right-div">
    	<form method="POST" id="validated-form" action="controller/authController.php">
			<p class="hint-text">Create an account</p>
			<hr>
			<span class="mandatory_fields"></span>
			<div class="signup-form">
				<div class="row col-md-12 form-group">
					<div class="col-md-6">
						<label>First name</label> <span class="mandatory">*</span>
						<input type="text" name="firstname" id="firstname" autocomplete="off" class="form-control" placeholder="First name" minlength="3">
					</div>
					<div class="col-md-6">
						<label>Last name</label> <span class="mandatory">*</span>
						<input type="text" name="lastname" id="lastname" autocomplete="off" class="form-control" placeholder="Last name" minlength="1">
					</div>
				</div>
				<div class="row col-md-12 form-group">
					<div class="col-md-6">
						<label>Business email</label> <span class="mandatory">*</span>
						<input type="email" name="email" id="reg_email" autocomplete="off" class="form-control" placeholder="Business email" minlength="3">
					</div>
					<div class="col-md-6">
						<label>Designation / Title</label> <span class="mandatory">*</span>
						<?php 
	            	    	$selTitle = execute_query($conn, "SELECT title_id, title_name FROM `title_tbl` WHERE status = '1'");
	            	    ?>
	            	    <select name="title" id="title" class="form-control title" style="color: #999999;" >
	            	    	<option value=""> Select Designation / Title</option>
	            	    	<?php while($tit = mysqli_fetch_assoc($selTitle)){ ?>
	            	    	<option value="<?php echo $tit['title_id']; ?>"><?php echo $tit['title_name']; ?></option>
	            	    	<?php } ?>
	            	    </select>
					</div>
				</div>
				<div class="col-md-12 form-group title-div">
					<label>Enter Designation / Title</label> <span class="mandatory">*</span>
	                	<input type="text" name="title_name" id="title_name" placeholder="Enter Designation / Title" autocomplete="off" class="form-control" style="width: 94%;" minlength="3"/>
				</div>
				<div class="row col-md-12 form-group">
					<!-- <div class="col-md-6">
						<label>Mobile number</label>
						<input type="hidden" name="country_code" id="country_code">
	                	<input type="tel" name="mobilenumber" minlength="10" minlength="15" autocomplete="off" id="mobilenumber" class="form-control">
	                	<span id="check_mobile"></span>
					</div> -->
					<div class="col-md-6">
						<label>Company name</label> <span class="mandatory">*</span>
						<input type="text" name="companyname" autocomplete="off" class="form-control" placeholder="Company name" id="companyname" minlength="3">
					</div>
					<div class="col-md-6">
						<label>Password </label><span class="mandatory">*</span>
						<input type="password" name="password" id="password" autocomplete="off" class="form-control" onblur="checkPasswordStatus()" placeholder="Password"  minlength="3">
						<span id="password-strength-status"></span>
					</div>
				</div>
				<div class="col-md-12 form-group">
						<label>Company website</label> <span class="mandatory">*</span>
						<input type="text" name="companywebsite" id="companywebsite" autocomplete="off" class="form-control companywebsite" onblur="checkWebsiteStatus()" placeholder="Company website" minlength="3">
						<span class="checkwebsite"></span>
				</div>
				<!-- <div class="row col-md-12 form-group">
					<div class="col-md-6">
						<label>Password </label><span class="mandatory">*</span>
						<input type="password" name="password" id="password" autocomplete="off" class="form-control" placeholder="Password" required>
						<span id="password-strength-status"></span>
					</div>
					<div class="col-md-6">
						<label>Confirm password </label><span class="mandatory">*</span>
						<input type="password" name="confirm_password" id="confirm_password" autocomplete="off" class="form-control" placeholder="Confirm password" required>
						<span class="password_check" style="color: red;"></span>
					</div>
				</div> -->
				<div class="form-group col-md-12">
	        		<span class="mailValid"></span>
	            	<br>
	            	<span style="color: red; float: right;">* Fields are mandatory</span>
	            </div>
	            <div class="form-group col-md-12">
					<input type="checkbox" name="terms_condition" required> <span class="mandatory">*</span> By clicking Sign up, you agree to our <!-- <a href="#" id="btnShow">Terms of Use</a> --><a href="Trustpeople-Terms of use.pdf" target="_blank">Terms of Use</a>.
				</div>
				<div id="dialog" style="display: none">
        	</div>
			<center><input type="submit" class="btn btn-primary btn-block" value="Sign up" name="register" id="enterprise-reg"></center>
		</form>
    </div>
</div>

<!-- Modal -->
<div id="forgotPassword" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <span class="forgot-header">Having trouble logging in?</span>	
      </div>
      <div class="modal-body">
      	<div class="form-group">
      		<span style="color: #0045ab;font-size: 16px;" class="forgot-span"><!-- Enter your email address below. We'll look for your account and send you a password reset OTP. -->Enter business email address to reset your password.</span>
      		<input type="email" class="form-control fadeIn" name="forgot_email" id="forgot_email" placeholder="Your Registered Email" required autocomplete="off" />
      		<br>
      		<span id="check_forgot_mail"></span>
      	</div>
      </div>
        <div class="modal-footer">
	      	<input type="submit" id="forgot-password" value="Send password reset" name="forgot-password" class="btn btn-info">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	    </div>
    </div>

  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="resetPassword" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <span class="forgot-header">Check your email</span>
      </div>
      <div class="modal-body">
      	<div class="form-group">
      		<span style="color: #0045ab;font-size: 16px;">If there is an account associated with <span id="showEmail" style="font-weight: bold; "></span>, you will receive an email with a 6-digit temporary code. <br><br> This OTP will expire in 30 minutes</span>
      		<input type="hidden" name="otp_email" id="otpEmail" value="">
      		<input type="text" class="form-control fadeIn" name="forgot_otp" id="forgot_otp" placeholder="OTP" required autocomplete="off" />
      		<br>
      		<span id="check_otp"></span>
      	</div>
      </div>
      <!--<span style="color: #0045ab;font-size: 16px;">Didn't receive the email? <br> Check your spam folder.</span>-->
      	<a href="#" onClick=""></a>
      	<div class="modal-footer">
	      	<input type="submit" id="update_otp" value="Continue" name="update_otp" class="btn btn-info">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	    </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="updatePassword" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
    	<div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal">&times;</button>
	        <span class="forgot-header">Update New Password</span>
	      </div>
      <div class="modal-body">
      	<div class="form-group">
      		<input type="hidden" name="new_password_email" id="new_password_email">
      		<span style="color: #0045ab;font-size: 16px;">Enter a New Password</span>
      		<span id="mandatory-field"></span>
      		<input type="password" class="form-control fadeIn" autocomplete="off" placeholder="New Password" id="new_password" name="new_password" required/><br>
            <span id="password-strength-status1"></span>
            <input type="password" class="form-control fadeIn" autocomplete="off" placeholder="Confirm Password" id="forgot_confirm_password" required/>
            <br>
            <span class="password_check" style="color: red;"></span>
      	</div>
      </div>
      	<div class="modal-footer">
	      	<input type="submit" id="update_password" value="Update Password" name="update_password" class="btn btn-info">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	    </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="finalPassword" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-body">
      	<div class="form-group">
      		<center><span style="color: #0045ab;font-size: 20px;">Password changed successfully! </span></center>
      	</div>
      </div>
      	<div class="modal-footer">
	        <button type="button" class="btn btn-info" id="password_updated" data-dismiss="modal">Done</button>
	    </div>
    </div>
  </div>
</div>

<script src="assets/js/comments-details.js"></script>

<script>
	$(document).ready(function(){
		$(".title-div").hide();
	    $("select").change(function(){
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
	});

</script>

<script>
	
	$("#validated-form").on('submit', function(){
		var fName 	=	$("#firstname").val();
		var lName 	=	$("#lastname").val();
		var email 	=	$("#reg_email").val();
		var title 	=	$("#title").val();
		var company =	$("#companyname").val();
		var password=	$("#password").val();
		var website	=	$("#companywebsite").val();

		if(fName == ''){
			$(".mandatory_fields").css('color', 'red').html("First name is mandatory");
			$("#firstname").focus();
			return false;
		}else if(lName == ''){
			$(".mandatory_fields").css('color', 'red').html("Last name is mandatory");
			$("#lastname").focus();
			return false;
		}else if(email == ''){
			$(".mandatory_fields").css('color', 'red').html("Business email is mandatory");
			$("#reg_email").focus();
			return false;
		}else if(title == ''){
			$(".mandatory_fields").css('color', 'red').html("Designation / Title is mandatory");
			$("#title").focus();
			return false;
		}else if(company == ''){
			$(".mandatory_fields").css('color', 'red').html("Company name is mandatory");
			$("#companyname").focus();
			return false;
		}else if(password == ''){
			$(".mandatory_fields").css('color', 'red').html("Password is mandatory");
			$("#password").focus();
			return false;
		}else if(website == ''){
			$(".mandatory_fields").css('color', 'red').html("Company website is mandatory");
			$("#companywebsite").focus();
			return false;
		}else{
			$(".mandatory_fields").html("");

			/* Business Email Validation */
			if(email != ''){
				var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
				var emailblockReg =/^([\w-\.]+@(?!gmail.com)(?!yahoo.com)(?!hotmail.com)(?!rediff.com)(?!outlook.com)(?!aol.com)(?!rediffmail.com)([\w-]+\.)+[\w-]{2,4})?$/;

				$.post('controller/checkRegEmail.php', {'registerEmail' : email}, function(data){
				  	if(data === 'success'){
				  		$("#reg_email").css('border','1px solid red').focus();
				  		$(".mailValid").css('color','red').html("Your Email ID is already registered. Please try to Sign-In!");
	  					return false;
	  				} 
	  				else{
	  					$("#reg_email").css('border','1px solid green');
	  					$(".mailValid").html("");
	  					if(!emailblockReg.test(email)) 
						{
				    		$('#reg_email').css('border','1px solid red').focus();
							$(".mailValid").css('color','red').html('Please register with your Business email address!!');
							return false;
						}
	  					return true;
	  				} 
				});
			}

			/* Password field validation */
			if(password != '')
			{
				var number = /([0-9])/;
			    var alphabets = /([a-zA-Z])/;
			    var special_characters = /([~,!,@,#,$,%,^,&,*,-,_,+,=,?,>,<])/;
			    if($('#password').val().length<7) 
		       	{
		     	    $('#password-strength-status').removeClass();
		        	$('#password-strength-status').addClass('weak-password');
		        	$('#password-strength-status').html("Weak (should be atleast 7 characters. Include alphabets, numbers and special characters.)");
		        	$('#password').focus();
		        	return false;
		      	}else 
		      	{    
		        	if($('#password').val().match(number) && $('#password').val().match(alphabets) && $('#password').val().match(special_characters)) 
		        	{            
		          		$('#password-strength-status').removeClass();
		          		$('#password-strength-status').addClass('strong-password');
		          		$('#password-strength-status').html("");
		          		return true;
		        	}else 
		        	{
		          		$('#password-strength-status').removeClass();
		          		$('#password-strength-status').addClass('medium-password');
		          		$('#password-strength-status').html("Medium (should include alphabets, numbers and special characters.)");
		          		$('#password').focus();
		          		return false;
		        	}
		      	}
	      	}
	      	$('input[type="checkbox"]').click(function(){
	            if($(this).prop("checked") == false){
	                $(".mandatory_fields").css('color', 'red').html("Check Terms of Use");
	            	return false;
	            }
	            else {
	            	$(".mandatory_fields").html("");
					return true;
	            }
	        });
			return true;
		}
	});

	/*function checkEmailAvailability(){
		var email 	=	$("#reg_email").val();

		var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
		var emailblockReg =/^([\w-\.]+@(?!gmail.com)(?!yahoo.com)(?!hotmail.com)(?!rediff.com)(?!outlook.com)(?!aol.com)(?!rediffmail.com)([\w-]+\.)+[\w-]{2,4})?$/;
		if(!emailblockReg.test(email)) 
		{
    		$('#reg_email').css('border','1px solid red').focus();
			$(".mailValid").css('color','red').html('Please register with your Business Email address!!');
			return false;
		}else{
			$.post('controller/checkRegEmail.php', {'registerEmail' : email}, function(data){
			  	if(data === 'success'){
			  		$("#reg_email").css('border','1px solid red').focus();
			  		$(".mailValid").css('color','red').html("Your Email ID is already registered. Please try to Sign-In!");
  					return false;
  				} 
  				else{
  					$("#reg_email").css('border','1px solid green');
  					$(".mailValid").remove();
  					return true;
  				} 
			});
			return true;
		}
	} */

	function checkPasswordStatus(){
		var number = /([0-9])/;
	    var alphabets = /([a-zA-Z])/;
	    var special_characters = /([~,!,@,#,$,%,^,&,*,-,_,+,=,?,>,<])/;
	    if($('#password').val().length<7) 
       	{
     	    $('#password-strength-status').removeClass();
        	$('#password-strength-status').addClass('weak-password');
        	$('#password-strength-status').html("Weak (should be atleast 7 characters.)");
        	$('#password').focus();
        	return false;
      	}else 
      	{    
        	if($('#password').val().match(number) && $('#password').val().match(alphabets) && $('#password').val().match(special_characters)) 
        	{            
          		$('#password-strength-status').removeClass();
          		$('#password-strength-status').addClass('strong-password');
          		$('#password-strength-status').html("");
          		return true;
        	}else 
        	{
          		$('#password-strength-status').removeClass();
          		$('#password-strength-status').addClass('medium-password');
          		$('#password-strength-status').html("Medium (should include alphabets, numbers and special characters.)");
          		$('#password').focus();
          		return false;
        	}
      	}
	}

	function checkWebsiteStatus(){
		var txt = $('#companywebsite').val();
		var re = /(http(s)?:\\)?([\w-]+\.)+[\w-]+[.com|.edu|.gov|.int|.mil|.net|.org|.biz|.arpa|.info|.name|.pro|.aero|.coop|.museum]+(\[\?%&=]*)?/
		if (re.test(txt)) {
			$(".checkwebsite").html("");
	        $("#companywebsite").css('border','1px solid green');
			return true;
		}else{
			$("#companywebsite").css('border','1px solid red').focus();
	    	$(".checkwebsite").css('color','red').html("Error! Enter a valid website name.");
	        return false;
		}
		/*if(ValidateURL($("#companywebsite").val())) 
	    { 
	        $(".checkwebsite").remove();
	        $("#companywebsite").css('border','1px solid green');
			return true;
	    } 
	    else 
	    {  
	    	$("#companywebsite").css('border','1px solid red').focus();
	    	$(".checkwebsite").css('color','red').html("Error! Enter a valid website name.");
	        return false;
	    }*/
	}

	/*function ValidateURL(urlToCheck) {
		// Below regular expression can validate input URL with or without http:// etc
		var pattern = new RegExp("^((http|https|ftp)\://)*([a-zA-Z0-9\.\-]+(\:[a-zA-Z0-9\.&%\$\-]+)*@)*((25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[1-9])\.(25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[1-9]|0)\.(25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[1-9]|0)\.(25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[0-9])|([a-zA-Z0-9\-]+\.)*[a-zA-Z0-9\-]+\.(com|edu|gov|int|mil|net|org|biz|arpa|info|name|pro|aero|coop|museum|[a-zA-Z]{2}))(\:[0-9]+)*(/($|[a-zA-Z0-9\.\,\?\'\\\+&%\$#\=~_\-]+))*$");
		return pattern.test(urlToCheck);
	}*/

</script>

<script>
	$("#forgot-password").on('click', function(){
		var registerEmail 	=	$("#forgot_email").val();

		if(registerEmail == ''){
			$("#forgot_email").css('border','1px solid red').focus();
		  	$("#check_forgot_mail").css('color','red').html("Enter registered email address!");
		}else{
			$.post('controller/checkForgotEmail.php', {'registerEmail' : registerEmail}, function(data){
		  	if(data === 'fail'){
		  		$("#forgot_email").css('border','1px solid red').focus();
		  		$("#check_forgot_mail").css('color','red').html("This is not a valid email address. Please try again!");
					event.preventDefault();
				} 
				else{
					$("#forgot_email").css('border','1px solid green');
					$("#check_forgot_mail").remove();
					$.post('controller/passwordController.php', {'registerEmail' : registerEmail}, function(data){
						if(data === 'success'){
						    $("#forgotPassword").modal('hide');
							$("#resetPassword").modal('show');
							$("#otpEmail").val(registerEmail);
							$("#showEmail").css('color','#084177').html(registerEmail);
							return true;
						}else{
							alert('mail not send');
						}
					});
					
					// $("#forgot_email").css('border','1px solid green');
					// $("#check_forgot_mail").remove();
					// return true;
				} 
			});
		}
	});

	$("#update_otp").on('click', function(){
		var otpEmail = $("#otpEmail").val();
		var otp 	=	$("#forgot_otp").val();
		$.post('controller/checkForgotEmail.php', {'registerOTP' : otp, 'otpEmail' : otpEmail}, function(data){
			if(data === 'otp available'){
		  		$("#new_password_email").val(otpEmail);
		  		$("#forgotPassword").modal('hide');
		  		$("#resetPassword").modal('hide');
		  		$("#updatePassword").modal('show');
					return true;						
			}else{
				$("#forgot_otp").css('border','1px solid red').focus();
		  		$("#check_otp").css('color','red').html("Invalid OTP. Please, enter valid OTP!");
					return false;
			}
		});
	});

	function resendOtp(){
		var registerEmail 	=	$("#otpEmail").val();

		if(registerEmail == ''){
			$.post('controller/checkForgotEmail.php', {'registerEmail' : registerEmail}, function(data){
					if(data === 'success'){
						$("#resetPassword").modal('show');
						$("#otpEmail").val(registerEmail);
						$("#showEmail").css('color','#084177').html(registerEmail);
						return true;
					}else{
						alert('mail not send');
					}
			});
		}
	}

	/* script for checking the Forgot Password */
	$(document).on('change blur','#new_password', function(){
		var number = /([0-9])/;
	    var alphabets = /([a-zA-Z])/;
	    var special_characters = /([~,!,@,#,$,%,^,&,*,-,_,+,=,?,>,<])/;
	    if($('#new_password').val().length<7) 
	       {
	     	    $('#password-strength-status1').removeClass();
	        	$('#password-strength-status1').addClass('weak-password');
	        	$('#password-strength-status1').html("Weak (should be atleast 7 characters.)");
	        	$('#new_password').focus();
	        	return false;
	      	}else 
	      	{    
	        	if($('#new_password').val().match(number) && $('#new_password').val().match(alphabets) && $('#new_password').val().match(special_characters)) 
	        	{            
	          		$('#password-strength-status1').removeClass();
	          		$('#password-strength-status1').addClass('strong-password');
	          		$('#password-strength-status1').html("");
	          		return true;
	        	}else 
	        	{
	          		$('#password-strength-status1').removeClass();
	          		$('#password-strength-status1').addClass('medium-password');
	          		$('#password-strength-status1').html("Medium (should include alphabets, numbers and special characters.)");
	          		$('#new_password').focus();
	          		return false;
	        	}
	      	}
	});

    $(document).on('change blur click','#update_password', function(){
    	if($("#new_password").val() === "")
    	{
    		$("#new_password").css('border','1px solid red').focus();
    		$("#mandatory-field").css('color','red').html("Please, enter new password!");
    		return false;
    	}else if($("#forgot_confirm_password").val() === ""){
    		$("#forgot_confirm_password").css('border','1px solid red').focus();
    		$("#mandatory-field").css('color','red').html("Please, enter confirm password!");
    		return false;
    	}else
    	{
    		$("#mandatory-field").html("");
    		if($("#new_password").val() !== $("#forgot_confirm_password").val()) 
			{
				$(".password_check").html("Password doesn't match!");
	            $("#forgot_confirm_password").css("border", "1px solid red").focus();
	            return false;
			}else
			{
				$(".password_check").html("");
	            $("#forgot_confirm_password").css("border", "1px solid green");

	            var updateEmail		=	$("#new_password_email").val();
				var updatePassword 	=	$("#new_password").val();

				$.post('controller/passwordController.php', {'updateEmail' : updateEmail, 'updatePassword' : updatePassword}, function(data){
					if(data === 'fail'){
						alert('Something went to wrong!');
						return false;
					}else{
						$("#finalPassword").modal('show');
						$("#forgotPassword").modal('hide');
						$("#resetPassword").modal('hide');
				  		$("#updatePassword").modal('hide');
	  					return true;
					}
				});
			}
    		return true;
    	}
	});
	
	$("#password_updated").on('click', function(){
	   window.location.href = ""; 
	});

	$(function () {
		var headingName = "Trust People - Terms of use";
    	var fileName = "Trustpeople-Terms of use.pdf";
        $("#btnShow").click(function () {
            $("#dialog").dialog({
                modal: true,
                title: headingName,
                width: 540,
                height: 450,
                buttons: {
                    Close: function () {
                        $(this).dialog('close');
                    }
                },
                open: function () {
                    var object = "<object data=\"{FileName}\" type=\"application/pdf\" width=\"500px\" height=\"300px\">";
                    object += "If you are unable to view file, you can download from <a href = \"{FileName}\">here</a>";
                    object += " or download <a target = \"_blank\" href = \"http://get.adobe.com/reader/\">Adobe PDF Reader</a> to view the file.";
                    object += "</object>";
                    object = object.replace(/{FileName}/g, fileName);
                    $("#dialog").html(object);
                }
            });
        });
    });
</script>
</body>
</html>