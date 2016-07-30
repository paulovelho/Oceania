<?php

## FILE GENERATED BY MAGRATHEA.
## SHOULD NOT BE CHANGED MANUALLY

class TaskBase extends MagratheaModel implements iMagratheaModel {

	public $id, $project_id, $parent_task_id, $work_id, $title, $text, $cost, $status_id, $user_id, $creator_id;
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
		$this->dbTable = "tasks";
		$this->dbPk = "id";
		$this->dbValues["id"] = "int";
		$this->dbValues["project_id"] = "int";
		$this->dbValues["parent_task_id"] = "int";
		$this->dbValues["work_id"] = "int";
		$this->dbValues["title"] = "string";
		$this->dbValues["text"] = "text";
		$this->dbValues["cost"] = "float";
		$this->dbValues["status_id"] = "int";
		$this->dbValues["user_id"] = "int";
		$this->dbValues["creator_id"] = "int";

		$this->relations["properties"]["Project"] = null;
		$this->relations["methods"]["Project"] = "GetProject";
		$this->relations["lazyload"]["Project"] = "false";
		$this->relations["properties"]["Work"] = null;
		$this->relations["methods"]["Work"] = "GetWork";
		$this->relations["lazyload"]["Work"] = "false";
		$this->relations["properties"]["ParentTask"] = null;
		$this->relations["methods"]["ParentTask"] = "GetParentTask";
		$this->relations["lazyload"]["ParentTask"] = "false";
		$this->relations["properties"]["Tasks"] = null;
		$this->relations["methods"]["Tasks"] = "GetTasks";
		$this->relations["lazyload"]["Tasks"] = "true";
		$this->relations["properties"]["User"] = null;
		$this->relations["methods"]["User"] = "GetUser";
		$this->relations["lazyload"]["User"] = "false";
		$this->relations["properties"]["Creator"] = null;
		$this->relations["methods"]["Creator"] = "GetCreator";
		$this->relations["lazyload"]["Creator"] = "false";
		$this->relations["properties"]["StatusChanges"] = null;
		$this->relations["methods"]["StatusChanges"] = "GetStatusChanges";
		$this->relations["lazyload"]["StatusChanges"] = "true";
		$this->relations["properties"]["Status"] = null;
		$this->relations["methods"]["Status"] = "GetStatus";
		$this->relations["lazyload"]["Status"] = "false";

		$this->dbAlias["created_at"] =  "datetime";
		$this->dbAlias["updated_at"] =  "datetime";
	}

	// >>> relations:
	public function GetProject(){
		if($this->relations["properties"]["Project"] != null) return $this->relations["properties"]["Project"];
		$this->relations["properties"]["Project"] = new Project($this->project_id);
		return $this->relations["properties"]["Project"];
	}
	public function SetProject($project){
		$this->relations["properties"]["Project"] = $project;
		$this->project_id = $project->GetID();
		return $this;
	}
	public function GetWork(){
		if($this->relations["properties"]["Work"] != null) return $this->relations["properties"]["Work"];
		$this->relations["properties"]["Work"] = new Work($this->work_id);
		return $this->relations["properties"]["Work"];
	}
	public function SetWork($work){
		$this->relations["properties"]["Work"] = $work;
		$this->work_id = $work->GetID();
		return $this;
	}
	public function GetParentTask(){
		if($this->relations["properties"]["ParentTask"] != null) return $this->relations["properties"]["ParentTask"];
		$this->relations["properties"]["ParentTask"] = new Task($this->parent_task_id);
		return $this->relations["properties"]["ParentTask"];
	}
	public function SetParentTask($parenttask){
		$this->relations["properties"]["ParentTask"] = $parenttask;
		$this->parent_task_id = $parenttask->GetID();
		return $this;
	}
	public function GetTasks(){
		if($this->relations["properties"]["Tasks"] != null) return $this->relations["properties"]["Tasks"];
		$pk = $this->dbPk;
		$this->relations["properties"]["Tasks"] = TaskControlBase::GetWhere(array("parent_task_id" => $this->$pk));
		return $this->relations["properties"]["Tasks"];
	}
	public function GetUser(){
		if($this->relations["properties"]["User"] != null) return $this->relations["properties"]["User"];
		$this->relations["properties"]["User"] = new User($this->user_id);
		return $this->relations["properties"]["User"];
	}
	public function SetUser($user){
		$this->relations["properties"]["User"] = $user;
		$this->user_id = $user->GetID();
		return $this;
	}
	public function GetCreator(){
		if($this->relations["properties"]["Creator"] != null) return $this->relations["properties"]["Creator"];
		$this->relations["properties"]["Creator"] = new User($this->creator_id);
		return $this->relations["properties"]["Creator"];
	}
	public function SetCreator($creator){
		$this->relations["properties"]["Creator"] = $creator;
		$this->creator_id = $creator->GetID();
		return $this;
	}
	public function GetStatusChanges(){
		if($this->relations["properties"]["StatusChanges"] != null) return $this->relations["properties"]["StatusChanges"];
		$pk = $this->dbPk;
		$this->relations["properties"]["StatusChanges"] = StatusChangeControlBase::GetWhere(array("task_id" => $this->$pk));
		return $this->relations["properties"]["StatusChanges"];
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

class TaskControlBase extends MagratheaModelControl {
	protected static $modelName = "Task";
	protected static $dbTable = "tasks";
}
?>