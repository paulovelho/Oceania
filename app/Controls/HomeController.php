<?php

class HomeController extends BaseControl {

	private function Start() {
		$this->assign("title", "Oceania");
		$this->CheckLogin();
	}

	public function Index(){
		$this->Start();
		$this->Load("Tasks", "Index");
	}

}

?>
