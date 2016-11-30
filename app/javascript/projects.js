function projectsList() {
	LoadOnDiv("/Projects/ShowList", "#projectsList");
}

function addProject(){
	LoadOnDiv("/Projects/NewProject", "#projectsDetails");
}

function saveProject() {
	var id = $("#add-project #project-id").val();
	if(id > 0) updateProject();
	else insertProject();
	return false;
}

function insertProject() {
	console.info("inserting project");
	submitForm("#add-project", "/Projects/Add", 
		function(){
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
			$("#projectsDetails").html("");
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

function viewProject(id) {
	LoadOnDiv("/Projects/Show/"+id, "#projectsDetails");
}


