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
	}

	public function List() {
		$tasks = TaskControl::GetAll();
		$this->assign("tasks", $tasks);
		$this->display("phoenix/tasks/list.html");
	}

}

?>
