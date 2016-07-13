<?php

	SimpleTest::prefer(new TextReporter());
	include_once("_tests.php");

	echo "testing projects - environment: ".MagratheaConfig::Instance()->GetEnvironment()."<br/>";

	class TestProject extends UnitTestCase {

		public $project_id = 0;

		function setUp(){
		}
		function tearDown(){
		}

		function addProject($movie){
			$p = new Project();
			$p->name = $movie;
			$this->assertNull($p->id);
			$p->Insert();
			$this->assertNotNull($p->id);
		}

		function testIfProjectCanBeCreated() {
			echo "<br/> testing if a project can be created...";
			$p = new Project();
			$p->name = "Bambi";
			$this->assertNull($p->id);
			$p->Save();
			$this->assertNotNull($p->id);
			$this->project_id = $p->id;
			$p->Start();
			$p->Save();
			$this->assertNotNull($p->start_date);
			$p->Finish();
			$p->Save();
			$this->assertNotNull($p->end_date);
			$this->assertEqual("done", $p->Status->name);
		}

		function testIfCanGetProject(){
			echo "<br/> testing if gets project correctly...";
			$pr = new Project($this->project_id);
			$this->assertEqual("Bambi", $pr->name);
		}

		function testGetListOfProjects(){
			echo "<br/> testing GetAll for projects...";
			$this->addProject("Mogli");
			$this->addProject("Mickey");
			$this->addProject("Peter Pan");
			$this->addProject("Branca de Neve e os sete anões");
			$this->addProject("Irmãos petralha");
			$projects = ProjectControl::GetAll();
			$this->assertEqual(6, count($projects));
		}

		function testSearchProject(){
			echo "<br/> testing projects searching...";
			$pControl = new ProjectControl();
			$rs = $pControl->Search("pan");
			$r1 = $rs[0];
			$this->assertEqual("Peter Pan", $r1->name);
			$rs = $pControl->Search("pet");
			$this->assertEqual(2, count($rs));
		}

		function testWithStrangeChars(){
			echo "<br/> testing projects searching with accents...";
			$pControl = new ProjectControl();
			$rs = $pControl->Search("irmao");
			$r1 = $rs[0];
			$this->assertEqual("Irmãos petralha", $r1->name);
		}

		function testSingleQuote(){
			echo "<br/> testing projects searching with single quotes search...";
			$name = "Mickey's Steamboat willie";
			$this->addProject($name);
			$pControl = new ProjectControl();
			$rs = $pControl->Search("mickey's");
			$r1 = $rs[0];
			$this->assertEqual($name, $r1->name);
		}

	}

?>