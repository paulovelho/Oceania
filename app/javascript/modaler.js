// MODAL
/*
function modalOpen(url, title, onOpen) {
	if(!title) title = "";
	$(".modal-title").html(title);
	$("#modal").modal({ remote: url });
	if(onOpen) {
		$("#modal").on("shown", function() {
			onOpen();
			$("#modal").off("shown");
		});
	}
}

function modalClose() {
	$('#modal').modal('hide');
}

$(document).ready(function(){
	$("#modal").on("hidden", function() { 
		$(".modal-body").html("");
		$(this).removeData("modal"); 
	});
});
*/

// COLORBOX
function modalOpen(url, title, onOpen, onClose) {
	var cbox = {
		href: url,
		title: title,
		width: "60%"
	};
	if ( onOpen ) {
		cbox.onComplete = onOpen;
	}
	if ( onClose ) {
		cbox.onClosed = onClose;
	}
	$.colorbox(cbox);
}

function modalClose() {
	$.colorbox.close();
}

