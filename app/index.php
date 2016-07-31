<?php

	include("inc/global.php"); 
	include("Controls/_Controller.php");
	MagratheaController::IncludeAllControllers();
	MagratheaModel::IncludeAllModels();


	// let's include some of Magrathea's awesome plugins:
	include("plugins/jquery1.7/load.php");
	include("plugins/bootstrap2/load.php");
	include("plugins/colorbox/load.php");
	include("plugins/font-awesome4/load.php");
	
	try {
		MagratheaView::Instance()
			->IncludeCSS("css/layout/theme.css")
			->IncludeCSS("css/style.css")
			->IncludeJavascript("javascript/layout/common.js")
			->IncludeJavascript("javascript/layout/script.js")
			->IncludeJavascript("javascript/scripts.js")
			->IncludeJavascript("javascript/tasks.js");

		// JAVASCRIPTS:
		/**
		<!-- ===================== JS ===================== -->
		<script src="/javascript/libs/jquery-1.7.2.min.js"></script>    
		<script src="/javascript/libs/bootstrap.min.js"></script>   
		<script src="/javascript/libs/ios-orientationchange-fix.js"></script>          
		<script src="/javascript/libs/jquery-ui-1.8.20.custom.min.js"></script>
		<script src="/javascript/plugins/widgets/jquery.sparkline.min.js"></script>
		<script src="/javascript/layout/common.js"></script>  
		<script src="/javascript/libs/prettify.js"></script>      
		<script src="/javascript/plugins/charts/jquery.flot.min.js"></script>   
		<script src="/javascript/plugins/charts/jquery.flot.resize.min.js"></script>  
		<script src="/javascript/plugins/charts/jquery.flot.pie.min.js"></script>  
		<script src="/javascript/plugins/charts/jquery.flot.stack.min.js"></script>  
		<script src="/javascript/plugins/charts/jquery.flot.symbol.min.js"></script>            
		<script src="/javascript/plugins/tables/jquery.dataTables.min.js"></script>
		<script src="/javascript/plugins/calendar/fullcalendar.min.js"></script>
		<script src="/javascript/plugins/formselements/chosen.jquery.min.js"></script> 
		<script src="/javascript/plugins/formselements/scrollability.min.js"></script> 
		<script src="/javascript/plugins/formselements/jquery.dropkick-1.0.0.js"></script> 
		<script src="/javascript/layout/script.js"></script>
		<script src="/javascript/layout/specific/sparks.js"></script>
		<script src="/javascript/layout/specific/index.js"></script>
		**/
		MagratheaView::Instance()
			->IncludeJavascript("javascript/libs/jquery-ui-1.8.20.custom.min.js");

	} catch(Exception $ex){
	// probably the file does not exists. What to do now?
	}

	// Magrathea Route will get the path to the correct method in the right class:
	MagratheaRoute::Instance()
		->SetRoute( 
			array(
				"Logout" => "Login/Out"
			)
		)
		->Defaults("Login")
		->Route($control, $action, $params);

	try{
		MagratheaController::Load($control, $action, $params);
	} catch (Exception $ex) {
		Debug($ex);
		BaseControl::Go404();
	}

?>
