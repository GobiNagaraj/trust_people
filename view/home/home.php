<html lang="en">
<head>
  <title>Home Page</title>
  <meta charset="utf-8">
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  
  
  <style>
    /* Remove the navbar's default margin-bottom and rounded borders */
    .bg-2 {
    background-color: #FFFFFF; 
    color: #ffffff;
  } 
  /* Container holding the image and the text */
.container {
  position: relative;
}

/* Bottom right text */
.text-block {
  position: absolute;
  bottom: 40px;
  right: 40px;
  background-color: lightblue;
  color: white;
  padding-left: 40px;
  padding-right: 40px;
}
    .navbar {
      margin-bottom: 0;
      border-radius: 0;
      background-color: rgb(255, 255, 255);
    }
    

    .center {
      display: block;
      margin-left: auto;
      margin-right: auto;
      /* width: 50%; */
    }
    .column {
  float: left;
  width: 50%;
  padding: 10px;
    }
    /* Add a black background color to the top navigation bar */

}
    .row:after {
  content: "";
  display: table;
  clear: both;
}
  </style>
</head>
<body>
<div class = "bg-2">

  <!-- Top Nav Bar -->
<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>                        
      </button>
      <img src="http://localhost/trust_people/images/logo.png" class="img-responsive" style="width:100%" alt="Image">
    </div>

    <!-- Sets Links -->
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav navbar-right">
        <li><a href="http://localhost/trust_people/defaultEnterprise.php"> For Enterprise</a></li>
        <li><a href="http://localhost/trust-people-website-master/designFolder/registerUser.php#"> Sign In</a></li>
        <button type="button" class="btn btn-primary">Register</button>
        
        
       
        
    </div>
  </div>
</nav>

  <!-- Text Block -->
<div class="container text-center">
<div class="container">
  <img src="images/share_experience.png" style="width:100%;">
  <div class="text-block">
    
    <h1 style="font-size:3vw">Share your experiences about hiring.</h1>
  </div>
</div>
</div>










</div>
<br><br>

<footer class="container-fluid text-center">
  <p>@copyright</p>
  <p>VDART 2020</p>
</footer>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.19.0/axios.min.js"></script>


  <!-- Vue Code -->
<script src="https://cdn.jsdelivr.net/npm/vue"></script>
<script>
	var app = new Vue({
		el: '#app',
		data: {
      errorMsg : "",
			successMsg : "",
			users : [],
			newUser : {id: "", name: "", datejoin: "" },
			currentUser : {},
			profile : [],
			newProfile : {profile_id: "", profile_name: "", bio: "", post_number: "", followers: "", following: "", other_info: "", degree: "", study: "", grade: "", description: "", current_password: "", new_password: ""},
			currentProfile : {},
			posts : [],
			newPost : {name: "", date_post: "", role: "", date_discussed: "", location: "", attachment: ""},
			currentPost : {},
			// a : 1
		},
		mounted: function(){
			this.getAllUser();
			this.getAllPosts();
			// this.a+1;
		},
    methods: {
			
			getAllPost(){
				axios.get("http://localhost/trust_people/model.php?action=readpost").then(function(response){
					if(response.data.error){
						app.errorMsg = response.data.message;
					}
					else{
						app.posts = response.data.posts;
					}
				});
			},

      updateUser(){
				var formData = app.toFormData(app.currentProfile);
				axios.post("http://localhost/trust_people/model.php?action=update_profile", formData).then(function(response){
					app.currentProfile = {};
					if(response.data.error){
						app.errorMsg = response.data.message;
					}
					else{
						app.successMsg = response.data.message;
						app.getAllProfile();
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
			selectProfile(profile){
				app.currentProfile = profile;
			},
			clearMsg(){
				app.errorMsg = "";
				app.successMsg = "";
			}
			},
	});
</script>
</body>
</html>

