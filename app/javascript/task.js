function saveTask() {
	var id = $("#add-task #task-id").val();
	if(id > 0) updateTask();
	else insertTask();
	modalClose();
	return false;
}

function insertTask() {
	submitForm("#add-task", "/Tasks/Add", 
		function(data){
			refreshCards(data.status_id);
			addTask();
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
			markdownIt();
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
			console.info(data.data);
			refreshCards(data.status_id);
			modalClose();
			$.jGrowl("Task " + title + " Deleted", { header: 'Success', theme:"notification_styled_success" });			
		}, function() {
			alert("error!");
		});
	return false;
}

function toggleEdit() {
	$("#task-desc").toggle();
	$("#task-desc-edit").toggle();
	$("#task-title-edit").toggle();
}

function workOnTask(task_id) {
	var hElement = $("#cost-for-" + task_id);
	var h = parseInt(hElement.html());
	hElement.html("...");
	postData("/Tasks/Work/" + task_id, {}, function(data) {
		console.info(data);
		hElement.html(h + 1);
	}, function(error) {
		console.info(error);
	});
}
