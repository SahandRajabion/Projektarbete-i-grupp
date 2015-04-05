$(document).ready(function()
{
	// Gör så man bara kan göra många submits
	var working = false;
	
	$('#addCommentForm').submit(function(e)
	{
 		e.preventDefault();
		if(working) return false;
		
		working = true;
		$('span.error').remove();
		
		$.post('InsertComment.php', $(this).serialize(), function(msg){
			working = false;
			
			if(msg.status)
			{
				// Ifall den lyckades så gör så senaste kommentaren visas
				$(msg.html).hide().insertBefore('#addCommentContainer').slideDown();
				$('#body').val('');
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