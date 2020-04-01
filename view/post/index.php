<!DOCTYPE html>
<html lang="en">
<head>
	<title>Post Now</title>
  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">  
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/css/bootstrap-datepicker.css" rel="stylesheet">  
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>  
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>  
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/js/bootstrap-datepicker.js"></script>
  <!-- Date-picker dependencies -->
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.3"></script>
  <script src="https://cdn.jsdelivr.net/npm/moment@2.22"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@4/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Date-picker itself -->
  <script src="https://cdn.jsdelivr.net/npm/pc-bootstrap4-datetimepicker@4.17/build/js/bootstrap-datetimepicker.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/pc-bootstrap4-datetimepicker@4.17/build/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
  <!-- Vue js -->
  <script src="https://cdn.jsdelivr.net/npm/vue@2.5"></script>
  <!-- Lastly add this package -->
  <script src="https://cdn.jsdelivr.net/npm/vue-bootstrap-datetimepicker@5"></script>
  <!-- <meta name="viewport" content="width=device-width, initial-scale=1"> -->
</head>

<!-- Main Body -->
<body>

<!-- Navbar -->
<nav class="topnav" id="myTopnav">
  <img src="trustpeople.png" alt="Trustpeople" class="trustpeople">
  <a style="color: #9e9e9e; margin-right: 450px; font-size: 20px;">For Enterprise </a>
  <img src="avatar.png" alt="Avatar" class="avatar">
  <a style="color: #9e9e9e; margin-right: 100px; font-size: 20px;">Williams</a>
  <a style="color: #000000;font-size: 30px;" href="#">≡</a>
  <a href="javascript:void(0);" class="icon" onclick="myFunction()">
    <i class="fa fa-bars"></i>
  </a>
</nav>

<!--Header-->
<header>
<script type="text/javascript" src="../../assets/js/index.js"></script>
<script type="text/javascript" src="../../assets/js/datepicker.js"></script>
<script type="text/javascript" src="../../assets/js/bootstrap-datepicker.min.js"></script>

<script type="text/stylesheet" src="../../assets/css/mystyle.css"></script>
<link rel="stylesheet" type="text/css" href="../../assets/css/mystyle.css">

<p class="display-4 pt-2" style="font-size: 20px;">Post Now</p>
<br>
</header>

<!--Main App-->
<div id="app">
<div id="main">
<hr/>

<!--form-->
<div class="container" style="color: #9e9e9e;">
  <form action="upload.php" action="#" method="POST" onsubmit="return checkform(this)" enctype="multipart/form-data">
	
  <!--Title / Discussion-->
    <div class="row">
      <div class="col-25">
        <label for="title">Title / Discussion</label>
      </div>
      <div class="col-75">
        <input type="text" id="title" name="title" v-model="newUser.title" required>
		<p><span id="title"></span></p>
      </div>
	</div>

	<!--Location-->
	<div class="row">
      <div class="col-25">
        <label for="title">Job Location</label>
      </div>
      <div class="col-75">
        <input type="text" id="country" name="country" v-model="newUser.location" required>
		<p><span id="title"></span></p>
      </div>
	</div>

	<!--Role-->
    <div class="row">
      <div class="col-25">
        <label for="role">Role</label>
      </div>
      <div class="col-75">
        <input type="text" id="role" name="role" v-model="newUser.role" required>
      </div>
	</div>

	<!--Linkedin URL-->
	<div class="row">
      <div class="col-25">
        <label for="url">LinkedIn URL</label>
      </div>
      </br>
      <div class="col-75">
        <input type="text" id="url" name="url" onkeyup="showURL(this.value)" v-model="newUser.url" required>
        <!--URL Validation Hint-->
        <br>
		    <span id="txtHint"></span>
      </div>
	</div>

	<!--Date Discussed-->
	<div class="row">
      <div class="col-25">
        <label for="role">Date of Backout</label>
      </div>
	  <div class="important">
      <input data-provide="datepicker" class="datepicker" type="text" id="datepicker" v-bind:value="newUser.date" v-on:input="newUser.date = $event.target.value">
      <span class="glyphicon glyphicon-calendar"></span>
      <!--<input type="date" name="date2" id="date2" v-model="newUser.date" required> -->
    </div>
	</div>

	<!--Experience-->
	<div class="row">
      <div class="col-25">
        <label for="role">Experience</label>
      </div>
        <div class="col-75">
        <input type="radio" id="Postive" name="Postive" value="Postive" v-model="newUser.xp">
        <label1 for="Postive">Postive</label>
        <input type="radio" id="Negative" name="Negative" value="Negative" v-model="newUser.xp">
        <label1 for="Negative">Negative</label>
      </div>
	</div>

  <!--Resume / File-->
  <div class="row">
      <div class="col-25">
        <label for="role">Resume / File</label>
      </div>
	  <div class="col-75">
    <input type="file" name="file" ref="file" id="file" v-model="newUser.file" required>
      </div>
	</div>

	<!--Subject-->
    <div class="row">
      <div class="col-25">
        <label for="subject">Details</label>
      </div>
      <div class="col-75">
        <textarea id="subject" name="subject" placeholder="#Tag1 #tag2" style="height:175px" v-model="newUser.subject"></textarea>
      </div>
	  </div>
  <br>
  
  <!--Confirm Buttons-->
  <div class="row">
    <div class="col-75">
      <button class="btn-lg" style="background-color: #6fade8; color: white; margin: 10px;" type="submit" value="Submit" @click="clearMsg();">Post Now</button>
      <button class="btn-lg" style="background-color: #d9534f; color: white;" @click="clearMsg();"> Cancel </button>      
    </div>
  </div>
  </form>
  <hr/>

  <!--Grid Text-->
  	<div class="grid-container" style="display: inline-block;">
		  <div class="grid-item" style="color: black;">
        Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
      </div>
    </div>
</div>
</div>
</div>

<!-- Javascript Imports -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.19.0/axios.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/vue"></script>
<!--VUE APP-->
<script>
	//vue
	var app = new Vue({
		el: '#app',
		data: {
			errorMsg : "",
			successMsg : "",
      users : [],
			//init
			newUser : {title: "", location: "", role: "", url: "", date: "", xp: "", subject: "", file: ""},
      currentUser : {},
		},
		methods: {
			//add user
			addUser(){
        var formData = app.toFormData(app.newUser);
				//reference model.php
				axios.post("../../controller/postController.php?action=create", formData).then(function(response){
					//error
					if(response.data.error){
						app.errorMsg = response.data.message;
					}
					else{
						app.successMsg = response.data.message;
					}
				});
			},    
			//form data
			toFormData(obj){
				var fd = new FormData();
				for(var i in obj){
					fd.append(i, obj[i]);
				}
				return fd;
			},
			//clear message
			clearMsg(){
				app.errorMsg = "";
				app.successMsg = "";
			}
		}
	});
</script>
</body>
</html>