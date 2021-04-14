<?php session_start(); header("X-Frame-Options: SAMEORIGIN");?>
<!DOCTYPE html>
<html>
<head>
	<title>Trust People Home Page</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- Favicons -->
  	<link href="assets/images/trust-people-fav-icon.jpg" rel="icon" size="16x16">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
	<!-- css -->
	<link rel="stylesheet" type="text/css" href="assets/css/style.css">

	<!-- Google Tag Manager -->

	<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
	new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
	j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
	'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
	})(window,document,'script','dataLayer','GTM-W2TTP85');</script>

	<!-- End Google Tag Manager -->
</head>
<body>

	<style>
		.modal{
			margin: 70px auto;
		}
		.modal-header{
			display: block;
			font-weight: bold;
		}
	</style>
<!-- Google Tag Manager (noscript) -->

<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-W2TTP85"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>

<!-- End Google Tag Manager (noscript) -->

<!-- Common popup -->
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
	        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
	    </div>
    </div>
  </div>
</div>
<!-- Common popup ends -->
<!-- header nav bar start -->
<nav class="navbar navbar-light bg-light">
  <a href="index.php" class="navbar-brand">
  	<img src="assets/images/trust-people-logo-png.png" class="logo_div">
  </a>
  <div class="form-inline">
    <a href="sign_in.php" class="sign_in">Sign In</a>
    <a href="sign_up.php" class="btn btn-outline-primary my-2 my-sm-0 create_account">Create Account</a>
  </div>
</nav>
<!-- header nav bar end -->

<div class="row">
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
    ?>
</div>
<!-- home page start -->
<div class="row first_div first_signin_div">
	<img src="assets/images/signin.png" class="home_image_1">
	<div class="header_content">
		<h1 class="h1_header_content">Sign in.</h1>
		<br>
		<form method="POST" action="controller/authController.php">
			<div class="form-group">
				<input type="email" name="username" placeholder="Email" class="form-control" required="required">
			</div>
			<div class="form-group">
				<input type="password" name="password" placeholder="Password" class="form-control" required="required">
			</div>
			<div class="form-group">
				<button class="btn btn-outline-primary my-2 my-sm-0 sign_in_btn" type="submit" id="signin" name="signin">Sign in</button>
			</div>
		</form>
		<a href="#" data-toggle="modal" data-target="#forgotPassword" class="forgot-password-link" style="color: #fff; font-weight: normal; font-size: 12px;">Forgot password?</a>
	</div>
</div>
<!-- home page end -->

<!-- footer content start-->
<div class="row footer_div signin_footer">
	<div class="row" style="width: 100%;">
		<div class="col-sm-8">
			<label>Copyright &copy; 2021 . Trustpeople . All Rights Reserved . support@trustpeople.io</label>
		</div>

		<div class="col-sm-4">
			<i class="fa fa-facebook"></i>
			<i class="fa fa-twitter"></i>
			<i class="fa fa-linkedin"></i>
		</div>
	</div>
</div>
<!-- footer content end-->

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
      		<span style="color: #0045ab;font-size: 16px;" class="forgot-span">Enter business email address to reset your password.</span>
      		<br><br>
      		<input type="email" class="form-control fadeIn" name="forgot_email" id="forgot_email" placeholder="Your Registered Email" required autocomplete="off" />
      		<span id="check_forgot_mail"></span>
      	</div>
      </div>
        <div class="modal-footer">
	      	<input type="submit" id="forgot-password" value="Send password reset" name="forgot-password" class="btn btn-primary">
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
      		<span style="color: #0045ab;font-size: 16px;">If there is an account associated with <span id="showEmail" style="font-weight: bold; "></span>, you will receive an email with a 6-digit temporary code. <!-- <br><br> This code will expire in 30 minutes --></span>
      		<br><br>
      		<input type="hidden" name="otp_email" id="otpEmail" value="">
      		<input type="text" class="form-control fadeIn" name="forgot_otp" id="forgot_otp" placeholder="OTP" required autocomplete="off" />
      		<span id="check_otp"></span>
      	</div>
      	<a href="#" class="resent_otp" onClick="resendOtp()" style="float: right; text-decoration: none;">Resend code</a>
      	<br>
      </div>
      <!--<span style="color: #0045ab;font-size: 16px;">Didn't receive the email? <br> Check your spam folder.</span>-->
      	<div class="modal-footer">
	      	<input type="submit" id="update_otp" value="Continue" name="update_otp" class="btn btn-info">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	    </div>
    </div>
  </div>
</div>

<!-- Resend code alert popup -->
<div class="modal fade" id="resendAlert" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <span class="forgot-header">Resend code</span>
      </div>
      <div class="modal-body">
      	<div class="form-group">
      		<span style="color: #0045ab;font-size: 16px;">Hi please check email  we have sent temporary code.</span>
      	</div>
      </div>
      <!--<span style="color: #0045ab;font-size: 16px;">Didn't receive the email? <br> Check your spam folder.</span>-->
      	<div class="modal-footer">
	        <button type="button" onClick="openResetPassword()" class="btn btn-default" data-dismiss="modal">Close</button>
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
      		<br><br>
      		<span id="mandatory-field"></span>
      		<input type="password" class="form-control fadeIn" autocomplete="off" placeholder="New Password" id="new_password" name="new_password" required/><br>
            <span id="password-strength-status1"></span>
            <input type="password" class="form-control fadeIn" autocomplete="off" placeholder="Confirm Password" id="forgot_confirm_password" required/>
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

<script>
	$("#forgot-password").on('click', function(){
		var registerEmail 	=	$("#forgot_email").val();

		if(registerEmail == ''){
			$("#forgot_email").css('border','1px solid red').focus();
		  	$("#check_forgot_mail").css('color','red').html("Enter registered email address!");
		}else{
			$.post('controller/checkForgotEmail.php', {'registerEmail' : registerEmail}, function(data){
		  	if(data.message === 'fail'){
		  		$("#forgot_email").css('border','1px solid red').focus();
		  		$("#check_forgot_mail").css('color','red').html("This is not a valid email address. Please try again!");
					event.preventDefault();
				} 
				else{
					$("#forgot_email").css('border','1px solid green');
					$("#check_forgot_mail").remove();
					$.post('controller/passwordController.php', {'registerEmail' : registerEmail}, function(data){
						if(data.message === 'success'){
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
			if(data.message === 'otp available'){
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
        //alert(registerEmail);
        
		if(registerEmail != ''){
			$.post('controller/passwordController.php', {'registerEmail' : registerEmail}, function(data){
					if(data.message === 'success'){
						$("#resetPassword").modal('hide');
						$("#resendAlert").modal('show');
						//$("#otpEmail").val(registerEmail);
						//$("#showEmail").css('color','#084177').html(registerEmail);
						return true;
					}else{
						alert('mail not send');
					}
			});
		}
	}
	
	function openResetPassword(){
	    var registerEmail 	=	$("#otpEmail").val();
	    $("#resetPassword").modal('show');
	    $("#otpEmail").val(registerEmail);
        $("#showEmail").css('color','#084177').html(registerEmail);
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
</script>

</body>
</html>