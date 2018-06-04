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

	public static function GetActiveTasks($status_id) {
		$query = MagratheaQuery::Select()
			->Obj(new Task())
			->HasOne(new Project(), "project_id")
			->Where( array( "projects.active" => 1, "tasks.status_id" => $status_id) );
		return self::Run($query);
	}

	function GetFromProjectStatus($project_id, $status_id){
		$query = MagratheaQuery::Select()
			->Obj(new Task())
			->Where(array( "project_id" => $project_id, "status_id" => $status_id) );
		return self::Run($query);
	}

	function ArchiveDoneFromProject($project_id) {
		$done = Statuses::Get("done");
		$archived = Statuses::Get("archived");
		$query = MagratheaQuery::Update()
			->Obj(new Task())
			->Set("status_id", $archived->id)
			->Where(array(
				"project_id" => $project_id, 
				"status_id" => $done->id
			));
		return $this->Run($query);
	}

	public static function WorkOnTask($taskId) {
		$query = MagratheaQuery::Update()
			->Obj(new Task())
			->SetRaw("cost = cost + 1")
			->Where(array( "id" => $taskId ));
		return self::Run($query);
	}

}

?>
