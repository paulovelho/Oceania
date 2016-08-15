function selectedProject() {
	return $("#sel_project").val();
}

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
			$('#modal').modal('hide');
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
		function(data){
			refreshCards(data.status_id);
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

function viewArchived(){
	var selected_project = $("#sel_project").val();
	window.location.href = "/Tasks/Archived/" + selected_project;
}

function addTask(){
	$(".modal-title").html("New Task");
	$("#modal").modal({ 
		remote: "/Tasks/NewTask" 
	});
	$("#modal").on("shown", function() {
		var sel_project = selectedProject();
		$("#task_project_id").val(sel_project);
		$("#modal").off("shown");
	});
}

function addTaskStatus(status_id) {
	$(".modal-title").html("New Task");
	$("#modal").modal({ 
		remote: "/Tasks/NewTask" 
	});
	$("#modal").on("shown", function() {
		var sel_project = selectedProject();
		$("#task_project_id").val(sel_project);
		$("#task_status_id").val(status_id);
		$("#modal").off("shown");
	});	
}

function changeStatus(task_id, status_id, callback) {
	postData("/Tasks/ChangeStatus", {
			task_id: task_id,
			status_id: status_id
		}, function() {
			$('#modal').modal('hide');
			$.jGrowl("Status Changed", { header: 'Success', theme:"notification_styled_success" });
			if( callback ) {
				callback();
			}
		}, function() {
			alert("error");
		});
}

function sortTasks() {
	var elements = "#task-list-1, #task-list-2, #task-list-3, #task-list-4, #task-list-5, #task-list-6, #task-list-7";
	$(elements).sortable("destroy");
	$(elements).sortable({
		connectWith: ".sortable",
		cursor: "move",
		placeholder: "task-card",
		receive: function(event, ui) {
			var target_status = $(event.target).attr("data-status-id");
			var task_id = $(ui.item[0]).attr("data-task-id");
			changeStatus(task_id, target_status);
		}
	});
}

function refreshCards(id, button) {
	var sort = function(){ sortTasks(); }
	var selected_project = selectedProject();
	LoadOnDiv("/Tasks/GetCards/" + id + ";" + selected_project, "#task-list-" + id, sort);
	if(button) $(button).fadeOut();
}

function refreshBoard(){
	var sort = function(){ sortTasks(); }
	var selected_project = selectedProject();
	LoadOnDiv("/Tasks/GetWip/" + selected_project, "#list-wip", sort);
	LoadOnDiv("/Tasks/GetTodo/" + selected_project, "#list-todo", sort);
	LoadOnDiv("/Tasks/GetHomolog/" + selected_project, "#list-homolog", sort);

	LoadOnDiv("/Tasks/GetLazyBox/1", "#list-backlog", sort);
	LoadOnDiv("/Tasks/GetLazyBox/4", "#list-hold", sort);
	LoadOnDiv("/Tasks/GetDoneBox", "#list-done", sort);
}
