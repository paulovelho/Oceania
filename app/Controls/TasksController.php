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

}

?>
