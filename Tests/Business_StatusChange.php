<?php

	SimpleTest::prefer(new TextReporter());
	include_once("_tests.php");
	include_once("Setup.php");

	echo "testing Business status change - environment: ".MagratheaConfig::Instance()->GetEnvironment()."<br/>";

	class TestBusiness extends UnitTestCase {

		function setUp(){
		}
		function tearDown(){
		}

		function testCreateStatusChange(){
			$t1 = new Task();
			$t1->title = "Tests";
			$t1->text = "make tests for everything";
			$t1->Insert();

			$t1->ChangeStatus(Status::Get("to-do"));
			$t1->ChangeStatus(Status::Get("wip"));

			$history = $t1->GetHistory();
			$this->assertEqual(2, count($history));

		}

	}

?>