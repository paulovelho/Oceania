<?php

	MagratheaDebugger::Instance()
		->LogQueries(true)
		->SetTemp(MagratheaDebugger::DEV);
	include("Controls/_Controller.php");
	MagratheaController::IncludeAllControllers();
	MagratheaModel::IncludeAllModels();

	MagratheaConfig::Instance()->SetDefaultEnvironment("tests");
	loadMagratheaEnv();

?>