<!DOCTYPE html>
<html lang="en">
<head>
<title>SUA - Intalio page</title>
<script type="text/javascript" src="js/jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="js/jquery.simplemodal-1.3.3.min.js"></script>
<script type="text/javascript" src="js/jquery.ba-postmessage.min.js"></script>

<script type="text/javascript">
var sua_url = "http://mini-challenge";
function clearFileUpload(divid) {
	$('#'+divid+'-filename').val('');
    	$('#'+divid+'-fileid').val('');
	$('#'+divid+'-thumbnail').html("");
	$('#'+divid+'-title').removeAttr("disabled"); 
	$('#'+divid+'-description').removeAttr("disabled"); 
	$('#'+divid+'-choosefile').removeAttr("disabled"); 
}
$(document).ready(function(){
	$.receiveMessage(
        function(e){
            var parts = e.data.split('|', 3);
            var divid = parts[0];
			$.modal.close();
            if(parts[1] == "") {
				clearFileUpload(parts[0]);
			} else {
				$('#'+divid+'-filename').val(parts[2]);
    			$('#'+divid+'-fileid').val(parts[1]);
				$('#'+divid+'-thumbnail').html("<img src='"+sua_url+"/thumbnails/"+parts[2]+"' alt=''>");
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
                url: "makeFileId.php?form_pending_id="+encodeURIComponent($('#form_pending_id').val())+'&title=' + encodeURIComponent(title) + '&description=' + encodeURIComponent(description),
                async: false
            }).responseText;
            

            $.modal('<iframe src="' + iframe_url + '&amp;return_element=' + event.target.parentNode.id +'&amp;filetype=image&amp;return_url=' + encodeURI(window.location)+ '" height="450" width="450" style="border:0">', {
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
<div id="headimage">
  <h2>Head Image</h2>
  <input type='text' id='headimage-filename' name='headimage-filename' value='' DISABLED>
  <label for="headimage-title">Title</label><input type='text' id='headimage-title' name='headimage-title' value=''>
  <label for="headimage-description">Description</label><input type='text' id='headimage-description' name='headimage-description' value=''>
  <input type='hidden' id='headimage-fileid' name='headimage-fileid' value=''>
  <input type='submit' id='headimage-choosefile' value='Choose' class='file-choose-button'>
  <input type='reset' id='headimage-reset' value='Clear' class='file-reset-button'>
  <div id='headimage-thumbnail'></div>
</div>

<div id="normalimage">
  <h2>Normal Image</h2>
  <input type='text' id='normalimage-filename' name='normalimage-filename' value='' DISABLED>
  <label for="normalimage-title">Title</label><input type='text' id='normalimage-title' name='normalimage-title' value=''>
  <label for="normalimage-description">Description</label><input type='text' id='normalimage-description' name='normalimage-description' value=''>
  <input type='hidden' id='normalimage-fileid' name='normalimage-fileid' value=''>
  <input type='submit' id='normalimage-choosefile' value='Choose' class='file-choose-button'>
  <input type='reset' id='normalimage-reset' value='Clear' class='file-reset-button'>
  <div id='normalimage-thumbnail'></div>
</div>


<input name='submit' type="submit" id="submit" value="Submit">

</form>
 
</body>
</html>
