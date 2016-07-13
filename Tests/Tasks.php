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

		function addTask($work_id, $title, $text){
			$t = new Task();
			$t->title = $title;
			$t->text = $text;
			$t->project_id = 1;
			$t->work_id = $work_id;
			$t->user_id = 1;
			$this->assertNull($t->id);
			$t->Insert();
			$this->assertNotNull($t->id);
			return $t;
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
			echo "<br/> testing getting tasks from project...";
			$work = new Work(1);
			$tasks = $work->Tasks;
			$this->assertEqual(3, count($tasks));
		}

	}

?>