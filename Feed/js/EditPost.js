$(document).ready(function() 
{
	$('.post-edit').live("submit", function(e) 
	{
		e.preventDefault();
		var form = $(this);

		$(form).delegate("#editpost", "click", function() 
		{
			var valueInput = "";

			var postTitle = $('#Title', form).val();
			var postContent = $('#Post', form).val();
			var feedId = $('#hiddenFeedId', form).val();

			$('#editpost', form).hide();
			$('.text-values p', '#post' + feedId).remove();

			if (postContent.length != 0) 
			{
				valueInput += "<textarea class='resize' name='postContent' id='postContent' rows='3' cols='30'>"  + postContent + "</textarea>";
				valueInput += "<br> <input type='submit' id='saveContentEdit' value='Uppdatera'> <br>";			
			}

			else
			{
				valueInput += "<textarea class='resize' name='postTitle' id='postTitle' rows='3' cols='30'>"  + postTitle + "</textarea>";
				valueInput += "<br> <input type='submit' id='saveTitleEdit' value='Uppdatera' style='margin-bottom: 15px;'>";
			}

			$(".text-values", '#post' + feedId).html(valueInput);
		});

		 $(form).delegate("#saveTitleEdit", "click", function() 
		 {
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
						newValueInput += "<p>" + response + "<p>";
						$('#Title', form).attr('value', response);
								
						$('#editpost', form).show();
						
						$(".text-values", '#post' + feedId).html(newValueInput);
						
					}
				});
		}); 

		$(form).delegate("#saveContentEdit", "click", function() 
		{
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
						newValueInput += "<p>" + response + "<p>";
						$('#Post', form).attr('value', response);				

						$('#editpost', form).show();
						
						$(".text-values", '#post' + feedId).html(newValueInput);					
					}
				});
			}
		});
	});
});
