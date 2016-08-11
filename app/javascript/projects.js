function projectsList() {
	LoadOnDiv("/Projects/ShowList", "#projectsList");	
}

function addProject(){
	$(".modal-title").html("New Project");
	$("#modal").modal({ remote: "/Projects/NewProject" });
}

function saveProject() {
	var id = $("#add-project #project-id").val();
	if(id > 0) updateProject();
	else insertProject();
	return false;
}

function insertProject() {
	submitForm("#add-project", "/Projects/Add", 
		function(){
			projectsList();
			$('#modal').modal('hide');
			$.jGrowl("Project Added", { header: 'Success', theme:"notification_styled_success" });			
		}, function() {
			alert("error!");
		});
}

function updateProject() {
	var title = $("#add-project #name").val();
	submitForm("#add-project", "/Projects/Update", 
		function(){
			projectsList();
			$('#modal').modal('hide');
			$.jGrowl("Project " + title + " Updated", { header: 'Success', theme:"notification_styled_success" });			
		}, function() {
			alert("error!");
		});
}

function deleteProject() {
	var title = $("#add-project #name").val();
	var just_go = confirm("do you really wish to delete project " + title + "?");
	if( !just_go )
		return false;
	submitForm("#add-project", "/Projects/DeleteProject",
		function(){
			projectsList();
			$('#modal').modal('hide');
			$.jGrowl("Project " + title + " Deleted", { header: 'Success', theme:"notification_styled_success" });			
		}, function() {
			alert("error!");
		});
	return false;
}

function viewProject(id, title) {
	if(title == null) title = "Project";
	$(".modal-title").html(title);
	$("#modal").modal({ remote: "/Projects/Show/" + id });
}


