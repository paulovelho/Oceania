function updateList() {
	LoadOnDiv("/Tasks/ShowList", "#taskList");	
}

function submitAddTask() {
	submitForm("#add-task", "/Tasks/Add", 
		function(){
			updateList();
			$.colorbox.close();
			$.jGrowl("Task Added", { header: 'Success', theme:"notification_styled_success" });			
		}, function() {
			alert("error!");
		});
	return false;
}

function viewTask(id) {
	$.colorbox({ href: "Tasks/Show/" + id });
}

function addTask(){
	$.colorbox({ href: "/Tasks/ShowAdd" });	
}

function changeStatus(task_id, status) {
	st = $(status).val();
	postData("/Tasks/ChangeStatus", {
			task_id: task_id,
			status_id: st
		}, function() {
			updateList();
			$.colorbox.close();
			$.jGrowl("Status Changed", { header: 'Success', theme:"notification_styled_success" });			
		}, function() {
			alert("error");
		});
}
