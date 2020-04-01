<!DOCTYPE html>
<html lang="en">
<head>
  <title>For Individual</title>
  <meta charset="utf-8">
  <!-- Tell the browser to be responsive to screen width -->
  
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  
 
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
  
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  
<link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.1.0/css/font-awesome.min.css"/>
  
  <style>
    /* Remove the navbar's default margin-bottom and rounded borders */
    .bg-2 {
    background-color: #FFFFFF; 
    color: #ffffff;
  } 
    .navbar {
      margin-bottom: 0;
      border-radius: 0;
      background-color: rgb(255, 255, 255);
    }

    .nav-item img {
    max-width: 40px;
    border-radius: 50%;
}
.block1 {
  float:left ;
}
.block2 {
  float:right ;
}
.btn-xl {
    padding: 10px 20px;
    font-size: 20px;
    border-radius: 10px;
}
.button-oval {
  background-color: #ddd;
  border: none;
  color: black;
  padding: 10px 20px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  margin: 4px 2px;
  cursor: pointer;
  border-radius: 16px;
}
div.c {
  text-align: right;
} 
.topic { font-size: 25px; text-decoration: none; }
.topic2 { font-size: 20px; text-decoration: none; }
    

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
</style>
<!-- <nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>                        
      </button>
      <img src="http://localhost/trust_people/logo.png" class="img-responsive" style="width:100%" alt="Image">
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
    <ul class="nav navbar-nav navbar-right">
      <li><img src="http://localhost/trust_people/sample_profile.png" class="img-responsive" style="width:100%" alt="Image"></li>
      <li><h3> Williams </h3></li>
        
       
        
    </div>
  </div>
</nav>
-->
<!-- Collapsable Navbar -->
<div id="app">
<nav class="navbar navbar-expand-md">
    <a class="navbar-brand mb-n4 mr-auto" href="#">
		<img class="rounded-lg" src="images/logo.png" alt="Logo">
		<a href="defaultIndividual.php" class="d-flex justify-content-end small font-weight-lighter">For Individuals</p>
    </a>
    <div class="">
       <!-- Top Nav Bar -->
      <ul class="navbar-nav">
        <li class="nav-item align-self-center mx-2">
          <a class="nav-link" href="home.php">Home</a>
        </li>
        <li class="nav-item align-self-center mx-2">
          <a  href="defaultEnterprise.php">For Enterprise</a>
        </li>
		<li class="nav-item align-self-center mx-2">
			<a class="nav-link" href="profile.html">
				<img src="images/sample_profile.png" style="width:50%">
			</a>
		  </li>   
      </ul>
    </div>  
  </nav>
  <br>
  <!-- Container for search bar and profile icon -->
  <div class="block2">
<a class="glyphicon glyphicon-pencil topic" href="../post/"> Post Now</a>
 
  </div>
  <div class="block2">
  <div class="container-fluid ">
       <!-- Search Bar and Profile Icon      -->
	<form class="form-inline d-flex justify-content-center md-form form-sm my-1 ">
		<input class="form-control form-control-sm mr-3 w-75 rounded-lg" type="text" placeholder="Search" aria-label="Search">
		<i class="fa fa-search" aria-hidden="true"></i>
  	</form>
   
  
  <!-- Container for search bar and profile icon -->
  </div>
  </div>
  
<div class="block1">
<div class="btn-group btn-xl block1" role="group" aria-label="Basic example">
  <button type="button" class="btn btn-xl btn-secondary">Most Recent</button>
  <button type="button" class="btn btn-xl btn-secondary">Top Posts</button>
</div>
<a href="File Upload/index.php"> Change Profile Picture</a>
  </div>
  
  <br>
  <br><br><hr><br><br>  



  <!-- Post Formatting -->
<div class="container">
  <div class="well">
      <div class="media">
  		<a class="pull-left" href="#">
    		<img class="media-object" src="images/sample_profile.png">
  		</a>
  		<div class="media-body">
    		<h4 class="media-heading">Why can I no longer use the stretch button?</h4>
          <p class="text-right">By Williams @jamon</p>
          <p>This is a resource that seeks to educate job seekers or the unemployed on how to search for jobs online and offline. It is very important to note the various ways</p>
          <ul class="list-inline list-unstyled">
          <span><button v-on:click="followAlert" class="button-oval">Follow</button></span>
            <li>|</li>
  			<li><span><i class="glyphicon glyphicon-calendar"></i> Jan 14th, 2020</span></li>
            <li>|</li>
            <span><i class="glyphicon glyphicon-comment"></i> 2 comments</span>
            <li>|</li>
            
            
            <li>
              <p>43 Yes. I am with you.</p>
              <p>120 I have similar experience.</p>
            </li>
            <li>|</li>
            <span><a class="glyphicon glyphicon-share" href="#"> Share</a></span>
			</ul>
       </div>
    </div>
  </div>


  
  <!-- Database Post -->
  <div class="well">
      <div class="media" v-for="posts in posts">
  		<a class="pull-left" href="#">
    		<img class="media-object" src="images/sample_profile.png">
  		</a>
  		<div class="media-body">
    		<h4 class="media-heading">Why can I no longer use the stretch button?</h4>
          <p class="text-right">By {{ posts.name }}, {{ posts.role }}</p>
          <p>{{ posts.attachment }}</p>
          <ul class="list-inline list-unstyled">
          <span><button v-on:click="followAlert" class="button-oval">Follow</button></span>
            <li>|</li>
  			<li><span><i class="glyphicon glyphicon-calendar"></i> {{ posts.date_post }}</span></li>
            <li>|</li>
            <span><i class="glyphicon glyphicon-comment"></i> 2 comments</span>
            <li>|</li>
            
            <li>
              <button v-on:click="incrementAgree"> {{ agreeVal }} </button><p>Yes. I am with you.</p> 
              <button v-on:click="incrementSimilar"> {{ similarVal }} </button><p>I have similar experience.</p>
              
            </li>
            <li>|</li>
            <span><a class="glyphicon glyphicon-share" href="#"> Share</a></span>
			</ul>
       </div>
    </div>
  </div>
</div>



<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.19.0/axios.min.js"></script>
  <!-- Vue code -->
<script src="https://cdn.jsdelivr.net/npm/vue"></script>
<script>
	var app = new Vue({
		el: '#app',
		data: {
      errorMsg : "",
			successMsg : "",
      users : [],
      agreeVal: 0,
      similarVal: 0,
			posts : [],
			newPost : {name: "", date_post: "", role: "", date_discussed: "", location: "", attachment: ""},
			currentPost : {},
			// a : 1
    },
    //Calls the methods on start
		mounted: function(){
			
			this.getAllPost();
			// this.a+1;
		},
    methods: {
			
			getAllPost(){
				axios.get("../../controller/homeController.php?action=readpost").then(function(response){
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
				axios.post("../../controller/homeController.php?action=update_profile", formData).then(function(response){
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
      followAlert() {
        alert('You are now following this user.');
      },
      incrementAgree() {
      this.agreeVal = this.agreeVal + 1;
    },
    incrementSimilar() {
      this.similarVal = this.similarVal + 1;
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