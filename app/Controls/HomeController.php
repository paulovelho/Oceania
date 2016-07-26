<?php

class HomeController extends BaseControl {

	private function Start() {
		$this->assign("title", "Oceania");
		$this->assign("selected", "home");
		$this->CheckLogin();
	}

	public function Index(){
		$this->Start();
		$this->assign("page", "home");
		$this->display("phoenix/oceania.html");
	}

}

?>
