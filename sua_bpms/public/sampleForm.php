<!DOCTYPE html>
<html lang="en">
<head>
<title>SUA - Intalio page</title>
<script type="text/javascript" src="js/jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="js/jquery.simplemodal-1.3.3.min.js"></script>
<script type="text/javascript" src="js/jquery.ba-postmessage.min.js"></script>

<script type="text/javascript">
var sua_url = "";
function clearFileUpload(divid) {
	$('#'+divid+'-filename').value = '';
    $('#'+divid+'-fileid').value = '';
	$('#'+divid+'-thumbnail').html("");
	$('#'+divid+'-choosefile').disabled = false;
}
$(document).ready(function(){
	$.receiveMessage(
        function(e){
            var parts = e.data.split('|', 3);
            if(parts[1] == "") {
				clearFileUpload(parts[0]);
			}
            if(parts[1] != "") {
				$('#'+divid+'-filename').value = parts[2];
    			$('#'+divid+'-fileid').value = parts[1];
				$('#'+divid+'-thumbnail').html("<img src='"+sua_url+"/thumbnails/"+parts[2]+"' alt=''>");
				$('#'+divid+'-choosefile').disabled = true;
	            //$("#"+parts[0]).html("<p>There is returned: "+parts[1]+"</p><input type='hidden' id='input-"+parts[0]+"' name='input-"+parts[0]+"' value='"+parts[1]+"' ");
            }
            $.modal.close()
	    },
	    sua_url
	);

    $(".file-choose-button").click(
        function(event){
            var iframe_url = $.ajax({
                url: "makeFileId.php",
                async: false
            }).responseText;
            

            $.modal('<iframe src="' + iframe_url + '&amp;return_element=' + event.target.parentNode.id +'&amp;filetype=image&amp;return_url=' + encodeURI(window.location)+ '" height="450" width="450" style="border:0">', {
	            closeHTML:"",
	            containerCss:{
		            backgroundColor:"#123564",
		            borderColor:"#0063dc",
		            height:450,
		            padding:0,
		            width:450
	            },
	            overlayClose:true
            });
            event.preventDefault();
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
<div id="headimage">
  <h2>Head Image</h2>
  <input type='text' id='headimage-filename' value='' DISABLED>
  <input type='hidden' id='headimage-fileid' value=''>
  <input type='submit' id='headimage-choosefile' value='Choose' class='file-choose-button'>
  <input type='reset' id='headimage-reset' value='Clear' class='file-reset-button'>
  <div id='headimage-thumbnail'></div>
</div>

<div id="normalimage">
  <h2>Normal Image</h2>
  <input type='text' id='normalimage-filename' value='' DISABLED>
  <input type='hidden' id='normalimage-fileid' value=''>
  <input type='submit' id='normalimage-choosefile' value='Choose' class='file-choose-button'>
  <input type='reset' id='normalimage-reset' value='Clear' class='file-reset-button'>
  <div id='normalimage-thumbnail'></div>
</div>


<input name='submit' type="submit" id="submit" value="Submit">

</form>
 
</body>
</html>
