<!DOCTYPE html>
<html>
<head>
	<title>Trust People Home Page</title>
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="initial-scale=1">
	<link rel="stylesheet" type="text/css" href="../../assets/css/bootstrap.min.css">
	<script src="../../assets/js/jquery.min.js"></script>
	<script src="../../assets/js/bootstrap.min.js"></script>

	<link href="../../assets/css/font-awesome.css" rel="stylesheet" type="text/css" />
	<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,300italic,regular,italic,600,700,700italic" rel="stylesheet">
	<!-- custom css -->
	<link rel="stylesheet" type="text/css" href="../../assets/css/custom.css">
	<link rel="stylesheet" type="text/css" href="../../assets/css/home-register.css">
</head>
<body>
	<div class="container">
		<div class="col-md-12 homeDiv">
			<center><img src="../../assets/images/logo.png"></center>
		</div>
		<hr>
		<div class="blockSign">
	        <div id="formContent">
	            <ul class="tab-group">
	                <li class="tab"><a href="#signup">SIGN UP</a></li>
	                <li class="tab active"><a href="#signin">SIGN IN</a></li>
	            </ul>
	            <div class="tab-content">
	                <div id="signin">
	                	<h1 class="h1_letter">Sign in to your account </h1>
	                    <div class="row social_icon">
                        	<div class="pad50"></div>
								<a href="#" target="_blank" class="button google"><!-- <span><i class="fa fa-google" aria-hidden="true"></i></span> -->
								<span><img src="../../assets/images/google.png" style="width: 50%;"></span><p>Sign in with Google</p></a>

								<a href="#" target="_blank" class="button facebook"><!-- <span><i class="fa fa-facebook" aria-hidden="true"></i></span> -->
								<span><img src="../../assets/images/facebook.png" style="width: 70%;"></span><p>Sign in with Facebook</p></a>

								<a href="#" target="_blank" class="button linkedin"><!-- <span><i class="fa fa-linkedin" aria-hidden="true"></i></span> -->
								<span><img src="../../assets/images/linkedin.png" style="width: 50%;"></span><p>Sign in with Linkedin</p></a>
	                        </div>
                        <div class="break"><hr class="lefthr">Or<hr class="righthr"></div>
                        <br>
	                    <form class="needs-validation" id="validated-form" action="../home/defaultIndividual.php">
	                        <div class="form-group col-md-12">
		                        <input type="email" class="fadeIn" name="username" v-model="username" autocomplete="off" placeholder="Email Address"/>
		                        <span class="text-danger" v-if="validationErrors.username" v-text="validationErrors.username"></span>
		                    </div>
	                        <div class="form-group col-md-12">
		                        <input type="password" class="fadeIn" name="password" v-model="password" autocomplete="off" placeholder="Password"/>
		                        <span class="text-danger" v-if="validationErrors.password" v-text="validationErrors.password"></span>
		                    </div>
		                    <p class="terms">By clicking Sign In, you agree to our <strong>Terms of Use</strong> and our <strong>Privacy Policy</strong></p>
	                        <input type="submit" value="Sign In" @click.prevent="submitForm()">
	                        <!-- <p id="formFooter"><a href="#">Forgot Password?</a></p> -->
	                    </form>
	                    <p class="terms"><strong><a href="#" data-toggle="modal" data-target="#myModal">Forgot your password ?</a></strong></p>
	                    <div class="break"><hr class="lefthr">Or<hr class="righthr"></div>
                        <br>
                        <p class="terms"><strong><a href="enterpriseLogin.php">Sign in with your organisation</a></strong></p>
	                </div>
	                <br>
	                <div id="signup">
	                        <h1 class="h1_letter">Create your individual account </h1>
	                        <div class="row social_icon">
	                        	<div class="pad50"></div>
									<a href="#" target="_blank" class="button google"><!-- <span><i class="fa fa-google" aria-hidden="true"></i></span> -->
									<span><img src="../../assets/images/google.png" style="width: 50%;"></span><p>Sign in with Google</p></a>

									<a href="#" target="_blank" class="button facebook"><!-- <span><i class="fa fa-facebook" aria-hidden="true"></i></span> -->
									<span><img src="../../assets/images/facebook.png" style="width: 70%;"></span><p>Sign in with Facebook</p></a>

									<a href="#" target="_blank" class="button linkedin"><!-- <span><i class="fa fa-linkedin" aria-hidden="true"></i></span> -->
									<span><img src="../../assets/images/linkedin.png" style="width: 50%;"></span><p>Sign in with Linkedin</p></a>
		                        </div>
	                        <div class="break"><hr class="lefthr">Or<hr class="righthr"></div>
	                        <br>
		                    <form action="../home/defaultEnterprise.php">
		                    	<div class="form-group col-md-6">
		                        <input type="text" autocomplete="off" placeholder="First Name" />
		                        </div>
		                        <div class="form-group col-md-6">
		                        <input type="text" autocomplete="off" placeholder="Last Name" />
		                    	</div>
		                    	<div class="form-group col-md-12">
		                        <input type="email" autocomplete="off" placeholder="Email Address" />
		                    	</div>
		                    	<div class="form-group col-md-6">
		                        <input type="password" autocomplete="off" placeholder="Password" />
		                    	</div>
		                    	<div class="form-group col-md-6">
		                        <input type="password" autocomplete="off" placeholder="Confirm Password" />
		                    	</div>
		                    	<p class="terms">By clicking Sign In, you agree to our <strong>Terms of Use</strong> and our <strong>Privacy Policy</strong></p>
		                        <input type="submit" value="Sign Up">
		                    </form>
	                	</div>
		            </div>
		        </div>
		    </div>

		    <!-- Modal -->
			<div id="myModal" class="modal fade" role="dialog">
			  <div class="modal-dialog">

			    <!-- Modal content-->
			    <div class="modal-content">
			      <!-- <div class="modal-header">
			        <button type="button" class="close" data-dismiss="modal">&times;</button>
			        <h4 class="modal-title">Modal Header</h4>
			      </div> -->
			      <div class="modal-body">
			      	<div class="form-group">
			      		<span class="forgot-header">Find your Trust People account</span>	
			      	</div>
			      	<div class="form-group">
			      		<span>Enter your email or phone number</span>
			      		<input type="text" required autocomplete="off" />
			      	</div>
			        
			      </div>
			      <div class="" align="center">
			        <input type="submit" value="Search" data-toggle="modal" data-target="#resetPassword">
			      </div>
			    </div>

			  </div>
			</div>

			<!-- Modal -->
			<div id="resetPassword" class="modal fade" role="dialog">
			  <div class="modal-dialog">

			    <!-- Modal content-->
			    <div class="modal-content">
			      <!-- <div class="modal-header">
			        <button type="button" class="close" data-dismiss="modal">&times;</button>
			        <h4 class="modal-title">Modal Header</h4>
			      </div> -->
			      <div class="modal-body">
			      	<div class="form-group">
			      		<span class="forgot-header">Reset Password</span>	
			      	</div>
			      	<div class="form-group">
			      		<span>How do you want to reset your password ?</span>
			      		<input type="text" required autocomplete="off" />
			      	</div>
			        
			      </div>
			      <div class="" align="center">
			        <input type="submit" value="Continue">
			      </div>
			    </div>

			  </div>
			</div>
		</div>	

	<script src="../../assets/js/home-register.js"></script>
	<script src="../../assets/js/vue.js"></script>
	<script src="../../assets/js/axios.js"></script>
	<!-- <script src="../../assets/js/login-validation.js"></script> -->
</body>
</html>