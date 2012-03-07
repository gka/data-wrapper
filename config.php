<?php

session_start();

//Initializes GetText
require_once "libraries/functions.lang.php";
initLanguage();

//Fetches the functions that DW needs to run
require_once "libraries/helpers.php";


if (strstr($_SERVER['SERVER_NAME'], "localhost") ){		

	// DEV ENVIRONMENT //
	require_once('actions/passwords.dev.php');

	//removes error reporting
	error_reporting(E_ALL);

}else{

	// PROD ENVIRONMENT //
	require_once('actions/passwords.prod.php');

	//removes error reporting
	error_reporting(0);
}

global $mysqli;

$mysqli = new mysqli(DW_HOST,DW_USERNAME,DW_PASSWORD,DW_DATABASE);

//Loads the user class
require_once "class/user.class.php";

//Loads the chart class
require_once "class/chart.class.php";
?>