$(document).ready(function() 
{
	$('.post-remove').live("submit", function(e) {
		e.preventDefault();
		var form = $(this);
		var imageName = $('#imgName', form).val();
		var feedId = $('#hiddenFeedId', form).val();

		$.ajax(
		{
			type: "POST",
		 	url: "DeletePost.php",
		   	data: {image_name:imageName, feed_id:feedId},
		   	success:function(response)
		   	{
		   		// Kollar om success ifall 1
		   		if (response == 1) 
		   		{
		   			$('#post' + feedId).fadeOut("slow");
		   		}
		   	}
		 });
	});

});
