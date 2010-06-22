<!DOCTYPE html>
<html lang="en">
<head>
<title>SUA - Intalio page</title>
<script type="text/javascript" src="js/jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="js/jquery.simplemodal-1.3.3.min.js"></script>
<script type="text/javascript" src="js/jquery.ba-postmessage.min.js"></script>

<script type="text/javascript">
var sua_url = "http://sua-demo.petersmit.eu";
function clearFileUpload(divid) {
	$('#'+divid+'-filename').val('');
    $('#'+divid+'-fileid').val('');
	$('#'+divid+'-thumbnail').html('');
	$('#'+divid+'-title').val('');
	$('#'+divid+'-description').val('');
	$('#'+divid+'-title').removeAttr("disabled"); 
	$('#'+divid+'-description').removeAttr("disabled"); 
	$('#'+divid+'-choosefile').removeAttr("disabled"); 
}
$(document).ready(function(){
	$.receiveMessage(
        function(e){
            var parts = e.data.split('|', 4);
            var divid = parts[0];
			$.modal.close();
            if(parts[1] == "") {
				clearFileUpload(parts[0]);
			} else {
				$('#'+divid+'-filename').val(parts[2]);
    			$('#'+divid+'-fileid').val(parts[1]);
				$('#'+divid+'-thumbnail').html("<img src='"+sua_url+"/thumbnails/"+parts[3]+"' alt=''>");
				$('#'+divid+'-title').attr("disabled", true);
				$('#'+divid+'-description').attr("disabled", true);
				$('#'+divid+'-choosefile').attr("disabled", true);
	            //$("#"+parts[0]).html("<p>There is returned: "+parts[1]+"</p><input type='hidden' id='input-"+parts[0]+"' name='input-"+parts[0]+"' value='"+parts[1]+"' ");
            }
            
	    },
	    sua_url
	);

    $(".file-choose-button").click(
        function(event){
			event.preventDefault();
            var divid = event.target.parentNode.id;

            var title = $('#' + divid + '-title').val();
            var description = $('#'+ divid + '-description').val();

			if(title == '' || description == '') {
				alert("Please give a title and description before uploading the file");
				return;
			}

            var iframe_url = $.ajax({
                url: "makeFileId.php?file_id=<?php echo rand(); ?>&form_pending_id="+encodeURIComponent($('#form_pending_id').val())+'&title=' + encodeURIComponent(title) + '&description=' + encodeURIComponent(description),                async: false
            }).responseText;
            
	    var filetype = 'image';
            if($('#'+divid).hasClass("upload-video")) {
		filetype = 'video';
	    }
            $.modal('<iframe src="' + iframe_url + '&amp;return_element=' + event.target.parentNode.id +'&amp;filetype='+ filetype + '&amp;return_url=' + encodeURIComponent(window.location)+ '" height="450" width="450" style="border:0">', {
	            closeHTML:"",
	            containerCss:{
		            backgroundColor:"#ddd",
		            borderColor:"#0063dc",
		            height:450,
		            padding:0,
		            width:450
	            },
	            overlayClose:true
            });
            
        }
	);

    $(".file-reset-button").click(
        function(event){
			clearFileUpload(event.target.parentNode.id);
            event.preventDefault();
		}
	);


});



</script>

</head>
<body>
<h1>SUA Intalio page</h1>
<p>Demo page, this must become an Intalio form</p>


<h2>A form</h2>
<form method='post' action='showsubmit.php'>
<input type='hidden' id='form_pending_id' name='form_pending_id' value='<?php echo rand(100000, 999999); ?>'>
<div id="headimage" class="upload-image">
  <h2>Head Image</h2>
  <input type='text' id='headimage-filename' name='headimage-filename' value='' DISABLED>
  <label for="headimage-title">Title</label><input type='text' id='headimage-title' name='headimage-title' value=''>
  <label for="headimage-description">Description</label><input type='text' id='headimage-description' name='headimage-description' value=''>
  <input type='hidden' id='headimage-fileid' name='headimage-fileid' value=''>
  <input type='submit' id='headimage-choosefile' value='Choose' class='file-choose-button'>
  <input type='reset' id='headimage-reset' value='Clear' class='file-reset-button'>
  <div id='headimage-thumbnail'></div>
</div>

<div id="normalimage" class="upload-image">
  <h2>Normal Image</h2>
  <input type='text' id='normalimage-filename' name='normalimage-filename' value='' DISABLED>
  <label for="normalimage-title">Title</label><input type='text' id='normalimage-title' name='normalimage-title' value=''>
  <label for="normalimage-description">Description</label><input type='text' id='normalimage-description' name='normalimage-description' value=''>
  <input type='hidden' id='normalimage-fileid' name='normalimage-fileid' value=''>
  <input type='submit' id='normalimage-choosefile' value='Choose' class='file-choose-button'>
  <input type='reset' id='normalimage-reset' value='Clear' class='file-reset-button'>
  <div id='normalimage-thumbnail'></div>
</div>

<div id="video1" class="upload-video">
  <h2>Video</h2>
  <input type='text' id='video1-filename' name='video1-filename' value='' DISABLED>
  <label for="video1-title">Title</label><input type='text' id='video1-title' name='video1-title' value=''>
  <label for="video1-description">Description</label><input type='text' id='video1-description' name='video1-description' value=''>
  <input type='hidden' id='video1-fileid' name='video1-fileid' value=''>
  <input type='submit' id='video1-choosefile' value='Choose' class='file-choose-button'>
  <input type='reset' id='video1-reset' value='Clear' class='file-reset-button'>
  <div id='video1-thumbnail'></div>
</div>


<input name='submit' type="submit" id="submit" value="Submit">

</form>
 
</body>
</html>
