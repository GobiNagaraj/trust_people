<?php 
  	include_once 'model/db.php';
	$conn = db_connect();

	// unset cookies
	if (isset($_SERVER['HTTP_COOKIE'])) {
	    $cookies = explode(';', $_SERVER['HTTP_COOKIE']);
	    foreach($cookies as $cookie) {
	        $parts = explode('=', $cookie);
	        $name = trim($parts[0]);
	        setcookie($name, '', time()-1000);
	        setcookie($name, '', time()-1000, '/');
	    }
	}
	/*code for update Activation link for Enterprise Account*/
	if(isset($_GET['id1']))
	{
		$username 			=		remove_special_char(sanitize($conn, $_GET['id1']));
		$decryptedEmail     = 		encrypt_decrypt($username);
		$username			=		$decryptedEmail['decrypted'];

		$status 			=		'1';
		
		$sql = "UPDATE `register_tbl` SET status = '".$status."' WHERE email_address = '".$username."' AND status = '0'";
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
<!-- Google Tag Manager (noscript) -->

<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-W2TTP85"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>

<!-- End Google Tag Manager (noscript) -->

<style>
	.modal{
		margin: 70px auto;
	}
	.modal-header{
		display: block;
		font-weight: bold;
	}
</style>

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
	        <button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
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

<!-- home page start -->
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
<div class="row first_div first_signup_div">
	<img src="assets/images/signup.png" class="home_image_1">
	<div class="header_content">
		<h1 class="h1_header_content">Create account.</h1>
		<br>
		<span class="mandatory_fields"></span>
		<form method="POST" id="validated-form" action="controller/authController.php">
			<div class="form-group">
				<input type="text" name="firstname" placeholder="First name" class="form-control" id="firstname">
			</div>
			<div class="form-group">
				<input type="text" name="lastname" placeholder="Last name" class="form-control" id="lastname">
			</div>
			<div class="form-group">
				<input type="text" name="companyname" placeholder="Company name" class="form-control" id="companyname">
			</div>
			<div class="form-group">
				<input type="text" name="companywebsite" placeholder="Company website" class="form-control companywebsite" id="companywebsite" onblur="checkWebsiteStatus()">
				<span class="checkwebsite"></span>
			</div>
			<div class="form-group">
				<?php 
        	    	$selTitle = execute_query($conn, "SELECT title_id, title_name FROM `title_tbl` WHERE status = '1'");
        	    ?>
        	    <select name="title" id="title" class="form-control job_title">
        	    	<option value=""> Job title</option>
        	    	<?php while($tit = mysqli_fetch_assoc($selTitle)){ ?>
        	    	<option value="<?php echo $tit['title_id']; ?>"><?php echo $tit['title_name']; ?></option>
        	    	<?php } ?>
        	    </select>
			</div>
			<div class="form-group title-div">
                <input type="text" name="title_name" id="title_name" placeholder="Enter Designation / Title" autocomplete="off" class="form-control" minlength="3"/>
			</div>
			<div class="form-group">
				<input type="email" name="email" placeholder="Work email" class="form-control" id="reg_email" onblur="checkEmailAvailability()" minlength="3">
			</div>
			<div class="form-group">
				<input type="password" name="password" placeholder="Password" class="form-control" id="password" onblur="checkPasswordStatus()">
				<span id="password-strength-status"></span>
			</div>
			<div class="form-group">
				<input type="checkbox" name="terms_condition" required> <span style="color: #fff; font-size: 12px;">By clicking Sign up, you agree to our</span> <a href="Trust People TERMS OF USE.pdf" target="_blank" style="text-decoration: none; color: #fff;">Terms of Use</a>.
			</div>
			<div id="dialog" style="display: none"></div>
			<div class="form-group col-md-12">
	    		<span class="mailValid"></span>
	        	<span style="color: red;">* All fields are mandatory</span>
	        </div>
			<button class="btn btn-outline-primary my-2 my-sm-0 sign_in_btn" type="submit" name="register" id="enterprise-reg">Submit</button>
		</form>
	</div>
</div>
<!-- home page end -->

<!-- footer content start-->
<div class="row footer_div signup_footer">
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

<script>
	$(document).ready(function(){

		// Disable the submit button
		/*$(".sign_in_btn").attr("disabled", "disabled");*/

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
			$(".mandatory_fields").css('color', '#fff').html("First name is mandatory");
			$("#firstname").focus().css('border','1px solid red');
			return false;
		}else if(lName == ''){
			$(".mandatory_fields").css('color', '#fff').html("Last name is mandatory");
			$("#lastname").focus().css('border','1px solid red');
			return false;
		}else if(email == ''){
			$(".mandatory_fields").css('color', '#fff').html("Business email is mandatory");
			$("#reg_email").focus().css('border','1px solid red');
			return false;
		}else if(title == ''){
			$(".mandatory_fields").css('color', '#fff').html("Designation / Title is mandatory");
			$("#title").focus().css('border','1px solid red');
			return false;
		}else if(company == ''){
			$(".mandatory_fields").css('color', '#fff').html("Company name is mandatory");
			$("#companyname").focus().css('border','1px solid red');
			return false;
		}else if(password == ''){
			$(".mandatory_fields").css('color', '#fff').html("Password is mandatory");
			$("#password").focus().css('border','1px solid red');
			return false;
		}else if(website == ''){
			$(".mandatory_fields").css('color', '#fff').html("Company website is mandatory");
			$("#companywebsite").focus().css('border','1px solid red');
			return false;
		}else{
			$(".mandatory_fields").html("");
		}
	});

	function checkEmailAvailability(){
		var email 	=	$("#reg_email").val();

		var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
		var emailblockReg =/^([\w-\.]+@(?!gmail.com)(?!yahoo.com)(?!hotmail.com)(?!rediff.com)(?!outlook.com)(?!aol.com)(?!rediffmail.com)([\w-]+\.)+[\w-]{2,4})?$/;
		if(!emailblockReg.test(email)) 
		{
    		$('#reg_email').css('border','1px solid red').focus();
			$(".mailValid").css('color','#ffed0f').html('Please register with your Business Email address!!');
			return false;
		}else{
			$.post('controller/checkRegEmail.php', {'registerEmail' : email}, function(data){
			  	if(data === 'success'){
			  		$("#reg_email").css('border','1px solid red').focus();
			  		$(".mailValid").css('color','#ffed0f').html("Your Email ID is already registered. Please try to Sign-In!");
  					return false;
  				} 
  				else{
  					$("#reg_email").css('border','1px solid green');
  					$(".mailValid").remove();
  					/*$(".sign_in_btn").removeAttr("disabled");*/
  					return true;
  				} 
			});
			return true;
		}
	} 

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
	    	$(".checkwebsite").css('color','#ffed0f').html("Error! Enter a valid website name.");
	        return false;
		}
	}

</script>

<script>

	$(function () {
		var headingName = "Trust People - Terms of use";
    	var fileName = "Trust People TERMS OF USE.pdf";
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