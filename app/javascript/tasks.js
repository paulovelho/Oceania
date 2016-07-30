function submitAddTask() {
	submitForm("#add-task", "/Tasks/Add", 
		function(){
			LoadOnDiv("/Tasks/ShowList", "#taskList");
			alert("success!");
		}, function() {
			alert("error!");
		});
	return false;
}