<?php

class TasksController extends BaseControl {

	private function Start() {
		$this->assign("title", "Tasks");
		$this->CheckLogin();
	}

	public function Index(){
		$this->Start();
		$this->assign("page", "tasks/index");
		$projects = $this->LoadProjects();
		$projects[0] = "- - - ALL - - -";
		$this->assign("projects", $projects);
		$this->display("phoenix/oceania.html");
	}

	public function Add() {
		$t = new Task();
		$t->title = $_POST["title"];
		$t->text = $_POST["text"];
		$t->project_id = $_POST["project_id"];
		$t->Insert();
		$status = @$_POST["status_id"];
		if( $status > 0 && $status != $t->status_id ) {
			$t->ChangeStatus($status);
		}
		$t->Save();
		return $this->Json( array('success' => true, 'data' => $t) );
	}

	public function Update() {
		$t = new Task($_POST["id"]);
		$t->title = $_POST["title"];
		$t->text = $_POST["text"];
		$t->project_id = $_POST["project_id"];
		$status = @$_POST["status_id"];
		if( $status > 0 && $status != $t->status_id ) {
			$t->ChangeStatus($status);
		}
		$t->Save();
		return $this->Json( array('success' => true, 'data' => $t) );
	}

	public function DeleteTask() {
		$t = new Task($_POST["id"]);
		$t->Delete();
		return $this->Json( array('success' => true, 'data' => null) );
	}

	public function ChangeStatus() {
		$id = $_POST["task_id"];
		$status = $_POST["status_id"];
		$t = new Task($id);
		$t->ChangeStatus($status);
		return $this->Json( array('success' => true, 'data' => $t) );
	}

	public function GetLazyBox($id) {
		$status = new Status($id);
		$this->assign("status", $status);
		$this->display("phoenix/tasks/status_lazy.html");
	}

	public function GetDoneBox() {
		$done = Statuses::Get("done");
		$archived = Statuses::Get("archived");
		$this->assign("done", $done);
		$this->assign("archived", $archived);
		$this->display("phoenix/tasks/status_done.html");
	}

	public function GetCards($query){
		$q = explode(";", $query);
		$status_id = $q[0];
		$project_id = $q[1];
		$status = new Status($status_id);
		if($project_id > 0)
			$tasks = $this->GetTasksFromProjectStatus($project_id, $status->id);
		else 
			$tasks = $status->GetTasks();
		$this->assign("tasks", $tasks);
		$this->display("phoenix/tasks/card-list.html");
	}

	public function ShowList() {
		$tasks = TaskControl::GetAll();
		$this->assign("tasks", $tasks);
		$this->display("phoenix/tasks/list.html");
	}

	public function NewTask() {
		$task = new Task();
		$this->LoadStatus();
		$this->assign("task", $task);
		$this->assign("projects", $this->LoadProjects());
		$this->display("phoenix/tasks/form.html");
	}

	public function Show($id) {
		$t = new Task($id);
		$this->LoadStatus();
		$this->assign("task", $t);
		$this->assign("projects", $this->LoadProjects());
		$this->display("phoenix/tasks/form.html");
	}

	public function Archived($project_id){
		$this->Start();
		$this->assign("title", "Archived Tasks");
		$archived = Statuses::Get("archived");
		$tasks = null;
		if(!empty($project_id)) {
			$tasks = $this->GetTasksFromProjectStatus($project_id, $archived->id);
		} else {
			$tasks = $archived->GetTasks();
		}
		$this->assign("tasks", $tasks);
		$this->assign("page", "tasks/list");
		$this->display("phoenix/oceania.html");
	}


	// logic for displaying the box
	private function StatusBoxDisplay($status, $project) {
		$this->assign("status", $status);
		$tasks = null;
		if(!empty($project))
			$tasks = $this->GetTasksFromProjectStatus($project, $status->id);
		else 
			$tasks = $status->GetActiveTasks();
		$this->assign("tasks", $tasks);
		$this->display("phoenix/tasks/status_box.html");
	}


	public function GetStatus($id) {
		$status = new Status($id);
		$this->StatusBoxDisplay($status, $project_id);
	}

	public function GetWip($project_id) {
		$status = Statuses::Get("wip");
		$this->StatusBoxDisplay($status, $project_id);
	}

	public function GetTodo($project_id) {
		$status = Statuses::Get("to-do");
		$this->StatusBoxDisplay($status, $project_id);
	}

	public function GetHomolog($project_id) {
		$status = Statuses::Get("homolog");
		$this->StatusBoxDisplay($status, $project_id);
	}

	public function GetTasksFromProjectStatus($project_id, $status_id) {
		$tControl = new TaskControl();
		return $tControl->GetFromProjectStatus($project_id, $status_id);
	}

}

?>
