<?php

class ProjectsController extends BaseControl {

	private function Start() {
		$this->assign("title", "Projects");
		$this->CheckLogin();
	}

	public function Index(){
		$this->Start();
		$this->assign("page", "projects");
		$this->display("phoenix/oceania.html");
	}

	public function Add() {
		$p = new Project();
		$p->name = $_POST["name"];
		$p->Insert();
		return $this->Json( array('success' => true, 'data' => $p) );
	}

	public function Update() {
		$p = new Project($_POST["id"]);
		$p->name = $_POST["name"];
		$p->Save();
		return $this->Json( array('success' => true, 'data' => $p) );
	}

	public function DeleteProject() {
		$p = new Project($_POST["id"]);
		$p->Delete();
		return $this->Json( array('success' => true, 'data' => null) );
	}

	public function NewProject() {
		$p = new Project();
		$this->assign("project", $p);
		$this->display("phoenix/projects/form.html");		
	}

	public function ShowList() {
		$projects = ProjectControl::GetAll();
		$this->assign("projects", $projects);
		$this->display("phoenix/projects/list.html");
	}

	public function Show($id) {
		$proj = new Project($id);
		$this->assign("project", $proj);
		$this->display("phoenix/projects/form.html");
	}

}

?>
