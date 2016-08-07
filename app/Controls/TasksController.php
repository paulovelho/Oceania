<?php

class TasksController extends BaseControl {

	private function Start() {
		$this->assign("title", "Tasks");
		$this->CheckLogin();
	}

	public function Index(){
		$this->Start();
		$this->assign("page", "tasks");
		$this->display("phoenix/oceania.html");
	}

	public function Add() {
		$t = new Task();
		$t->title = $_POST["title"];
		$t->text = $_POST["text"];
		$t->project_id = 1;
		$t->Insert();
		return $this->Json( array('success' => true, 'data' => $t) );
	}

	public function Update() {
		$t = new Task($_POST["id"]);
		$t->title = $_POST["title"];
		$t->text = $_POST["text"];
		$t->project_id = $_POST["project_id"];
		$status = $_POST["status_id"];
		if( $status != $t->status_id ) {
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

	public function FromStatus($id) {
		$status = new Status($id);
		$tasks = $status->GetTasks();
		$this->assign("status", $status);
		$this->assign("tasks", $tasks);
		$this->display("phoenix/tasks/from_status.html");
	}

	public function ShowList() {
		$tasks = TaskControl::GetAll();
//		p_r($tasks);
		$this->assign("tasks", $tasks);
		$this->display("phoenix/tasks/list.html");
	}

	public function NewTask() {
		$task = new Task();
		$proj = new Project(1);
		$this->LoadStatus();
		$this->assign("task", $task);
		$this->assign("project", $proj);
		$this->display("phoenix/tasks/form.html");
	}

	public function Show($id) {
		$t = new Task($id);
		$proj = new Project(1);
		$this->LoadStatus();
		$this->assign("task", $t);
		$this->assign("project", $proj);
		$this->display("phoenix/tasks/form.html");
	}

}

?>
