<?php

include(__DIR__."/Base/WorkBase.php");

class Work extends WorkBase {
	public function __construct($id=0) {
		parent::__construct($id);
		if(empty($status_id)) {
			$this->status_id = 1;
			$this->Status = StatusControl::Instance()->Get(1);
		}
	}
}

class WorkControl extends WorkControlBase {

	public static function GetFromProject($project_id) {
		$query = MagratheaQuery::Select()
			->Obj(new Work())
			->Where(array( "project_id" => $project_id ));
		return self::Run($query);
	}

	function Search($query) {
		$query = MagratheaQuery::Clean($query);
		$query = MagratheaQuery::Select()
			->Obj(new Work)
			->Where(" title LIKE '%".$query."%' OR text LIKE '%".$query."%' ");
		return self::Run($query);
	}

}

?>
