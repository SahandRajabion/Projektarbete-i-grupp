$(document).ready(function() 
{
		$('#editpost').live("click", function(e) 
		{
			e.preventDefault();

			var form = $(this.form);
			var valueInput = "";

			var postTitle = $('#Title', form).val();
			var postContent = $('#Post', form).val();
			var feedId = $('#hiddenFeedId', form).val();

			jQuery.ajax(
			{
				type: "POST",
				url: "CheckIfOwnPost.php",
			  	data: {feed_id:feedId},
			  	success:function(response)
			  	{
			  		// Kollar om det är success status
			  		if (response != "") 
			  		{
						$('#editpost', form).hide();
						$('.text-values p', '#post' + feedId).remove();

						if (postContent.length != 0) 
						{
							valueInput += "<textarea class='resize' name='postContent' id='postContent' rows='3' cols='35' maxlength='255'>"  + postContent + "</textarea>";
							valueInput += "<br> <input type='submit' id='saveContentEdit' value='Uppdatera'> <br>";			
						}

						else
						{
							valueInput += "<textarea class='resize' name='postTitle' id='postTitle' rows='3' cols='35' maxlength='255'>"  + postTitle + "</textarea>";
							valueInput += "<br> <input type='submit' id='saveTitleEdit' value='Uppdatera' style='margin-bottom: 15px;'>";
						}

						$(".text-values", '#post' + feedId).html(valueInput);			  			
			  		}
			  	}
			});			
		});

		 $('#saveTitleEdit').live("click", function(e) 
		 {
			e.preventDefault();
			var form = $(this.form);

			var newValueInput = "";

			var editedPostTitle = $('#postTitle', form).val();
			var editedPostContent = $('#postContent', form).val();
			var feedId = $('#hiddenFeedId', form).val();

				$.ajax(
				{
					type: "POST",
					url: "EditPost.php",
					data: {NewPostTitle:editedPostTitle, NewPostContent:editedPostContent, FeedId:feedId},
					success:function(response) 
					{
						if (response != "") 
						{
							newValueInput += "<p>" + response + "<p>";
							$('#Title', form).attr('value', response);		
							$('#editpost', form).show();
							$(".text-values", '#post' + feedId).html(newValueInput);			
						}

						else 
						{
							newValueInput += "<p>" + editedPostTitle + "<p>";
							$('#Title', form).attr('value', editedPostTitle);		
							$('#editpost', form).show();
							$(".text-values", '#post' + feedId).html(newValueInput);			
						}					
					}
				});
		}); 

		$("#saveContentEdit").live("click", function(e) 
		{
			e.preventDefault();
			
			var form = $(this.form);

			var newValueInput = "";

			var editedPostTitle = $('#postTitle', form).val();
			var editedPostContent = $('#postContent', form).val();
			var feedId = $('#hiddenFeedId', form).val();

			if (editedPostContent.length != 0) 
			{
				$.ajax(
				{
					type: "POST",
					url: "EditPost.php",
					data: {NewPostTitle:editedPostTitle, NewPostContent:editedPostContent, FeedId:feedId},
					success:function(response) 
					{
						if (response != "") 
						{
							newValueInput += "<p>" + response + "<p>";
							$('#Post', form).attr('value', response);
							$('#editpost', form).show();
							$(".text-values", '#post' + feedId).html(newValueInput);			
						}

						else 
						{
							newValueInput += "<p>" + editedPostContent + "<p>";
							$('#Post', form).attr('value', editedPostContent);
							$('#editpost', form).show();
							$(".text-values", '#post' + feedId).html(newValueInput);			
						}														
					}
				});
			}
		});
});
