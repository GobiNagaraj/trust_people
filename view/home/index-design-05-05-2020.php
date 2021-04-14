<?php 
	include_once '../../model/db.php';
	$conn = db_connect();

	$userId = 	$_SESSION['data']['register_id'];
	$flag 	=	$_SESSION['data']['flag'];
    if($userId == null)
  	{
    	header('Location: ../../');
  	}	

	$selectNav = execute_query($conn, "SELECT first_name, last_name, user_image, flag FROM `register_tbl` WHERE register_id = '$userId'");

	while($rows = mysqli_fetch_assoc($selectNav))
	{
  		$first_name 	= 	$rows['first_name'];
  		$last_name 		= 	$rows['last_name'];
  		$user_image 	= 	$rows['user_image'];
  		$flag 			=	$rows['flag'];
  	}

  	/*$uri = $_SERVER['REQUEST_URI'];
	echo $uri; // Outputs: URI

	$url = explode('?', $uri);
	print_r($url);
	$id = explode('=', $url[1]);
	print_r($id);*/
?>
<!DOCTYPE html>
<html>
<head>
	<title>Trust People Home Page</title>
	<link rel="shortcut icon" type="image/x-icon" href="../../assets/images/trust_people_fav.png"/>
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<link rel="stylesheet" type="text/css" href="../../assets/css/bootstrap.min.css">
	<script src="../../assets/js/jquery.min.js"></script>
	<script src="../../assets/js/bootstrap.min.js"></script>

	<link href="../../assets/css/font-awesome.css" rel="stylesheet" type="text/css" />
	<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,300italic,regular,italic,600,700,700italic" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Arimo" rel="stylesheet">
	<!-- <script src="hotreload.js"></script> -->
	<!-- custom css -->
	<link rel="stylesheet" type="text/css" href="../../assets/css/custom.css">
	<link rel="stylesheet" type="text/css" href="../../assets/css/home-individual.css">
