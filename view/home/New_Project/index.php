<!DOCTYPE html>
<html lang="en">
<head>
	<title>Post</title>
  <link rel="stylesheet" type="text/css" href="css/mystyle.css">
  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">  
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/css/bootstrap-datepicker.css" rel="stylesheet">  
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>  
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>  
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/js/bootstrap-datepicker.js"></script>
</head>
<style>
body{
	background-color: #fbfbfb;
}
.container {
	background-color: #ffffff;
	box-shadow: 0px 2px;
	border: 2px solid #e0e0e0;
}
hr {
  display: block;
  height: 2px;
  border: 0;
	border-top: 2px solid #ccc;
	margin-bottom: 50px;
	margin-top: 50px;
  margin-left: 3em 2;
	padding: 0;
	width: 90%;
}
p{
	position: absolute;
  left: 75px;
}
.grid-container {
  display: grid;
  grid-template-columns: 500px 500px;
  justify-content: space-evenly;
  grid-gap: 30px;
  align-self: center;
}

/* FORM */
/* Style inputs, select elements and textareas */
input[type=text], select, textarea{
  width: 100%;
  padding: 12px;
  border: 1px solid #9e9e9e;
  border-radius: 4px;
  box-sizing: border-box;
  resize: vertical;
}
/* Style the label to display next to the inputs */
label {
  padding: 12px 12px 12px 50px;
  display: inline-block;
}
/* Style the submit button */
input[type=submit] {
  background-color: #4CAF50;
  color: white;
  padding: 12px 20px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  float: right;
}
/* Style the container */
.container {
  border-radius: 5px;
  background-color: #ffffff;
  padding: 20px;
}
/* Floating column for labels: 25% width */
.col-25 {
  float: left;
  width: 25%;
  margin-top: 10px;
}
.col-50 {
  float: left;
  width: 25%;
  margin-top: 10px;
}
/* Floating column for inputs: 75% width */
.col-75 {
  float: left;
  width: 75%;
  margin-top: 10px;
}
/* Clear floats after the columns */
.row:after {
  content: "";
  display: table;
  clear: both;
}
/* Responsive layout - when the screen is less than 600px wide, make the two columns stack on top of each other instead of next to each other */
@media screen and (max-width: 600px) {
  .col-25, .col-75, input[type=submit] {
    width: 100%;
    margin-top: 0;
  }
}
.avatar {
  width: 75px;
  height: 75px;
  border-radius: 50%;
  margin-right: 100px;
}
.trustpeople {
  width: 255px;
  height: 90px;
}
nav{
  background-color: #ffffff;
}
label{
  margin-left: 20px;
}
#date{
  width:200px; 
  margin: 0 20px 20px 0;
}
#date > span:hover{
  cursor: pointer;
}
</style>

<!-- Main Body -->
<body>

<!-- Navbar -->
<nav class="navbar navbar-light bg-white">
  <img src="trustpeople.png" alt="Trustpeople" class="trustpeople pull-left">
  <a class="pull-right" style="color: #9e9e9e; margin-right: 100px; font-size: 20px;" href="#">Snake </a>
  <img src="avatar.png" alt="Avatar" class="avatar pull-right">
	<a class="pull-right" style="color: #9e9e9e; margin-right: 150px; font-size: 25px;" href="#">For Enterprise </a>
</nav>

<!--Header-->
<header>
<p class="display-4 pt-2" style="font-size: 20px; color: #9e9e9e;">Post Now</p>
<br>
</header>

<!--Main App-->
<div id="app">

<!--Simple Validation-->
<script>
//URL validate
function showURL(str) {
    if (str.length == 0) {
        document.getElementById("txtHint").innerHTML = "";
        return;
    } else {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("txtHint").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET", "vurl.php?q=" + str, true);
        xmlhttp.send();
    }
}
//Form validate
function checkform(form) {
    // get all the inputs within the submitted form
    var inputs = form.getElementsByTagName('input');
    for (var i = 0; i < inputs.length; i++) {
        // only validate the inputs that have the required attribute
        if(inputs[i].hasAttribute("required")){
            if(inputs[i].value == ""){
                // found an empty field that is required
				alert("Please fill all required fields");
                return false;
            }
        }
    }
	return true;
}
//Date Picker
$( function() {
  $( "#date" ).datepicker();
});
</script>

