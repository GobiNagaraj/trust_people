		$(document).ready(function(){
			/*setTimeout(function(){
		       $("div.alert").remove();
		    }, 3000 );*/ // 3 secs
		    /*setInterval(function(){
				$(".mobile-notification").load('../nav_bar.php')
			}, 2000);*/
			$(document).on('click','.yes', function(){
				var userId 		= 	$(this).data('userid');
				var registerId 	= 	$(this).data('registerid');
				var postId 		= 	$(this).data('postid');
				var initialCount = '1';

				$.ajax({
					type: 'POST',
					url: '../../controller/socialDetails.php',
					data: { userId: userId, registerId: registerId, postId: postId, yes_iam: initialCount },
					dataType: 'json',
					success: function(data){
						window.location.href = "";
					}
				});
			});

			$(document).on('click','.same', function(){
				var userId 		= 	$(this).data('userid');
				var registerId 	= 	$(this).data('registerid');
				var postId 		= 	$(this).data('postid');
				var initialCount = '1';

				$.ajax({
					type: 'POST',
					url: '../../controller/socialDetails.php',
					data: { userId: userId, registerId: registerId, postId: postId, same: initialCount },
					dataType: 'json',
					success: function(data){
						window.location.href = "";
					}
				});
			});

			/*$(document).on('click','.follow_btn', function(){
				var userId 		= 	$(this).data('userid');
				var registerId 	= 	$(this).data('registerid');
				var count = '1';
				var followerStatus = '0';

				$.ajax({
					type: 'POST',
					url: '../../controller/socialDetails.php',
					data: { userId: userId, registerId: registerId, follow: count, followerStatus : followerStatus },
					dataType: 'json',
					success: function(data){
					    //alert("Follow Request has been send.");
						//window.location.href = "";
						$(this).text('Request Sent');
					}
				});
			});*/

			/*$(document).on('click','.un_follow_btn', function(){
				var userId 		= 	$(this).data('userid');
				var registerId 	= 	$(this).data('registerid');
				var count = '0';

				$.ajax({
					type: 'POST',
					url: '../../controller/socialDetails.php',
					data: { userId: userId, registerId:registerId, unfollow: count },
					dataType: 'json',
					success: function(data){
						window.location.href = "";
					}
				});
			});*/
		});

		function follow_btn(fl){
			var userId 		= 	$(".userFollowId_"+fl).val();
			var registerId 	= 	$(".registerFollowId_"+fl).val();
			var count = "1";
			var followerStatus = "0";

			$.ajax({
				type: 'POST',
				url: '../../controller/socialDetails.php',
				data: { userId: userId, registerId: registerId, follow: count, followerStatus : followerStatus },
				dataType: 'json',
				success: function(data){
				    //alert("Follow Request has been send.");
					//window.location.href = "";
					$('.follow_'+fl).text('Request Sent');
				}
			});
		}

		/*code for to check user clicks Yes and Same as once*/
		function checkYesCount(a){
			var userId 		= 	$("#userId_"+a).val();
			var postId 		= 	$("#postId_"+a).val();
			var registerId 	= 	$("#registerId_"+a).val();
			var yes 		=	'1';

			$.ajax({
				type: 'post',
				url: '../../controller/checkSocialCount.php',
				data: { userId: userId, postId: postId, yes: yes },
				dataType: 'json',
				success: function(response){
					/*alert(response.message);*/
					if(response.message == 'fail!'){
						$("#yes"+a).attr('class', 'no-class btn btn-xs btn-default');
					}
				}
			});
		}

		function checkSameCount(b){
			var userId 		= 	$("#userId_"+b).val();
			var postId 		= 	$("#postId_"+b).val();
			var registerId 	= 	$("#registerId_"+b).val();
			var same 		=	'1';

			$.ajax({
				type: 'post',
				url: '../../controller/checkSocialCount.php',
				data: { userId: userId, postId: postId, same:same },
				dataType: 'json',
				success: function(response){
					if(response.message == 'fail!'){
						/*alert(response.message);*/
						$("#same"+b).attr('class', 'no-class btn btn-xs btn-default');
					}
				}
			});
		}

		function postYes(a){
			var userId 		=	$("#userId_"+a).val();
			var postId 		=	$("#postId_"+a).val();
			var registerId 	=	$("#registerId_"+a).val();
			var yes_iam		=	'1';

			$.ajax({
				url: '../../controller/socialDetails.php',
				type: 'post',
				data: { 'userId' : userId, 'postId' : postId, 'registerId' : registerId, 'yes_iam' : yes_iam },
				dataType: 'json',
				success:function(data){
					if(data.msg == 'success'){
						$('#activeHeartIcon_'+a).removeClass();
				  		$('.yesCount_'+a).text(data.status);
				  		$('#activeHeartIcon_'+a).addClass('fa fa-thumbs-up like-symbol');
					}
	  				if(data.msg == 'unfollow'){
	  					$('#activeHeartIcon_'+a).removeClass();
	  					$('#activeHeartIcon_'+a).addClass('fa fa-thumbs-o-up');
				  		$('.yesCount_'+a).text(data.status);
	  				}
	  				
				}
			});
		}

		function postSame(b){
			var userId 		=	$("#userId_"+b).val();
			var postId 		=	$("#postId_"+b).val();
			var registerId 	=	$("#registerId_"+b).val();
			var same		=	'1';

			$.ajax({
				url: '../../controller/thumpsUpController.php',
				type: 'post',
				data: { 'userId' : userId, 'postId' : postId, 'registerId' : registerId, 'same' : same },
				dataType: 'json',
				success:function(data){
					if(data.msg == 'success'){
						$('#activeLikeIcon_'+b).removeClass();
				  		$('.sameCount_'+b).text(data.status);
				  		$('#activeLikeIcon_'+b).addClass('fa fa-thumbs-down like-symbol');
	  				}
	  				if(data.msg === 'unlike'){
	  					$('#activeLikeIcon_'+b).removeClass();
	  					$('#activeLikeIcon_'+b).addClass('fa fa-thumbs-o-down');
				  		$('.sameCount_'+b).text(data.status);
	  				}
				}
			});
		}

		function postYesTop(a){
			var userId 		=	$("#userId_"+a).val();
			var postId 		=	$("#postId_"+a).val();
			var registerId 	=	$("#registerId_"+a).val();
			var yes_iam		=	'1';

			//alert(userId);

			$.ajax({
				url: '../../controller/socialDetails.php',
				type: 'post',
				data: { 'userId' : userId, 'postId' : postId, 'registerId' : registerId, 'yes_iam' : yes_iam },
				dataType: 'json',
				success:function(data){
					if(data.msg == 'success'){
						$('#iactiveHeartIcon_'+a).removeClass();
				  		$('.yesCount_'+a).text(data.status);
				  		$('#iactiveHeartIcon_'+a).addClass('fa fa-heart like-heart');
					}
	  				if(data.msg == 'unfollow'){
	  					$('#iactiveHeartIcon_'+a).removeClass('fa fa-heart like-heart');
	  					$('#iactiveHeartIcon_'+a).addClass('fa fa-heart-o');
				  		$('.yesCount_'+a).text(data.status);
	  				}
	  				
				}
			});
		}

		function postSameTop(b){
			var userId 		=	$("#userId_"+b).val();
			var postId 		=	$("#postId_"+b).val();
			var registerId 	=	$("#registerId_"+b).val();
			var same		=	'1';

			$.ajax({
				url: '../../controller/thumpsUpController.php',
				type: 'post',
				data: { 'userId' : userId, 'postId' : postId, 'registerId' : registerId, 'same' : same },
				dataType: 'json',
				success:function(data){
					if(data.msg == 'success'){
						$('#iactiveLikeIcon_'+b).removeClass();
				  		$('.sameCount_'+b).text(data.status);
				  		$('#iactiveLikeIcon_'+b).addClass('fa fa-thumbs-up like-symbol');
	  				}
	  				if(data.msg === 'unlike'){
	  					$('#iactiveLikeIcon_'+b).removeClass();
	  					$('#iactiveLikeIcon_'+b).addClass('fa fa-thumbs-o-up');
				  		$('.sameCount_'+b).text(data.status);
	  				}
				}
			});
		}


		/* script for accept and reject the followers details */
		function acceptRequest(id){
			var userId = $('.accept_fol_request').attr("data-userid");
			var regId = $('.accept_fol_request').attr("data-regid");
			var followStatus = $('.accept_fol_request').attr("data-reqsts");

			$.post('../../controller/follow_unfollowController.php', { 'userId' : userId, 'regId' : regId, 'followStatus' : followStatus }, function(data){
			  	if(data === 'success'){
			  		window.location.href = "";
  					return true;
  				} 
  				else{
  					alert('Something went to wrong!');
  					return false;
  				} 
			});
			
		}

		function cancelRequest(id){
			var userId = $('.cancel_fol_request').attr("data-userid");
			var regId = $('.cancel_fol_request').attr("data-regid");
			var unfollowStatus = $('.cancel_fol_request').attr("data-reqsts");

			$.post('../../controller/follow_unfollowController.php', { 'userId' : userId, 'regId' : regId, 'unfollowStatus' : unfollowStatus }, function(data){
			  	if(data === 'success'){
			  		window.location.href = "";
  					return true;
  				} 
  				else{
  					alert('Something went to wrong!');
  					return false;
  				} 
			});
		}

		/*$(".accept_fol_request").on('click', function(){
			var userId 			=	$(this).data('userid');
			var regId 			=	$(this).data('regid');
			var followStatus 	=	$(this).data('reqsts');

			$.post('../../controller/follow_unfollowController.php', { 'userId' : userId, 'regId' : regId, 'followStatus' : followStatus }, function(data){
			  	if(data === 'success'){
			  		window.location.href = "";
  					return true;
  				} 
  				else{
  					alert('Something went to wrong!');
  					return false;
  				} 
			});
		});*/

		/*$(".cancel_fol_request").on('click', function(){
			var userId 			=	$(this).data('userid');
			var regId 			=	$(this).data('regid');
			var unfollowStatus 	=	$(this).data('reqsts');

			$.post('../../controller/follow_unfollowController.php', { 'userId' : userId, 'regId' : regId, 'unfollowStatus' : unfollowStatus }, function(data){
			  	if(data === 'success'){
			  		window.location.href = "";
  					return true;
  				} 
  				else{
  					alert('Something went to wrong!');
  					return false;
  				} 
			});
		});*/

		/* Remove Connection */
		/*$(".remove_connection_btn").on('click', function(){
			var userId 			=	$(this).data('userid');
			var regId 			=	$(this).data('registerid');
			var removeStatus 	=	$(this).data('removeconn');

			$.post('../../controller/follow_unfollowController.php', { 'userId' : userId, 'registerId' : regId, 'removeStatus' : removeStatus }, function(data){
			  	if(data === 'success'){
			  		window.location.href = "";
  					return true;
  				} 
  				else{
  					alert('Something went to wrong!');
  					return false;
  				} 
			});
		});*/

	/* check and get trustable and untrustable list details */
	function getTrustableList(trust_ids){
		var trustPostId = trust_ids;
		var rows = '';
		$.ajax({
			url: '../../controller/getAllUserList.php',
			type: 'post',
			data: { trustPostId: trustPostId },
			dataType: 'json',
			success:function(data){
				//console.log(data);
				$.each( data, function( key, value ) {
					//alert(value.firstName+ " "+value.lastName);
					rows += '<li>'+value.firstName+' '+value.lastName+'</li>';
				});
				$(".trust_list_"+trust_ids).html(rows);
			}
		});
	}

	function getUnTrustableList(untrust_ids){
		var UnTrustPostId = untrust_ids;
		var row = '';
		$.ajax({
			url: '../../controller/getAllUserList.php',
			type: 'post',
			data: { UnTrustPostId: UnTrustPostId },
			dataType: 'json',
			success:function(data){
				//console.log(data);
				$.each( data, function( key, value ) {
					//alert(value.firstName+ " "+value.lastName);
					row += '<li>'+value.firstName+' '+value.lastName+'</li>';
				});
				$(".un_trust_list_"+untrust_ids).html(row);
			}
		});
	}