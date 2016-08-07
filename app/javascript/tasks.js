function updateList() {
	LoadOnDiv("/Tasks/ShowList", "#taskList");	
}

function saveTask() {
	var id = $("#add-task #task-id").val();
	if(id == null) insertTask();
	else updateTask();
	return false;
}

function insertTask() {
	submitForm("#add-task", "/Tasks/Add", 
		function(){
			refreshBoard();
			$('#modal').modal('hide');
			$.jGrowl("Task Added", { header: 'Success', theme:"notification_styled_success" });			
		}, function() {
			alert("error!");
		});
}

function updateTask() {
	var title = $("#add-task #title").val();
	submitForm("#add-task", "/Tasks/Update", 
		function(){
			refreshBoard();
			$('#modal').modal('hide');
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
		function(){
			refreshBoard();
			$('#modal').modal('hide');
			$.jGrowl("Task " + title + " Deleted", { header: 'Success', theme:"notification_styled_success" });			
		}, function() {
			alert("error!");
		});
	return false;
}

function viewTask(id, title) {
	if(title == null) title = "Task";
	$(".modal-title").html(title);
	$("#modal").modal({ remote: "/Tasks/Show/" + id });
}

function addTask(){
	$(".modal-title").html("New Task");
	$("#modal").modal({ remote: "/Tasks/NewTask" });
}

function changeStatus(task_id, status) {
	st = $(status).val();
	postData("/Tasks/ChangeStatus", {
			task_id: task_id,
			status_id: st
		}, function() {
			refreshBoard();
			$('#modal').modal('hide');
			$.jGrowl("Status Changed", { header: 'Success', theme:"notification_styled_success" });			
		}, function() {
			alert("error");
		});
}

function refreshBoard(){
	LoadOnDiv("/Tasks/FromStatus/3", "#list-wip");
	LoadOnDiv("/Tasks/FromStatus/2", "#list-todo");
	LoadOnDiv("/Tasks/FromStatus/1", "#list-backlog");
	LoadOnDiv("/Tasks/FromStatus/4", "#list-hold");
	LoadOnDiv("/Tasks/FromStatus/6", "#list-homolog");
	LoadOnDiv("/Tasks/FromStatus/5", "#list-done");
}
