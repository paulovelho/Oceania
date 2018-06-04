<?php

class WorksController extends BaseControl {

	private function Start() {
		$this->assign("title", "Works");
		$this->CheckLogin();
	}

	public function Index(){
		$this->Start();
		$projects = $this->LoadProjects();
		$this->assign("projects", $projects);
		$this->assign("page", "works/index");
		$this->display("phoenix/oceania.html");
	}

	public function ListWorks($project_id) {
		$this->Start();
		$project = new Project($project_id);
		$works = $project->GetWorks();
		$this->assign("project", $project);
		$this->assign("works", $works);
		$this->display("phoenix/works/board.html");
	}

	public function Save() {
		$work_id = @$_POST["work_id"];
		$w = new Work($work_id);
		$w->project_id = $_POST["project_id"];
		$w->title = $_POST["title"];
		$w->text = $_POST["text"];
		$w->status_id = 1;
//		p_r($w);
		try {
			$w->Save();
		} catch (Exception $e) {
			return $this->Json( array('success' => false, "error" => $e) );
		}
		return $this->Json( array('success' => true, 'data' => $w) );
	}

	public function Form($work_id) {
		$work = new Work($work_id);
		$this->assign("work", $work);
		$this->display("phoenix/works/form.html");
	}

	public function View($work_id) {
		$work = new Work($work_id);
		$this->assign("work", $work);
		$this->display("phoenix/works/view.html");
	}

	public function TaskList($work_id) {
		$work = new Work($work_id);
		$this->assign("tasks", $work->GetTasks());
		$this->display("phoenix/works/task-list.html");
	} 

}

?>
