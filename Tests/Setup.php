<?php

	include_once("_tests.php");

	echo "environment: ".MagratheaConfig::Instance()->GetEnvironment()."<br/>";

	// truncate all:
	$sql = "TRUNCATE TABLE users";
	MagratheaDatabase::Instance()->Query($sql);
	$sql = "TRUNCATE TABLE stats";
	MagratheaDatabase::Instance()->Query($sql);
	$sql = "TRUNCATE TABLE status_changes";
	MagratheaDatabase::Instance()->Query($sql);
	$sql = "TRUNCATE TABLE projects";
	MagratheaDatabase::Instance()->Query($sql);
	$sql = "TRUNCATE TABLE works";
	MagratheaDatabase::Instance()->Query($sql);
	$sql = "TRUNCATE TABLE tasks";
	MagratheaDatabase::Instance()->Query($sql);

	// set up:
	$usr1 = new User();
	$usr1->name = "Walt Disney";
	$usr1->email = "walt@disney.com";
	$usr1->SetPassword("12345678");
	$usr1->Insert();

	$st = new Status();
	$st->name = "pending";
	$st->Insert();
	$st = new Status();
	$st->name = "to-do";
	$st->Insert();
	$st = new Status();
	$st->name = "wip";
	$st->Insert();
	$st = new Status();
	$st->name = "on-hold";
	$st->Insert();
	$st = new Status();
	$st->name = "homolog";
	$st->Insert();
	$st = new Status();
	$st->name = "done";
	$st->Insert();
	$st = new Status();
	$st->name = "archived";
	$st->Insert();

?>