<?php

	class TestOfStaticConfig extends UnitTestCase{

		function setUp(){

		}
		function tearDown(){

		}

		// load a section in Static Config
		// I check if the section that it returns is an array:
		function testLoadSectionStaticConfig(){
			echo "<br/> testing magratheaConfig loading static config...";
			$thisSection = MagratheaConfig::Instance()->GetConfigSection("general");
			$this->assertIsA($thisSection, "array");
		}

		// config file must have a default environment option
		function testConfigShouldHaveADefaultEnvironment(){
			echo "<br/> testing magratheaConfig confirming we have a default... ";
			$env = MagratheaConfig::Instance()->GetEnvironment();
			$this->assertNotNull($env);
		}

		// required fields
		function testConfigRequiredFields(){
			echo "<br/> testing magratheaConfig checking required fields... ";
			$env = MagratheaConfig::Instance()->GetConfig("general/use_environment");
			$site_path = MagratheaConfig::Instance()->GetConfig($env."/site_path");
			$magrathea_path = MagratheaConfig::Instance()->GetConfig($env."/magrathea_path");
			$compress_js = MagratheaConfig::Instance()->GetConfig($env."/compress_js");
			$compress_css = MagratheaConfig::Instance()->GetConfig($env."/compress_css");
			$this->assertNotNull($site_path);
			$this->assertNotNull($magrathea_path);
			$this->assertNotNull($compress_js);
			$this->assertNotNull($compress_css);
		}

		function testDinamicallyChangeDefaultEnvironment(){
			echo "<br/> testing magratheaConfig changing default environment... ";
			MagratheaConfig::Instance()->SetDefaultEnvironment("tests");
			$this->assertEqual(MagratheaConfig::Instance()->GetEnvironment(), "tests");
		}

	}

	class TestOfConfig extends UnitTestCase {

		private $magConfig;
		private $configPath;

		function setUp(){
			$this->configPath = MagratheaConfig::Instance()->GetConfigFromDefault("site_path")."/../configs/";

			if( file_exists($this->configPath."test_conf.conf"))
				unlink($this->configPath."test_conf.conf");
			$this->magConfig = new MagratheaConfigFile();
			$this->magConfig->setPath($this->configPath);
			$this->magConfig->setFile("test_conf.conf");
		}
		function tearDown(){
			if( file_exists($this->configPath."test_conf.conf"))
				unlink($this->configPath."test_conf.conf");
		}		

		// Create a new Config
		function testCreateConfigFile(){
			echo "<br/> testing magratheaConfig checking if we can create a config file... ";
			$this->magConfig->Save();
//			$this->assertTrue(file_exists($this->configPath."test_conf.conf"));
		}

		// Test Save a new Config with something
		function testSaveConfigFile(){
			echo "<br/> testing magratheaConfig saving a config file... ";
			$confs = array("config_test" => "ok", 
				"config_test2" => "another_ok" );
			$this->magConfig->setConfig($confs);
			$this->magConfig->Save(false);
			$this->assertTrue(file_exists($this->configPath."test_conf.conf"));
		}


		// if you save configs with sections and without sections in the same file, it shoulf be an error
		function testErrorWhenSavingAMixedArrayOfConfig(){
			echo "<br/> testing magratheaConfig confirming an error when config file is invalid... ";
			$confs = array(
				'this_section' => array(
					'this_var' => 'ok', 
					'this_other_var' => 'ok' ), 
				'simple_item' => 'ok'
			);
			$this->expectException("MagratheaConfigException");
			@$this->magConfig->setConfig($confs);
			@$this->magConfig->Save(true);
		}

		// save a single item with section
		function testSaveASingleItemWithSections(){
			echo "<br/> testing magratheaConfig saving a config file with sections... ";
			$confs = array(
				'this_section' => array(
					'this_var' => 'ok' )
			 );
			$this->magConfig->setConfig($confs);
			$this->magConfig->Save(true);
			$this->assertTrue(file_exists($this->configPath."test_conf.conf"));
		}

		// Load a var from a config file
		function testLoadVarFromConfigFile(){
			echo "<br/>testing magratheaConfig loading a var from a previously saved config file... ";
			$confs = array('config_test' => "ok" );
			$this->magConfig->setConfig($confs);
			$this->magConfig->Save(false);

			$newConf = new MagratheaConfigFile();
			$newConf->setPath($this->configPath);
			$newConf->setFile("test_conf.conf");
			$var = $newConf->GetConfig("config_test");

			$this->assertEqual($var, "ok");
		}

		// Load a var from a section from a config file
		function testLoadVarFromSection(){
			echo "<br/> testing magratheaConfig loading a var from a section... ";
			$confs = array(
				'this_section' => array(
					'this_var' => 'ok', 
					'this_other_var' => 'ok2' ), 
				'this_other_section' => array(
					'this_var' => 'ok3', 
					'this_other_var' => 'ok4' ), 
				'this_last_section' => array() 
			 );
			$this->magConfig->setConfig($confs);
			$this->magConfig->Save(true);

			$newConf = new MagratheaConfigFile();
			$newConf->setPath($this->configPath);
			$newConf->setFile("test_conf.conf");
			$section = $newConf->GetConfig();
			$this->assertEqual(count($section), 3);

			$section = $newConf->GetConfig("this_section");
			$this->assertEqual($section["this_var"], "ok");

			$var = $newConf->getConfig("this_other_section/this_var");


			$this->assertEqual($var, "ok3");
		}

	}




?>