$(document).ready(function()
{
	// Gör så man bara kan göra många submits
	var working = false;
	
	$('.comment-form').submit(function(e)
	{
 		e.preventDefault(); 		
		var form = $(this);
		var postId = $('#PostId', form).val();
		alert(postId);

		if(working) return false;
		
		working = true;
		$('span.error').remove();
		
		$.post('InsertComment.php', $(this).serialize(), function(msg){
			working = false;

			if(msg.status)
			{
				// Ifall den lyckades så gör så senaste kommentaren visas
				$(msg.html).hide().insertBefore('#addCommentContainer' + postId).slideDown();
				$('#body', '#addCommentContainer' + postId).val('');
			}

			else 
			{
				// Visa fel om det finns
				$.each(msg.errors,function(k,v){
					$('label[for='+k+']').append('<span class="error">'+v+'</span>');
				});
			}
		},'json');
	});	
});