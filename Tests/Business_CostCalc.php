<?php

	SimpleTest::prefer(new TextReporter());
	include_once("_tests.php");
	include_once("Setup.php");

	echo "testing Business cost calculation - environment: ".MagratheaConfig::Instance()->GetEnvironment()."<br/>";

	$p = new Project();
	$p->name = "A Bela e a Fera";
	$p->Insert();

	$work1 = new Work();
	$work1->SetProject($p);
	$work1->title = "Castelo";
	$work1->text = "Criar um castelo";

	$work2 = new Work();
	$work2->SetProject($p);
	$work2->title = "Bela";
	$work2->text = "Criar a bela";

	$t1 = new Task();
	$t1->SetProject($p)->SetWork($work1);
	$t1->title = "Comprar um castelo";
	$t1->cost = 42000000;

	class TestBusiness extends UnitTestCase {

		function setUp(){
		}
		function tearDown(){
		}

	}

?>