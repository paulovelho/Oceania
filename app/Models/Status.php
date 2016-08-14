<?php

include(__DIR__."/Base/StatusBase.php");

class Status extends StatusBase {
	function __construct($st=0) {
		if(is_numeric($st)){
			parent::__construct($st);
		} else {
			return StatusControl::Instance()->GetByName($st);
		}
	}

	function Save(){
		parent::Save();
		StatusControl::Instance()->Refresh();
	}

	function Insert(){
		parent::Insert();
		StatusControl::Instance()->Refresh();
	}

	function Update(){
		parent::Update();
		StatusControl::Instance()->Refresh();
	}
}

class Statuses {

	public static function Get($st){
		return StatusControl::Instance()->Get($st);
	}

	public static function GetAll() {
		return StatusControl::Instance()->status;
	}

}

class StatusControl extends StatusControlBase {

	public $status = null;
	private $arrStNames = null;

	protected static $instance = null;

	public static function Instance(){
		if(!isset(self::$instance)){
			self::$instance = new StatusControl();
		}
		return self::$instance;
	}

	private function __construct() {
		$this->Refresh();
	}

	public function Refresh(){
		$allSt = $this->GetAll();
		foreach ($allSt as $st) {
			$this->status[$st->id] = $st;
			$this->arrStNames[$st->name] = $st->id;
		}
	}

	public function GetByName($name) {
		return @$this->status[$this->arrStNames[$name]];
	}

	public function GetById($id){
		return $this->status[$id];
	}

	public function Get($st){
		if(is_int($st)){
			return $this->GetById($st);
		} else {
			return $this->GetByName($st);
		}
	}

}

?>