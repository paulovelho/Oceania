function LoadOnDiv(url, div_id, callback) {
	$("#loader_cont").fadeIn();
	$.ajax({
		url: url, 
		success: function(result){
			$(div_id).html(result);
			$("#loader_cont").fadeOut();
			if( callback ){
				callback();
			}
		}
	});
}

function submitForm(form_id, url, callback_success, callback_error) {
	var form = $(form_id).serialize();
	postData(url, form, callback_success, callback_error);
}

function postData(url, data, callback_success, callback_error) {
	$.ajax({
		url: url,
		type: "POST",
		data: data, 
		dataType: "json",
		success: function(data){
			if( data.success ) {
				callback_success(data.data);
			} else {
				callback_error(data.error);
			}
		}
	});
}

$(document).ready(function(){
	$("#modal").on("hidden", function() { $(this).removeData("modal"); });
});
