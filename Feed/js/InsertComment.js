$(document).ready(function()
{
	var working = false;
	
	$('.comment-form').live("submit", function(e)
	{
 		e.preventDefault(); 		
		var form = $(this);
		var id = $('#id', form).val();
		if(working) return false;
		
		working = true;
		$('span.error').remove();
		
		$.post('InsertComment.php', $(this).serialize(), function(msg){
			working = false;

			if(msg.status)
			{
				// Ifall den lyckades så gör så senaste kommentaren visas
				$(msg.html).hide().insertBefore('#addCommentContainer' + id).slideDown();
				$('#body', '#addCommentContainer' + id).val('');
			}

			else 
			{
				// Visa fel om det finns
				$.each(msg.errors,function(k,v){
					$('#addCommentContainer' + id + ' label[for='+k+']').append('<span class="error">'+v+'</span>');
				});
			}
		},'json');
	});	
});