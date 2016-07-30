function LoadOnDiv(url, div_id, callback) {
	$("#loader_cont").fadeIn();
	$.ajax({
		url: url, 
		success: function(result){
			$(div_id).html(result);
			$("#loader_cont").fadeOut();
		}
	});
}

function submitForm(form_id, url, callback_success, callback_error) {
	var form = $(form_id).serialize();
	$.ajax({
		url: url, 
		type: "POST",
		data: form, 
		dataType: "json",
		success: function(data){
			if( data.success ) {
				callback_success(data.data);
			} else {
				callback_error(data.error);
			}
		}
	})
}
