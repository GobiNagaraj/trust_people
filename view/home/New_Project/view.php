<!DOCTYPE html>
<html>
<head>
	<!--title-->
	<title>View Post Data</title>
	<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
	<link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
	<!--CSS file-->
	<link rel="stylesheet" type="text/css" href="mystyle.css">
</head>
<body>
<div id="app">
<div id="main">
	<button class="openbtn" onclick="openNav()">&#9776;</button>
		<!-- functions -->
		<div class="container">
			<div class="row mt-3">
				<div class="col-lg-6">
				</div>
			</div>
			<hr class="bg-info">
			<!-- column names -->
			<div class="row">
				<div class="col-lg-12">
					<table class="table table-bordered table-striped">
						<thead class="text-left bg-info text-light">
							<th>Title/Discussion</th>
							<th>Job Location</th>
							<th>Role</th>
							<th>LinkedIn URL</th>
							<th>Date</th>
							<th>Experience</th>
							<th>Resume / File</th>
							<th>Subject</th>
						</thead>
						<tbody>
							<!-- column inputs -->
							<tr class="text-left" v-for="user in users">
								<td>{{ user.title }}</td>
								<td>{{ user.location }}</td>
								<td>{{ user.role }}</td>
								<td>{{ user.url }}</td>
								<td>{{ user.date }}</td>
								<td>{{ user.xp }}</td>
								<td>{{ user.file }}</td>
								<td>{{ user.subject }}</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.19.0/axios.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/vue"></script>
<!-- vue application -->
<script>
	var app = new Vue({
		el: '#app',
		data: {
			//initialize 
			errorMsg : "",
			successMsg : "",
			users : [],
			newUser : {title: "", location: "", role: "", url: "", date: "", xp: "", file:"", subject: ""},
			currentUser : {},
		},
		mounted: function(){
			this.getAllUser();
		},
		methods: {
			//show table data
			getAllUser(){
				axios.get("http://localhost/New_Project/model.php?action=read").then(function(response){
					if(response.data.error){
						app.errorMsg = response.data.message;
					}
					else{
						app.users = response.data.users;
					}
				});
			},
			//add user
			addUser(){
				var formData = app.toFormData(app.newUser);
				//reference model.php
				axios.post("http://localhost/New_Project/model.php?action=create", formData).then(function(response){
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