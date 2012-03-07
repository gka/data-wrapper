<?php

/****
/*
/*   @desc: Manages the user
/*
/****/

if (isset($_POST['action'])){
	
	require_once "../config.php";
	require_once "../libraries/ses.php";

	$user = new User($mysqli);

	switch($_POST['action']){
		
		case "signup":
			$return_array = $user->signup();
			break;

		case "connect":
			$return_array = $user->connect();
			break;

		case "logout":
			$return_array = $user->logout();
			break;

		case "quickstart_noshow":
			$return_array = $user->quickstart_noshow();
			break;

		case "pwd_change":
			$return_array = $user->pwd_change();
			break;

		case "pwd_reminder":
			$return_array = $user->pwd_reminder();
			break;

		case "list_vis":
			$return_array = $user->list_vis();

	}

	$return_array["status"] = $user->status;
	$return_array["error"] = $user->error;
	$return_array["error_details"] = $user->error_details;

}elseif (isset($_GET["verify"])){
	
	$user = new User($mysqli);

	$user->verify();

}else{

	$return_array["status"] = "603";
	$return_array["error"] = _("No action defined.");

}

echo json_encode($return_array);
?>