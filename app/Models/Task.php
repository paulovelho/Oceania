<?php

include(__DIR__."/Base/TaskBase.php");

class Task extends TaskBase {
	public function __construct($id=0) {
		parent::__construct($id);
		if(empty($this->status_id)) {
			$this->status_id = 1;
		}
	}

	public function ChangeStatus($st_id) {
		$history = new StatusChange();
		$history->task_id = $this->id;
		$history->old_status = $this->status_id;
		$history->new_status = $st_id;
		$history->timestamp = now();
		$history->Insert();
		$this->status_id = $st_id;
		$this->Update();
	}

	public function GetHistory() {
		return $this->GetStatusChanges();
	}

}

class TaskControl extends TaskControlBase {

	function Search($query) {
		$query = MagratheaQuery::Clean($query);
		$query = MagratheaQuery::Select()
			->Obj(new Task)
			->Where(" title LIKE '%".$query."%' OR text LIKE '%".$query."%' ");
		return self::Run($query);
	}
}

?>