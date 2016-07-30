<?php

class TasksController extends BaseControl {

	private function Start() {
		$this->assign("title", "Tasks");
		$this->assign("selected", "tasks");
		$this->CheckLogin();
	}

	public function Index(){
		$this->Start();
		$this->assign("page", "tasks/index");
		$this->display("phoenix/oceania.html");
	}

	public function Add() {
		$t = new Task();
		$t->title = $_POST["title"];
		$t->text = $_POST["text"];
		$t->project_id = 1;
		$t->Insert();
		return $this->Json( array('success' => true, 'data' => $t));
	}

	public function ShowList() {
		$tasks = TaskControl::GetAll();
		$this->assign("tasks", $tasks);
		$this->display("phoenix/tasks/list.html");
	}

	public function ShowAdd() {
		$proj = new Project(1);
		$this->assign("project", $proj);
		$this->display("phoenix/tasks/form.html");
	}

}

?>
