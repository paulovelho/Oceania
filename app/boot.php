<?php
	// delete after use
	// or die:
#	die;

	include("inc/config.php");

	include($magrathea_path."/LOAD.php");
	include($magrathea_path."/MagratheaAdmin.php"); //  should already be declared

	$admin = new MagratheaAdmin(); // adds the admin file
	$admin->Load(); // load!

?>
