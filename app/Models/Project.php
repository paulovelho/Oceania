<?php

include(__DIR__."/Base/ProjectBase.php");

class Project extends ProjectBase {
	public function Start() {
		$this->start_date = now();
	}
	public function Finish() {
		$s = Statuses::Get("done");
		$this->SetStatus($s);
		$this->end_date = now();
	}

}

class ProjectControl extends ProjectControlBase {
	function Search($query) {
		$query = MagratheaQuery::Clean($query);
		$query = MagratheaQuery::Select()
			->Obj(new Project)
			->Where(" name LIKE '%".$query."%' ");
		return self::Run($query);
	}
}

?>