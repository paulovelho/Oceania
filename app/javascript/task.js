function saveTask() {
	var id = $("#add-task #task-id").val();
	if(id > 0) updateTask();
	else insertTask();
	return false;
}

function insertTask() {
	submitForm("#add-task", "/Tasks/Add", 
		function(data){
			refreshCards(data.status_id);
			$(".modal-title").html($("#title").val());
			toggleEdit();
			$.jGrowl("Task Added", { header: 'Success', theme:"notification_styled_success" });			
		}, function() {
			alert("error!");
		});
}

function updateTask() {
	var title = $("#add-task #title").val();
	submitForm("#add-task", "/Tasks/Update", 
		function(data){
			refreshCards(data.status_id);
			$(".modal-title").html($("#title").val());
			toggleEdit();
			$.jGrowl("Task " + title + " Updated", { header: 'Success', theme:"notification_styled_success" });			
		}, function() {
			alert("error!");
		});
}

function deleteTask() {
	var title = $("#add-task #title").val();
	var just_go = confirm("do you really wish to delete task " + title + "?");
	if( !just_go )
		return false;
	submitForm("#add-task", "/Tasks/DeleteTask",
		function(data){
			refreshCards(data.status_id);
			$('#modal').modal('hide');
			$.jGrowl("Task " + title + " Deleted", { header: 'Success', theme:"notification_styled_success" });			
		}, function() {
			alert("error!");
		});
	return false;
}

function toggleEdit() {
	console.info("toggle");
	$("#task-desc").toggle();
	$("#task-desc-edit").toggle();
	$("#task-title-edit").toggle();
}
