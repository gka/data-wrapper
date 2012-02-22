<?php

session_start();

//Initializes GetText
require_once "libraries/functions.lang.php";
initLanguage();

//Fetches the converter from nums to text
require_once "libraries/alpha.id.php";

//Function to transpose arrays
require_once "libraries/transpose.php";

//Indicates the name of the prod server
$prod_domain1 = "cloudcontrolled.com";

$prod_domain2 = "datawrapper.de";

//Fetches passwords
require_once('actions/passwords.php');

if (strstr($_SERVER['SERVER_NAME'], $prod_domain1) || strstr($_SERVER['SERVER_NAME'], $prod_domain2) ){		

	// PROD ENVIRONMENT //

	//removes error reporting
	error_reporting(0);

	//Global const
	define("BASE_DIR", "http://Datawrapper.cloudcontrolled.com");
	

}else{

	// DEV ENVIRONMENT //

	error_reporting(E_ALL);
	define("BASE_DIR", "http://localhost/Data-Story/");

	//Connects to the local DB
	$hostname = "localhost";
	$database = "datastory";
	$username = "root";
	$password = "";
}

global $mysqli;

$mysqli = new mysqli($hostname,$username,$password,$database);

//Loads the user class
require_once "class/user.class.php";
?>