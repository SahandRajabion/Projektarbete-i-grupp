$(document).ready(function() 
{
	$("body").on("click", "#items .delete_button", function(e) {
		e.preventDefault();
		var commentID = this.id;

		jQuery.ajax(
		{
			type: "POST",
			url: "DeleteComment.php",
		  	data: {comment_id:commentID},
		  	success:function(response)
		  	{
		  		// Kollar om det är success status
		  		if (response != "") 
		  		{
		  			$('#comment' + commentID).fadeOut();
		  		}
		  	}
		});
	});

});