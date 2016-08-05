<?php

	SimpleTest::prefer(new TextReporter());
	include_once("_tests.php");
	include_once("Setup.php");

	echo "testing Tasks - environment: ".MagratheaConfig::Instance()->GetEnvironment()."<br/>";

	class TestTask extends UnitTestCase {

		private $wControl;
		function setUp(){
			$this->tControl = new TaskControl();
		}
		function tearDown(){
		}

		function insertExtraTasks(){
			$this->insertTask(2, 1, "task1", "", 1);
			$this->insertTask(2, 1, "task2", "", 1);
			$this->insertTask(2, 1, "task3", "", 2);
			$this->insertTask(2, 1, "task4", "", 3);
		}

		function insertTask($project_id, $work_id, $title, $text, $status=null){
			$t = new Task();
			$t->title = $title;
			$t->text = $text;
			$t->project_id = $project_id;
			$t->work_id = $work_id;
			$t->user_id = $project_id;
			if( !empty($status) ){
				$t->status_id = $status;
			}
			$this->assertNull($t->id);
			$t->Insert();
			$this->assertNotNull($t->id);
			return $t;
		}

		function addTask($work_id, $title, $text){
			return $this->insertTask(1, $work_id, $title, $text);
		}

		function testIfTaskCanBeCreated(){
			echo "<br/> testing creating task...";
			$task = $this->addTask(1, "Voar", "Aprender a voar");
			$this->assertEqual(1, $task->Status->id);
		}

		function testGeListOfTasks(){
			echo "<br/> testing getting list of tasks...";
			$this->addTask(1, "capitão gancho", 'formar a personalidade do \"capitão\"');
			$this->addTask(1, "músicas", 'preparar músicas');
			$work = new Work(1);
			$this->assertEqual(3, count($work->Tasks));
		}

		function testIfCanGetWork(){
			echo "<br/> testing getting work...";
			$task = new Task(2);
			$this->assertEqual("Peter Pan", $task->Work->title);
		}

		function testSearchTask(){
			echo "<br/> testing tasks searching...";
			$rs1 = $this->tControl->Search("capitao");
			$w1 = $rs1[0];
			$this->assertEqual("capitão gancho", $w1->title);
		}

		function testGetTasksFromProject(){
			echo "<br/> testing getting tasks from project...";
			$project = new Project(1);
			$tasks = $project->Tasks;
			$this->assertEqual(3, count($tasks));
		}

		function testGetTasksFromWork(){
			echo "<br/> testing getting tasks from work...";
			$work = new Work(1);
			$tasks = $work->Tasks;
			$this->assertEqual(3, count($tasks));
		}

		function testGetFromProjectAndStatus(){
			echo "<br/> testing getting tasks from project and status...";
			$this->insertExtraTasks();
			$tasks_in_1 = $this->tControl->GetFromProjectStatus(2, 1);
			$this->assertEqual(2, count($tasks_in_1));
			$tasks_in_2 = $this->tControl->GetFromProjectStatus(2, 2);
			$this->assertEqual(1, count($tasks_in_2));
		}

	}

?>
