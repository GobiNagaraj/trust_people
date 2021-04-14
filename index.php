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

<?php 
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

<!-- home page first div start -->
<div class="row first_div">
	<img src="assets/images/home_1.png" class="home_image_1">
	<div class="header_content_landing">
		<h1 class="h1_header_content">Read trusted reviews, Hire the right candidates, Save cost per hire.</h1>
		<p class="header_paragraph">This product provides in depth candidate reviews, and allows business as well as hiring mangers to make informed hiring decisions.</p>
		<button class="btn btn-outline-primary my-2 my-sm-0 explore_benefits">Explore benefits</button>
	</div>
</div>
<!-- home page first div end -->

<!-- home page second div start -->
<div class="row second_row">
	<div class="container">
		<br>
		<div class="row">
			<strong><h1 class="why_lbl">Why Trustpeople?</h1></strong>
		</div>

		<div class="row why_div">
			<div class="col-sm-4">
				<div class="asset1">
					<h2 class="why_h2_content">Find reviews on candidates</h2>
					<p>If you are interested to know about every product and service before buying. Would you not be interested to know reviews for candidate who you are going to hire.</p>
				</div>
			</div>
			<div class="col-sm-4">
				<div class="asset2">
					<h2 class="why_h2_content">Make informed hiring decisions</h2>
					<p>Would you invest an hour in interviewing a candidate who is not going to join a project? or would you spend few minutes reading and sharing reviews about a candidate.</p>
				</div>
			</div>
			<div class="col-sm-4">
				<div class="asset3">
					<h2 class="why_h2_content">Build a trusted talent pipeline</h2>
					<p>What if you knew ahead of time about candidate probability of joinning? Would you not like to be on a platform which helps you to save project cost and timelines?</p>
				</div>
			</div>
		</div>

		<div class="row why_div">
			<button class="btn btn-outline-primary my-2 my-sm-0 learn_more">Learn more</button>
		</div>
	</div>
</div>
<!-- home page second div end -->

<!-- home page third div start -->
<div class="row third_div">
	<img src="assets/images/home_2.png" class="home_image_2">
	<div class="header_content_landing">
		<h1 class="h1_header_content">For Recruiters, Hiring Managers, Staffing Firms.</h1>
		<p class="header_paragraph">Would you like to stop lossing business opportunities due to no show and attrition? Act now!</p>
		<button class="btn btn-outline-primary my-2 my-sm-0 get_started">Get started</button>
	</div>
</div>
<!-- home page third div end -->

<!-- home page forth div start -->
<div class="row second_row fourth_div">
	<div class="container">
		<br>
		<div class="row">
			<strong><h1 class="why_lbl">How to get started?</h1></strong>
		</div>

		<div class="row why_div">
			<div class="col-sm-4">
				<div class="get_asset1">
					<div class="circle">
				        <p>1</p>
				    </div>
					<h2 class="why_h2_content"><p>Create</p> <p>your account</p></h2>
				</div>
			</div>
			<div class="col-sm-4">
				<div class="get_asset2">
					<div class="circle">
				        <p>2</p>
				    </div>
					<h2 class="why_h2_content"><p>Search</p> <p>for reviews</p></h2>
				</div>
			</div>
			<div class="col-sm-4">
				<div class="get_asset3">
					<div class="circle">
				        <p>3</p>
				    </div>
					<h2 class="why_h2_content"><p>Share</p> <p>an experience</p></h2>
				</div>
			</div>
		</div>

		<div class="row why_div">
			<a href="sign_up.php" class="btn btn-outline-primary my-2 my-sm-0 create_account_div">Create account</a>
		</div>
	</div>
</div>
<!-- home page forth div end -->

<!-- footer content start-->
<div class="row footer_div">
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

<script src="assets/js/style.js"></script>
</body>
</html>