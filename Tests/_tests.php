<?php

	MagratheaDebugger::Instance()
		->LogQueries(true)
		->SetTemp(MagratheaDebugger::DEV);
	MagratheaController::IncludeAllControllers();
	MagratheaModel::IncludeAllModels();

	MagratheaConfig::Instance()->SetDefaultEnvironment("tests");
	loadMagratheaEnv();

?>