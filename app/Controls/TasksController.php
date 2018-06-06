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
		$t->work_id = @intval($_POST["work_id"]);
		$t->expectation = @intval($_POST["expectation"]);
		$t->cost = 0;
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
		$t->work_id = @intval($_POST["work_id"]);
		$t->expectation = @intval($_POST["expectation"]);
		if(empty($t->cost)) {
			$t->cost = 0;
		}
		$status = @$_POST["status_id"];
		if( $status > 0 && $status != $t->status_id ) {
			$t->ChangeStatus($status);
		}
		$t->Save();
		return $this->Json( array('success' => true, 'data' => $t) );
	}

	public function Bulk() {
		$project = $_POST["project_id"];
		$work = $_POST["work_id"];
		$bulk = $_POST["bulk"];
		$tasks = explode(PHP_EOL, $bulk);
		$currentTask = false;
		foreach ($tasks as $t) {
			$t = trim($t);
			if(strlen($t) == 0) continue;
			$fChar = substr($t, 0, 1);
			switch ($fChar) {
				case '=':
					if($currentTask->text == null) {
						$currentTask->text = "";
					}
					$currentTask->text .= substr($t, 2)."\n";
					break;
				case '-':
				default:
					if($currentTask != false) {
						$currentTask->Insert();
					}
					$currentTask = new Task();
					$currentTask->cost = 0;
					$currentTask->work_id = $work;
					$currentTask->project_id = $project;

					$title = substr($t, 2);
					$title = explode('+', $title);

					$hours = array_values(array_slice($title, -1))[0];
					$lastChars = substr($t, -2);
					if ($lastChars == 'h-') {
						$hour = substr($hours, 0, -2);
						$currentTask->expectation = $hour;
					}

					$fTitle = substr($t, 0, (0 - strlen($hours) - 1));
					$fTitle = substr($fTitle, 2);
					if($currentTask->title == null) {
						$currentTask->title = "";
					}
					$currentTask->title .= $fTitle;
					break;
			}
		}
		if ($currentTask != false) {
			$currentTask->Insert();
		}
		return $this->Json( array('success' => true, 'data' => null) );
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

	public function NewTask($project_id=0) {
		$task = new Task();
		$this->LoadStatus();
		$this->assign("task", $task);
		if (!empty($project_id)) {
			$this->assign("project", new Project($project_id));
		}
		$this->assign("projects", $this->LoadProjects());
		$this->display("phoenix/tasks/form.html");
	}

	public function Show($id) {
		$t = new Task($id);
		$this->LoadStatus();
		$this->assign("task", $t);
		$this->assign("project", $t->GetProject());
		$this->display("phoenix/tasks/form.html");
	}

	public function Open($id) {
		$this->CheckLogin();

		$t = new Task($id);
		$this->assign("title", $t->title);

		$this->LoadStatus();
		$this->assign("task", $t);
		$this->assign("projects", $this->LoadAllProjects());
		$this->assign("page", "task/view");
		$this->display("phoenix/oceania.html");
	}

	public function ArchiveAll($project_id){
		if(empty($project_id)) {
			return $this->Json( array('success' => false, 'error' => "incorrect project id") );
		}
		$tControl = new TaskControl();
		$tControl->ArchiveDoneFromProject($project_id);
		return $this->Json( array('success' => true) );
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

	public function Work($task_id) {
		$q = TaskControl::WorkOnTask($task_id);
		return $this->Json( array('success' => true) );
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

	public function GetHomologWaiting($project_id) {
		$homolog = Statuses::Get("homolog");
		$waiting = Statuses::Get("on-hold");
		$this->assign("homolog", $homolog);
		$this->assign("waiting", $waiting);
		$this->display("phoenix/tasks/status_homolog_waiting.html");
	}

	public function GetTasksFromProjectStatus($project_id, $status_id) {
		$tControl = new TaskControl();
		return $tControl->GetFromProjectStatus($project_id, $status_id);
	}

}

?>
