$(document).ready(function() { 
	var working = false;

	var options = { 
			target: '#items',   // target element(s) to be updated with server response 
			beforeSubmit:  beforeSubmit,  // pre-submit callback 
			success:       afterSuccess,  // post-submit callback 
			uploadProgress: OnProgress, //upload progress callback 
			resetForm: true      // reset the form after successful submit 
		}; 
		
	 $('#MyUploadForm').submit(function(e) 
	 { 		
		e.preventDefault(); 

		if(working) 
		{
		 	return false;
		}

		else 
		{
			$(this).ajaxSubmit(options);
			working = true;	
		}
	}); 
		

//function after succesful file upload (when server response)
function afterSuccess(responseText, statusText, xhr, $form)
{
	working = false;

	$('#submit-btn').show(); //hide submit button
	$('#progressbox').delay( 3000 ).fadeOut(); //hide progress bar

}

//function to check file size before uploading.
function beforeSubmit(){

		    //check whether browser fully supports all File API

		if( !$('#FileInput').val() && !$('#Message').val() ) //check empty input filed
		{
			$("#output").html("<br>Dela något!");
			return false
		}

		if (!$('#FileInput').val().length == 0)
		{

		var fsize = $('#FileInput')[0].files[0].size; //get file size
		var ftype = $('#FileInput')[0].files[0].type; // get file type
		

		//allow file types 
		switch(ftype)
        {
            case 'image/png': 
			case 'image/gif': 
			case 'image/jpeg': 
                break;
            default:
                $("#output").html("<b>"+ftype+"</b> Filen är av en fel typ!");
				return false
        }
		
		
		if(fsize>5242880) 
		{
			$("#output").html("<b>"+bytesToSize(fsize) +"</b>Filen är för stor <br />Filen kan vara max 5 MB.");
			return false
		}
				
		$('#progressbox').delay( 1000 ).fadeOut();
		$("#output").html("");  
		} 

}

//progress bar function
function OnProgress(event, position, total, percentComplete)
{
    //Progress bar
	$('#progressbox').show();
    $('#progressbar').width(percentComplete + '%') //update progressbar percent complete
    $('#statustxt').html(percentComplete + '%'); //update status text
    if(percentComplete>50)
        {
            $('#statustxt').css('color','#000'); //change status text to white after 50%
            $('#progressbox').delay( 3000 ).fadeOut();
        }

}

//function to format bites bit.ly/19yoIPO
function bytesToSize(bytes) {
   var sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
   if (bytes == 0) return '0 Bytes';
   var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
   return Math.round(bytes / Math.pow(1024, i), 2) + ' ' + sizes[i];
}

}); 



