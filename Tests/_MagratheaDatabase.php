<?php

	class TestOfDatabase extends UnitTestCase{

		function setUp(){

		}
		function tearDown(){

		}

		// is Database connecting?
		function testConnectDatabase(){
			echo "<br/> testing MagratheaDatabase db connection... ";
			$env = MagratheaConfig::Instance()->GetEnvironment();
			$configSection = MagratheaConfig::Instance()->GetConfigSection($env);
			$magdb = MagratheaDatabase::Instance();
			$magdb->SetConnection($configSection["db_host"], $configSection["db_name"], $configSection["db_user"], $configSection["db_pass"]);
			$this->assertTrue( $magdb->OpenConnectionPlease() );	
		}

	}

	class TestOfDatabaseActions extends UnitTestCase {

		private $magdb = null;

		function setUp(){
			$env = MagratheaConfig::Instance()->GetEnvironment();
			$configSection = MagratheaConfig::Instance()->GetConfigSection($env);
			$this->magdb = MagratheaDatabase::Instance();
			$this->magdb->SetConnection($configSection["db_host"], $configSection["db_name"], $configSection["db_user"], $configSection["db_pass"]);
		}
		function tearDown(){

		}

		// tests if queries as an array
		function testSelectQueryAll(){
			echo "<br/> testing MagratheaDatabase QueryAll... ";
			$query = "SELECT 1 AS ok";
			$result = $this->magdb->QueryAll($query);
			$this->assertIsA($result[0], "array");
		}

		// tests if queries as a row
		function testSelectQueryRow(){
			echo "<br/> testing MagratheaDatabase QueryRow... ";
			$query = "SELECT 1 AS ok";
			$result = $this->magdb->QueryRow($query);
			$this->assertIsA($result, "array");
		}

		// tests if queries as a single result
		function testSelectQueryOne(){
			echo "<br/> testing MagratheaDatabase QueryOne... ";
			$query = "SELECT 1 AS ok";
			$result = $this->magdb->QueryOne($query);
			$this->assertEqual($result, 1);
		}

		// tests if queries as an ordered row
		function testSelectQueryRowObject(){
			echo "<br/> testing MagratheaDatabase QueryRowObject... ";
			$this->magdb->SetFetchMode("object");
			$query = "SELECT 1 AS ok";
			$result = $this->magdb->QueryRow($query);
			$this->assertEqual($result->ok, 1);
		}

		// tests if queries as an assoc row
		function testSelectQueryRowAssoc(){
			echo "<br/> testing MagratheaDatabase QueryRowAssoc... ";
			$this->magdb->SetFetchMode("assoc");
			$query = "SELECT 1 AS ok";
			$result = $this->magdb->QueryRow($query);
			$this->assertEqual($result["ok"], 1);
		}

		function testIfAllColumnNamesComesInLowerCase(){
			echo "<br/> testing MagratheaDatabase being sure all database keys returns in lower case... ";
			$this->magdb->SetFetchMode("assoc");
			$query = "SELECT 1 AS UppErCasEvar";
			$result = $this->magdb->QueryRow($query);
			$this->assertEqual($result["uppercasevar"], 1);

		}

	}


?>