</head>
<body style="font-family: Source Sans Pro;">
	<style>
		.collapsible {
		  /*background-color: #777;
		  color: white;
		  padding: 18px;
		  width: 100%;
		  border: none;
		  text-align: left;
		  outline: none;
		  font-size: 15px;*/
		  cursor: pointer;
		}

		/*.active {
		  background-color: #555;
		}*/

		/*.content {
		  padding: 0 18px;
		  display: none;
		  overflow: hidden;
		  border:1px solid #f1f1f1;
		  padding: 5px;
		}*/
		.content {
            padding: 0 18px;
            display: none;
            overflow: hidden;
            border: 1px solid #f1f1f1;
            padding: 5px;
            width: 195%;
            margin: 10px -490px;
        }
	</style>
	<style>
	 div.cjjobbox{
	   
	   width: 300px ;
	   background-color: #FFFFFF ;
	   border-style: solid ;
	   border-width: 1px ;
	   border-color: #919294 ;
	   font-family: Times, serif ;
	   font-size: 13px ;
	   color: #000000;
	   text-align: left;
	 }
	 div.cjjobbox a{
	   color: #198ADC ;
	 }
	</style>
	<div class="header-nav">
		<?php include_once '../nav_bar.php'; ?>
	</div>
	<?php include_once '../common-popup.php'; ?>
	<div class="main">
		<center><div class="container">
		<?php 
	        if (isset($_SESSION['success'])) 
	          {
	            switch ($_SESSION['success']) 
	            {
	                case $_SESSION['success']: 
	                echo "<script type='text/javascript'>
						$(document).ready(function(){
							$('.commonPopup').modal('show');
							$('.header-msg').html('Success Message');
							$('.content-msg').css('color', '#0045ab').html('".$_SESSION['success']."');
						});
					  </script>"; 
	                //echo '<div class="alert alert-success" style="padding: 10px;width: 50%;margin-top: 25px;margin-bottom: -15px;"><button data-dismiss="alert" class="close" type="button">×</button>'.$_SESSION['success'].'</div>';
	                unset($_SESSION['success']);
	                break;
	            }
	    	}

	    	if (isset($_SESSION['error'])) 
	        {
	            switch ($_SESSION['error']) 
	            {
	                case $_SESSION['error']: 
	                /*echo '<div class="alert alert-danger" style="padding: 10px;width: 50%;margin-top: 25px;margin-bottom: -15px;"><button data-dismiss="alert" class="close" type="button">×</button>'.$_SESSION['error'].'</div>';
	                unset($_SESSION['error']);*/
	                echo "<script type='text/javascript'>
						$(document).ready(function(){
							$('.commonPopup').modal('show');
							$('.header-msg').html('Error Message');
							$('.content-msg').css('color', 'red').html('".$_SESSION['error']."');
						});
					  </script>"; 
					unset($_SESSION['error']);
	                break;
	            }
	    	}
	    ?>
	    </div></center>
		<div class="container">
			<?php include 'post_popup.php'; ?>
			<div class="col-md-12 enterpriseDiv">
				<div class="col-md-4">
					<!-- <?php if($flag = '2'){ ?> -->
					<div class="blockSign">
						<div id="formContents">
							<div class="btn-group">
							  <button class="btn btn-info btn-sm news-feed" type="button"  style="font-size: 16px; font-family: Source Sans Pro;">
								<i class="fa fa-book"></i>&nbsp;&nbsp;&nbsp;<span class="newsFeed" style="color: #fff;">Most Recent</span>
							  </button>
							  <button type="button" class="btn btn-sm btn-info dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"  style="font-size: 16px; font-family: Source Sans Pro;">
							    <span class="text-info" style="color: #fff;"><i class="fa fa-caret-down"></i></span>
							  </button>
							  <div class="dropdown-menu">
							      <li class="tab active"><a href="#recent" id="mrt">Most Recent</a></li>
							      <li class="tab"><a href="#top" id="tpt">Top Post</a></li>
							  </div>
							</div>
						</div>
				        <!-- <div id="formContents">
				            <ul class="tab-group">
				            	<li class="tab active"><a href="#recent">Most Recent</a></li>
	                			<li class="tab"><a href="#top">Top Post</a></li>
				            </ul>
					    </div> -->
					</div>
					<!-- <?php }else{ ?>
						<p class="pForEnterprise">Analysis | Occassion | Role | Date </p>
					<?php } ?> -->
				</div>
				<div class="col-md-8">
					<div class="col-md-7">
						<?php include_once '../search/search_box.php'; ?>
					</div>
					<div class="col-md-3 pull-right pencil-div">
						<span class="pencil">
							<i class="fa fa-pencil" data-toggle="modal" data-target="#postModal" style="cursor: pointer;"></i>&nbsp;&nbsp;&nbsp;<a class="pencil-post" data-toggle="modal" data-target="#postModal" style="cursor: pointer;">Create Post</a>
						</span>
					</div>
				</div>
			</div>
			<br>
			<hr class="hr_home" style="width: 100%;">

			<div class="tab-content">
				<div id="recent" class="col-md-12">

					<div id="load_data"></div>

	                <div class="col-md-3 advertisement">
						<div class="cjjobbox">
							<h4 style="text-align: center;font-weight: bold;">Jobs</h4>
							<hr>
							<script type="text/javascript" src="https://www.careerjet.com/partners/js_jobbox.html?s=Java%2C%20RPA&l=USA&n=10&lid=55&nfr=1&ntt=1"></script>
						</div>

	                	<!-- <php include_once 'vdart-jobs-recent.php'; ?> -->
					</div>
            	</div><br>
            	<div id="load_data_message"><br></div>
                <!-- most recents ends  -->
                
                <!-- Top post Starts -->
                <div id="top" class="col-md-12 top_post">
                	<div id="load_data_top"></div>

	                <div class="col-md-3 advertisement">
	                	<div class="cjjobbox">
	                		<h4 style="text-align: center;font-weight: bold;">Jobs</h4>
							<hr>
							<script type="text/javascript" src="https://www.careerjet.com/partners/js_jobbox.html?s=Java%2C%20RPA&l=USA&n=10&lid=55&nfr=1&ntt=1"></script>
						</div>
					</div>
                </div>
                <div id="load_data_message_top"><br></div>
                <!-- Top post Ends -->
			</div>
		</div>
	</div>

	<script src="../../assets/js/comments-details.js"></script>
	<script src="../../assets/js/home-register.js"></script>
	<script src="../../assets/js/axios.min.js"></script>
	<script src="../../assets/js/vue.js"></script>

	<script>
		$(document).ready(function(){
			
			$("#top").hide();

		 	var limit = 2;
		 	var start = 0;
		 	var action = 'inactive';
		 	function load_country_data(limit, start)
		 	{	
		  		$.ajax({
		   		url:"fetch.php",
		   		method:"POST",
		   		data:{limit:limit, start:start},
		   		cache:false,
		   		success:function(data)
		   		{
		    		$('#load_data').append(data);
		    		if(data == '')
		    		{
		     		$('#load_data_message').html("<button type='button' class='btn btn-info'>You have reached end of the page</button>");
		     		action = 'active';
		    		}
		    		else
		    		{
		     		$('#load_data_message').html("<button type='button' class='btn btn-warning'>Please Wait....</button>");
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
		  	if($(window).scrollTop() + $(window).height() > $("#load_data").height() && action == 'inactive')
		  	{
		   		action = 'active';
		   		start = start + limit;
		   		setTimeout(function(){
		    		load_country_data(limit, start);
		   		}, 1000);
		  	}
			});

			/* script for Top Post details */
			var limit_top = 2;
		 	var start_top = 0;
		 	var action_top = 'inactive';
			 	function load_country_data_top(limit_top, start_top)
			 	{	
			  		$.ajax({
			   		url:"top_post.php",
			   		method:"POST",
			   		data:{limit_top:limit_top, start_top:start_top},
			   		cache:false,
			   		success:function(data)
			   		{
			    		$('#load_data_top').append(data);
			    		if(data == '')
			    		{
			     		$('#load_data_message_top').html("<button type='button' class='btn btn-info'>You have reached end of the page</button>");
			     		action_top = 'active';
			    		}
			    		else
			    		{
			     		$('#load_data_message_top').html("<button type='button' class='btn btn-warning'>Please Wait....</button>");
			     		action_top = "inactive";
			    		}
			   		}
			  		});
			 	}

			 	if(action_top == 'inactive')
			 	{
			  		action_top = 'active';
			  		load_country_data_top(limit_top, start_top);
			 	}
			 	$(window).scroll(function(){
			  	if($(window).scrollTop() + $(window).height() > $("#load_data_top").height() && action == 'inactive')
			  	{
			   		action_top = 'active';
			   		start_top = start_top + limit_top;
			   		setTimeout(function(){
			    		load_country_data_top(limit_top, start_top);
			   		}, 1000);
			  	}
			});
		});
	</script>

	<script>
		function myFunction() {
		  var x = document.getElementById("myTopnav");
		  if (x.className === "topnav") {
		    x.className += " responsive";
		  } else {
		    x.className = "topnav";
		  }
		}

		$("#mrt").on('click', function(){
			var news = $(this).attr('href');
			if(news == '#recent'){
				$(".newsFeed").html("Most Recent");
				$("#recent").show();
				$("#top").hide();
			}
		});
		$("#tpt").on('click', function(){
			var news = $(this).attr('href');
			if(news == '#top'){
				$(".newsFeed").html("Top Post");
				$("#recent").hide();
				$("#top").show();
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
				if(value.userImage == null){
					user_image = 'user.png';
				}else{
					user_image = value.userImage;
				}
				rows = rows + '<div class="col-md-12 commentDiv"><div class="col-md-2">';
				rows = rows + '<img src="../../userImage/'+user_image+'" class="commentsUserImg">';	
				rows = rows + '</div><div class="col-md-8">';
				rows = rows + '<p class="commentPara">'+value.comments+'</p></div></div>';
			});
			$(".commentsDiv_"+b).html(rows);
		}

		function getCommentDiv(i){
			//var user_id = $("#user_id_"+i).val();
			var post_id = $("#post_id_"+i).val();
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
	<script>
		function showEmail(a) {
		 	$(".show_email_"+a).toggle();
		}
	</script>
	<script>
		function add_comment_top(g){
			var userId = $("#user-Id_"+g).val();
			var postId = $("#post-Id_"+g).val();
			var registerId = $("#register-Id_"+g).val();
			var commentVal = $("#topcomments"+g).val(); 

			if(commentVal === ''){
				$("#topcomments"+g).css("border", "1px solid red").focus();
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
					$("#topcomments"+g).val('');
					getPageData_top(g);
				});
				return true;
			}
		}

		function getPageData_top(a){
			var postId = $("#post-Id_"+a).val();
			var userId = $("#user-Id_"+a).val();
			var status = '1';
			$.ajax({
				type: 'POST',
		    	url: '../../controller/commentsController.php',
		    	data: { status: status, postId: postId, userId: userId },
		    	dataType: 'json',
			}).done(function(data){
				manageRows_top(data.data,a);
			});
		}

		function manageRows_top(data,b) {
			//$("#comments"+b).val("");
			var	rows = '';
			var user_image = '';
			$.each( data, function( key, value ) {
				if(value.userImage == null){
					user_image = 'user.png';
				}else{
					user_image = value.userImage;
				}
				rows = rows + '<div class="col-md-12 commentDiv"><div class="col-md-2">';
				rows = rows + '<img src="../../userImage/'+user_image+'" class="commentsUserImg">';	
				rows = rows + '</div><div class="col-md-8">';
				rows = rows + '<p class="commentPara">'+value.comments+'</p></div></div>';
			});
			$(".TopcommentsDiv_"+b).html(rows);
		}

		function getCommentDiv_top(i){
			//var user_id = $("#user_id_"+i).val();
			var post_id = $("#post-id-"+i).val();
			//var reg_id = $("#register_id_"+i).val();
			var status = '1';
			$.ajax({
				type: 'POST',
		    	url: '../../controller/commentsController.php',
		    	data: { status: status, postId: post_id },
		    	dataType: 'json',
			}).done(function(data){
				console.log(data);
				manageRows_top(data.data,i);
			});
		}
	</script>

	<script>
		var coll = document.getElementsByClassName("collapsible");
		var i;

		for (i = 0; i < coll.length; i++) {
		  coll[i].addEventListener("click", function() {
		    this.classList.toggle("active");
		    var content = this.nextElementSibling;
		    if (content.style.display === "block") {
		      content.style.display = "none";
		    } else {
		      content.style.display = "block";
		    }
		  });
		}
	</script>
	<script>
	var app = new Vue({
		el: '',
		data: {
			errorMsg : "",
			successMsg : "",
			showAddModal : false,
			showEditModal : false,
			showDeleteModal : false,
			users : [],
			newUser : {name: "", email: "", contact: "", address: ""},
			currentUser : {},
		},
		mounted: function(){
			this.getAllUser();
		},
		methods: {
			getAllUser(){
				axios.get("../../controller?action=read").then(function(response){
					if(response.data.error){
						app.errorMsg = response.data.message;
					}
					else{
						app.users = response.data.users;
					}
				});
			},
			addUser(){
				var formData = app.toFormData(app.newUser);
				axios.post("../../controller?action=create", formData).then(function(response){
					app.newUser = {name: "", email: "", contact: "", address: ""};
					if(response.data.error){
						app.errorMsg = response.data.message;
					}
					else{
						app.successMsg = response.data.message;
						app.getAllUser();
					}
				});
			},
			updateUser(){
				var formData = app.toFormData(app.currentUser);
				axios.post("../../controller?action=update", formData).then(function(response){
					app.currentUser = {};
					if(response.data.error){
						app.errorMsg = response.data.message;
					}
					else{
						app.successMsg = response.data.message;
						app.getAllUser();
					}
				});
			},
			deleteUser(){
				var formData = app.toFormData(app.currentUser);
				axios.post("../../controller?action=delete", formData).then(function(response){
					app.currentUser = {};
					if(response.data.error){
						app.errorMsg = response.data.message;
					}
					else{
						app.successMsg = response.data.message;
						app.getAllUser();
					}
				});
			},
			toFormData(obj){
				var fd = new FormData();
				for(var i in obj){
					fd.append(i, obj[i]);
				}
				return fd;
			},
			selectUser(user){
				app.currentUser = user;
			},
			clearMsg(){
				app.errorMsg = "";
				app.successMsg = "";
			},
		}
	});
</script>
</body>
</html>