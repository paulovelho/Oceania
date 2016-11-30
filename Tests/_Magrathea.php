<?php

	class TestOfStaticConfig extends UnitTestCase{

		function setUp(){
		}
		function tearDown(){
		}

		function testGetVersion() {
			$version = Magrathea::GetVersion();
			$this->assertEqual($version, "1.3.1");
		}

	}

?>
