<?php

class InstallController extends MagratheaController {

	private function Start() {
		MagratheaDebugger::Instance()->SetType(MagratheaDebugger::DEBUG)->LogQueries(true);
		$this->assign("page_title", "Login");
	}

	public function Index(){
		$this->Start();
	}

	public function Project() {
		$this->Start();
		$p = new Project();
		$p->name = "Oceania";
		$p->id = 1;
		$p->Insert();
	}

	public function User() {
		$this->Start();
		$usr = new User();
		$usr->name = "Paulo Martins";
		$usr->email = "paulovelho@paulovelho.com";
		$usr->SetPassword("12345678");
		$usr->Insert();
	}

	public function Status() {
		$this->Start();
		$sql = "TRUNCATE TABLE stats";
		MagratheaDatabase::Instance()->Query($sql);
		$st = new Status();
		$st->name = "backlog";
		$st->Insert();
		$st = new Status();
		$st->name = "to-do";
		$st->Insert();
		$st = new Status();
		$st->name = "wip";
		$st->Insert();
		$st = new Status();
		$st->name = "on-hold";
		$st->Insert();
		$st = new Status();
		$st->name = "homolog";
		$st->Insert();
		$st = new Status();
		$st->name = "done";
		$st->Insert();
		$st = new Status();
		$st->name = "archived";
		$st->Insert();		
	}

}

?>
