<?php

## FILE GENERATED BY MAGRATHEA.
## SHOULD NOT BE CHANGED MANUALLY

class StatusBase extends MagratheaModel implements iMagratheaModel {

	public $id, $name, $color, $icon;
	public $created_at, $updated_at;
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
		$this->dbTable = "stats";
		$this->dbPk = "id";
		$this->dbValues["id"] = "int";
		$this->dbValues["name"] = "string";
		$this->dbValues["color"] = "string";
		$this->dbValues["icon"] = "string";

		$this->relations["properties"]["Projects"] = null;
		$this->relations["methods"]["Projects"] = "GetProjects";
		$this->relations["lazyload"]["Projects"] = "true";
		$this->relations["properties"]["OldStatusChanges"] = null;
		$this->relations["methods"]["OldStatusChanges"] = "GetOldStatusChanges";
		$this->relations["lazyload"]["OldStatusChanges"] = "true";
		$this->relations["properties"]["NewStatusChanges"] = null;
		$this->relations["methods"]["NewStatusChanges"] = "GetNewStatusChanges";
		$this->relations["lazyload"]["NewStatusChanges"] = "true";
		$this->relations["properties"]["Works"] = null;
		$this->relations["methods"]["Works"] = "GetWorks";
		$this->relations["lazyload"]["Works"] = "true";
		$this->relations["properties"]["Tasks"] = null;
		$this->relations["methods"]["Tasks"] = "GetTasks";
		$this->relations["lazyload"]["Tasks"] = "true";

		$this->dbAlias["created_at"] =  "datetime";
		$this->dbAlias["updated_at"] =  "datetime";
	}

	// >>> relations:
	public function GetProjects(){
		if($this->relations["properties"]["Projects"] != null) return $this->relations["properties"]["Projects"];
		$pk = $this->dbPk;
		$this->relations["properties"]["Projects"] = ProjectControlBase::GetWhere(array("status_id" => $this->$pk));
		return $this->relations["properties"]["Projects"];
	}
	public function GetOldStatusChanges(){
		if($this->relations["properties"]["OldStatusChanges"] != null) return $this->relations["properties"]["OldStatusChanges"];
		$pk = $this->dbPk;
		$this->relations["properties"]["OldStatusChanges"] = StatusChangeControlBase::GetWhere(array("old_status" => $this->$pk));
		return $this->relations["properties"]["OldStatusChanges"];
	}
	public function GetNewStatusChanges(){
		if($this->relations["properties"]["NewStatusChanges"] != null) return $this->relations["properties"]["NewStatusChanges"];
		$pk = $this->dbPk;
		$this->relations["properties"]["NewStatusChanges"] = StatusChangeControlBase::GetWhere(array("new_status" => $this->$pk));
		return $this->relations["properties"]["NewStatusChanges"];
	}
	public function GetWorks(){
		if($this->relations["properties"]["Works"] != null) return $this->relations["properties"]["Works"];
		$pk = $this->dbPk;
		$this->relations["properties"]["Works"] = WorkControlBase::GetWhere(array("status_id" => $this->$pk));
		return $this->relations["properties"]["Works"];
	}
	public function GetTasks(){
		if($this->relations["properties"]["Tasks"] != null) return $this->relations["properties"]["Tasks"];
		$pk = $this->dbPk;
		$this->relations["properties"]["Tasks"] = TaskControlBase::GetWhere(array("status_id" => $this->$pk));
		return $this->relations["properties"]["Tasks"];
	}

}

class StatusControlBase extends MagratheaModelControl {
	protected static $modelName = "Status";
	protected static $dbTable = "stats";
}
?>