function loadWorks() {
	var selected_project = selectedProject();
	LoadOnDiv("/Works/List/" + selected_project, "#work-board");
}

function workForm() {
	LoadOnDiv("/Works/Form/", "#work-form");
}

function saveWork() {
	var selected_project = selectedProject();
	var work_id = $("#work-id").val();
	var title = $("#work-title").val();
	var text = $("#work-text").val();
	postData("/Works/Save", {
		project_id: selected_project,
		work_id: work_id,
		title: title,
		text: text
	}, function(data) {
		console.info(data);
		loadWorks();
		viewWork(data.id);
	}, function(error) {
		console.info(error);
	});
}

function viewWork(id) {
	LoadOnDiv("/Works/View/" + id, "#work-form");
}

function loadTaskList() {
	var work_id = $("#work-id").val();
	LoadOnDiv("/Works/TaskList/" + work_id, "#work-task-list");	
}

function addSingleTaskOnWork() {
	submitForm("#add-task", "/Tasks/Add", 
		function(data){
			console.info(data);
		}, function() {
			alert("error!");
		});

}

function toggleWorkEdit() {
	$("#work-desc").toggle();
	$("#work-desc-edit").toggle();
	$("#work-title-edit").toggle();	
}

function addTaskWork() {
	projectId = $("#sel_project").val();
	modalOpen("/Tasks/NewTask/" + projectId, "New Task", function() {
		var work_id = $("#work-id").val();
		var work_title = $("#work-title").val();
		$("#task-work-id").val(work_id);
		$("#task-work-name").text(work_title);
		$("#task-work-box").show();
	}, function() {
		loadTaskList();
	});
}

function addBulkTasks() {
	var selected_project = selectedProject();
	var work_id = $("#work-id").val();
	var bulk = $("#work-bulk-task").val();
	postData("/Tasks/Bulk", {
		project_id: selected_project,
		work_id: work_id,
		bulk: bulk
	}, function(data) {
		console.info(data);
		loadTaskList();
		$("#form-bulk-task").slideUp();
	}, function(error) {
		console.info(error);
	});

}

