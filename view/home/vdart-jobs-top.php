<div class="parent-ads" style="padding: 10px;">
	<h4 style="text-align: center;font-weight: bold;">Jobs</h4>
	<hr>
	<div class="hot-jobs-cat"></div>
</div>

<script>
	$(document).ready(function(){
		var URL = window.location.href;
		var arr = URL.split('/');
		var parameter=arr[arr.length-1].split('?');
		index();
	});

	function index(){
		var	rows = '';
		var dmJSON = "https://api.ceipal.com/6e87731ef268d931630775328ee3b6610ca8de44be9c0bc33b/job-postings/?page=1&sortby=modify_date&sortorder=desc";
		$.getJSON( dmJSON, function(data) {

			var count = data.count;
		    var totalPages = Math.ceil(data.count / data.limit);
		    var limit = data.limit;
		    //console.log(data);
		    var a = 1;
			$.each(data.results, function(i, f) {

				const months = ["January", "February", "March", "April", "May", "June",
				"July", "August", "September", "October", "November", "December"];
				let current_datetime = new Date(f.created)
				let createdDt = months[current_datetime.getMonth()] + "," +current_datetime.getDate() +  " " + current_datetime.getFullYear()

				if(f.city != ''){
				rows = rows + '<div class=""><a href="' +f.apply_job+ '" target="_blank"><h5 style="font-weight: bold; color: #4d7aff;">' +f.job_code+ " - " +f.position_title+ '</h5></a></div>';
				rows = rows + '<div class=""><table width="100%"><tr><th width="70%;">' +f.city+ "," +f.state+ '</th><th style="text-align: right; width: 30%;"><a href=' +f.apply_job_monster+ ' target="_blank"><img src="../../assets/images/monster.png" alt="apply-monster-jobs" style="width: 25%;"></a>&nbsp;&nbsp;&nbsp;<a href=' +f.apply_job_indeed+ ' target="_blank"><img src="../../assets/images/indeed.png" alt="apply-indeed-jobs" style="width: 25%;"></a></th></tr><tr><th style="font-size: 12px; font-weight: normal;">' +createdDt+ '</th></tr></table></div><br>';
				rows = rows + '<div class=""><p style="text-align: justify;font-size: 14px;color: rgb(19, 46, 85);">' +f.requistion_description+ '</p></div><hr>';
				}
				a++;
			});
			//console.log(rows);
			$(".hot-jobs-cat").html(rows);
		});

	}
</script>