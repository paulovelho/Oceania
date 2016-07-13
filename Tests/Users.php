<?php

	SimpleTest::prefer(new TextReporter());
	include_once("_tests.php");

	echo "testing users - environment: ".MagratheaConfig::Instance()->GetEnvironment()."<br/>";

	class TestUser extends UnitTestCase {
		function setUp(){
		}
		function tearDown(){
		}

		function testIfPasswordIsEncrypted(){
			echo "<br/> testing if user password is encrypted...";
			$user = new User();
			$user->name = "aaa";
			$user->SetPassword("12345678");
			$this->assertNotEqual($user->password, "12345678");
		}

		function testIfLoginWorks(){
			echo "<br/> testing if login suceedes...";
			$user = UserControl::Login("walt@disney.com", "12345678");
			$this->assertNotNull($user->id);
			$this->assertEqual("Walt Disney", $user->name);
		}

		function testIfLoginFails() {
			echo "<br/> testing if login fails...";
			$user = UserControl::Login("walt@disney.com", "xxx123xxx");
			$this->assertNull($user);			
		}
	}

?>