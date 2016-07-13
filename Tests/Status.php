<?php

	SimpleTest::prefer(new TextReporter());
	include_once("_tests.php");

	echo "testing status - environment: ".MagratheaConfig::Instance()->GetEnvironment()."<br/>";

	class TestStatus extends UnitTestCase {
		function setUp(){ }
		function tearDown(){ }

		function testGetAll(){
			echo "<br/> testing getting all...";
			$all = StatusControl::Instance()->status;
			$this->assertEqual(7, count($all));
		}

		function testGetOne(){
			echo "<br/> testing getting specific status...";
			$pending = Status::Get(1);
			$this->assertNotNull($pending);
			$this->assertEqual("pending", $pending->name);
			$todo = Status::Get("to-do");
			$this->assertNotNull($todo);
			$this->assertEqual("2", $todo->id);
		}

		function saveColor(){
			$done = new Status("done");
			$done->color = "#66ff33";
			$done->Save();

			$wcDone = new Status(6);
			$this->assertEqual("#66ff33", $wcDone->color);
		}

	}

	class TestStatusControl extends UnitTestCase {
		function setUp(){ }
		function tearDown(){ }

		function randomColor() {
			return sprintf('#%06X', mt_rand(0, 0xFFFFFF));
		}

		function testInstance(){
			echo "<br/> testing instance...";
			$control = StatusControl::Instance();
			$this->assertNotNull($control);
		}

		function testInstanceHasRightData() {
			echo "<br/> testing instance has right data...";
			$control = StatusControl::Instance();
			$this->assertEqual(7, count($control->status));
		}

		function testGetStatus(){
			echo "<br/> testing getting status...";
			$st1 = StatusControl::Instance()->GetByName("done");
			$this->assertEqual(6, $st1->id);
			$st2 = StatusControl::Instance()->GetById(3);
			$this->assertEqual("wip", $st2->name);
			$st3 = StatusControl::Instance()->Get("pending");
			$this->assertEqual(1, $st3->id);
			$st3 = StatusControl::Instance()->Get(5);
			$this->assertEqual("homolog", $st3->name);
		}

		function testUpdates(){
			echo "<br/> testing update list of status...";
			$randColor = $this->randomColor();
			$arch = StatusControl::Instance()->Get("archived");
			$oldColor = $arch->color;
			$arch->color = $randColor;
			$arch->Update();

			$archAgain = StatusControl::Instance()->Get(7);
			$this->assertEqual($randColor, $archAgain->color);

		}

	}

?>