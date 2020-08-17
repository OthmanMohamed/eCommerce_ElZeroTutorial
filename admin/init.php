<?php

    //Routes
    $tpl 	= 'includes/templates/'; // Template Directory
	$lang 	= 'includes/langs/'; // Language Directory
	$func	= 'includes/functions/'; // Functions Directory
	$css 	= 'layout/css/'; // Css Directory
	$js 	= 'layout/js/'; // Js Directory

	//Include important files 
	include $lang."en.php";
	include 'connect.php';
	include $tpl."header.php";

	//Include navbar in all pages except if the navbar variable is defined
	if(!isset($noNavbar)){
		include $tpl."navbar.php";
	}