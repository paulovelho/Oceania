<?php

	SimpleTest::prefer(new TextReporter());
	include_once("_tests.php");
	include_once("Setup.php");

	echo "testing works - environment: ".MagratheaConfig::Instance()->GetEnvironment()."<br/>";

	class TestWork extends UnitTestCase {

		private $wControl;
		function setUp(){
			$this->wControl = new WorkControl();
		}
		function tearDown(){
		}

		function addWork($title, $text){
			$w = new Work();
			$w->title = $title;
			$w->text = $text;
			$w->project_id = 1;
			$w->user_id = 1;
			$this->assertNull($w->id);
			$w->Insert();
			$this->assertNotNull($w->id);
			return $w;
		}

		function testIfWorkCanBeCreated(){
			echo "<br/> testing creating work...";
			$work = $this->addWork("Peter Pan", "Uma aventura na terra do nunca.");
			$this->assertEqual(1, $work->Status->id);
		}

		function testGeListOfWorks(){
			echo "<br/> testing getting list of works...";
			$this->addWork("Bambi", "animação sobre um cervo.");
			$this->addWork("Pinóquio", 'um boneco de madeira que quer ser um menino de "verdade"');
			$this->addWork("A Bela e a Fera", "lindo filme com lindas canções");
			$this->addWork("Branca de Neve e os sete Anões", "Uma princesa e uma maçã envenenada...");
			$all = WorkControl::GetAll();
			$this->assertEqual(5, count($all));
		}

		function testIfCanGetWork(){
			echo "<br/> testing getting work...";
			$bambi = new Work(2);
			$this->assertEqual("Bambi", $bambi->title);
		}

		function testSearchWork(){
			echo "<br/> testing works searching...";
			$rs1 = $this->wControl->Search("pan");
			$w1 = $rs1[0];
			$this->assertEqual("Peter Pan", $w1->title);
			$rs2 = $this->wControl->Search("madeira");
			$w2 = $rs2[0];
			$this->assertEqual("Pinóquio", $w2->title);
		}

		function testSearchWithStrangeChars(){
			echo "<br/> testing works searching with accents...";
			$rs = $this->wControl->Search("oes");
			$this->assertEqual(2, count($rs));
		}

		function testGetWorksFromProject(){
			echo "<br/> testing getting works from project...";
			$project = new Project(1);
			$works = $project->Works;
			$this->assertEqual(5, count($works));
			$this->assertEqual("pending", $works[2]->Status->name );
		}

	}

?>