<div id="main">
<hr/>
<!--form-->
<div class="container" style="color: #9e9e9e;">
  <form action="#" method="POST" onsubmit="return checkform(this)">
	
  <!--Title / Discussion-->
    <div class="row">
      <div class="col-25">
        <label for="title">Title / Discussion</label>
      </div>
      <div class="col-75">
        <input type="text" id="title" name="title" onkeyup="showT(this.value)" v-model="newUser.title" required>
		<p><span id="title"></span></p>
      </div>
	</div>

	<!--Location-->
	<div class="row">
      <div class="col-25">
        <label for="title">Job Location</label>
      </div>
      <div class="col-75">
        <input type="text" id="country" name="country" onkeyup="showT(this.value)" v-model="newUser.location" required>
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
	    	<!--URL Validation-->
		    <span id="txtHint"></span>
      </div>
	</div>

	<!--Date Discussed-->
	<div class="row">
      <div class="col-25">
        <label for="role">Date of Backout</label>
      </div>
	  <div class="col-75">
      <input  class="form-control" type="text" name="date" id="date" required>
    </div>
	</div>

	<!--Experience-->
	<div class="row">
      <div class="col-25">
        <label for="role">Experience</label>
      </div>
        <div class="col-75">
        <input type="radio" id="Negative" name="Negative" value="Negative" v-model="newUser.xp">
        <label for="Negative">Negative</label>
        <input type="radio" id="Postive" name="Postive" value="Postive" v-model="newUser.xp">
        <label for="Postive">Postive</label>
      </div>
	</div>

	<!--Resume / File-->
	<div class="row">
      <div class="col-25">
        <label for="role">Resume / File</label>
      </div>
	  <div class="col-75">
	  	<input type="file" v-model="newUser.file">
      </div>
	</div>

	<!--Subject-->
    <div class="row">
      <div class="col-25">
        <label for="subject">Details</label>
      </div>
      <div class="col-75">
        <textarea id="subject" name="subject" placeholder="#Tag1 #tag2" style="height:175px" v-model="newUser.subject" required></textarea>
      </div>
	</div>
	<br>
	  <button class="btn-sm" style="background-color: #6fade8; color: white; position: relative;" type="submit" value="Submit" @click="addUser(); clearMsg();">Post Now</button>
	  <button class="btn-sm" style="background-color: #d9534f; color: white; position: relative;" @click="clearMsg();"> Cancel </button>
  </form>
  <hr/>
  <!--Confirm Buttons-->
  	<div class="grid-container" style="display: inline-block;">
		<div class="grid-item" style="color: black;">
      Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
    </div>
  </div>
</div>
</div>
</div>

<!--<script src="js/datepicker.js"></script>-->
<!--<script src='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js'></script>-->
<!-- Javascript Imports -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.19.0/axios.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/vue"></script>
<!--VUE APP-->
<script>
	//vue constructor
	var app = new Vue({
		el: '#app',
		data: {
			errorMsg : "",
			successMsg : "",
			users : [],
			//init
			newUser : {title: "", location: "", role: "", url: "", date: "", xp: "", file:"", subject: ""},
			currentUser : {},
		},
		methods: {
			//add user
			addUser(){
				var formData = app.toFormData(app.newUser);
				//reference model.php
				axios.post("http://localhost/New_Project/model.php?action=create", formData).then(function(response){
					//error
					if(response.data.error){
						app.errorMsg = response.data.message;
					}
					else{
						app.successMsg = response.data.message;
						app.getAllUser();
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
			selectUser(user){
				app.currentUser = user;
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