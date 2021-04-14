<?php
    include_once '../model/db.php';
	
	$userId = 	$_SESSION['data']['register_id'];
    if($userId == null)
  	{
    	header('Location: ../');
  	}
  	
	if(isset($_GET['r'])){
		$resume = $_GET['r'];
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Trust People - Resume Details</title>
	<link rel="shortcut icon" type="image/x-icon" href="../assets/images/fav-icon.png"/>
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<script src="../assets/js/jquery.min.js"></script>
	<script src="../assets/js/bootstrap.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.3.200/pdf.js"></script>
	<input type="hidden" value="<?php echo $resume; ?>" id="resumeFileName">
	<script>
	window.onload = function() {
	    document.addEventListener("contextmenu", function(e){
	        e.preventDefault();
	        if(event.keyCode == 123) {
	        disableEvent(e);
	    }
	    }, false);
	 function disableEvent(e) {
	        if(e.stopPropagation) {
	            e.stopPropagation();
	        } else if(window.event) {
	            window.event.cancelBubble = true;
	        }
	    }
	}
	$(document).contextmenu(function() { return false;});

	resume = $('#resumeFileName').val();
	url = '../resumeFiles/'+resume;
	var thePdf = null;
	var scale = 1;
	pdfjsLib.getDocument(url).promise.then(function(pdf) {
	          thePdf = pdf;
	          viewer = document.getElementById('pdf-viewer');
	          for(page = 1; page <= pdf.numPages; page++) {
	            canvas = document.createElement("canvas");
	            canvas.className = 'pdf-page-canvas';
	            viewer.appendChild(canvas);
	            renderPage(page, canvas);
	          }
	      });
	      function renderPage(pageNumber, canvas) {
	          thePdf.getPage(pageNumber).then(function(page) {
	            viewport = page.getViewport(scale);
	            canvas.height = viewport.height;
	            canvas.width = viewport.width;
	            page.render({canvasContext: canvas.getContext('2d'), viewport: viewport});
	      });
	      }
	</script>
</head>
<body>
	<div id="pdf-viewer"></div>
</body>

<script>
document.onkeydown = function(e) {
    if (e.ctrlKey && 
        (e.keyCode === 67 || 
         e.keyCode === 86 || 
         e.keyCode === 85 || 
         e.keyCode === 117)) {
        return false;
    } else {
        return true;
    }
};
$(document).keypress("u",function(e) {
  if(e.ctrlKey)
  {
    return false;
    }
    else
    {
    return true;
    }
});
</script>
</html>