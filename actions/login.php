<?php

/****
/*
/*   @desc: Checks if the user exists and if the password matches
/*   @author: NKB <hi@nkb.fr>
/*
/****/

require_once "../config.php";

if (isset($_POST['email']) && isset($_POST['pwd'])){

	//Gets data that was sent over POST
	$email = $_POST['email'];
	$pwd = $_POST['pwd'];

	$user = new User($mysqli);
	$return_array = $user->connect($email, $pwd);
		
}else{

	$return_array["status"] = "603";
	$return_array["error"] = _("Not enough parameters were passed.");

}

echo json_encode($return_array);
?>