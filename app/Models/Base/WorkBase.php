<?php

## FILE GENERATED BY MAGRATHEA.
## SHOULD NOT BE CHANGED MANUALLY

class WorkBase extends MagratheaModel implements iMagratheaModel {

	public $id, $project_id, $title, $text, $status_id, $user_id;
	public $created_at, $updated_at;
	public $dbPk;
	protected $autoload = null;

	public function __construct(  $id=0  ){ 
		$this->MagratheaStart();
		if( !empty($id) ){
			$pk = $this->dbPk;
			$this->$pk = $id;
			$this->GetById($id);
		}
	}
	public function MagratheaStart(){
		$this->dbTable = "works";
		$this->dbPk = "id";
		$this->dbValues["id"] = "int";
		$this->dbValues["project_id"] = "int";
		$this->dbValues["title"] = "string";
		$this->dbValues["text"] = "text";
		$this->dbValues["status_id"] = "int";
		$this->dbValues["user_id"] = "int";

		$this->relations["properties"]["Tasks"] = null;
		$this->relations["methods"]["Tasks"] = "GetTasks";
		$this->relations["lazyload"]["Tasks"] = "true";
		$this->relations["properties"]["Projects"] = null;
		$this->relations["methods"]["Projects"] = "GetProjects";
		$this->relations["lazyload"]["Projects"] = "false";
		$this->relations["properties"]["Users"] = null;
		$this->relations["methods"]["Users"] = "GetUsers";
		$this->relations["lazyload"]["Users"] = "false";
		$this->relations["properties"]["Status"] = null;
		$this->relations["methods"]["Status"] = "GetStatus";
		$this->relations["lazyload"]["Status"] = "false";

		$this->dbAlias["created_at"] =  "datetime";
		$this->dbAlias["updated_at"] =  "datetime";
	}

	// >>> relations:
	public function GetTasks(){
		if($this->relations["properties"]["Tasks"] != null) return $this->relations["properties"]["Tasks"];
		$pk = $this->dbPk;
		$this->relations["properties"]["Tasks"] = TaskControlBase::GetWhere(array("work_id" => $this->$pk));
		return $this->relations["properties"]["Tasks"];
	}
	public function GetProjects(){
		if($this->relations["properties"]["Projects"] != null) return $this->relations["properties"]["Projects"];
		$this->relations["properties"]["Projects"] = new Project($this->project_id);
		return $this->relations["properties"]["Projects"];
	}
	public function SetProjects($projects){
		$this->relations["properties"]["Projects"] = $projects;
		$this->project_id = $projects->GetID();
		return $this;
	}
	public function GetUsers(){
		if($this->relations["properties"]["Users"] != null) return $this->relations["properties"]["Users"];
		$this->relations["properties"]["Users"] = new User($this->user_id);
		return $this->relations["properties"]["Users"];
	}
	public function SetUsers($users){
		$this->relations["properties"]["Users"] = $users;
		$this->user_id = $users->GetID();
		return $this;
	}
	public function GetStatus(){
		if($this->relations["properties"]["Status"] != null) return $this->relations["properties"]["Status"];
		$this->relations["properties"]["Status"] = new Status($this->status_id);
		return $this->relations["properties"]["Status"];
	}
	public function SetStatus($status){
		$this->relations["properties"]["Status"] = $status;
		$this->status_id = $status->GetID();
		return $this;
	}

}

class WorkControlBase extends MagratheaModelControl {
	protected static $modelName = "Work";
	protected static $dbTable = "works";
}
?>