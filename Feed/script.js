function autocomplet() {
	var min_length = 1; 
	var keyword = $('#course_id').val();

	if (keyword.length >= min_length) {
		$.ajax({
			url: 'ajax_autocomplete.php',
			type: 'POST',
			data: {keyword:keyword},
			success:function(data){

				if (data != "") {
					$('#course_list_id').show();
					$('#course_list_id').html(data);
				}
			}
		});
	} else {
		$('#country_list_id').hide();
	}
}

function set_item(item) {

	$('#course_id').val(item);
	$('#course_list_id').hide();

}