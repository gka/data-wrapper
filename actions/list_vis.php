<?php

/****
/*
/*   @desc: Fetches the list of vis
/*   @author: NKB <hi@nkb.fr>
/*
/****/

require_once "../config.php";


if ( isset($_SESSION["user_email"]) ){

	$user = new User($mysqli);
	$return_array = $user->list_vis();

}else{

	$return_array["status"] = "600";
	$return_array["error"] = _("Not logged in, could not fetch the list of visualizations.");

}

echo json_encode($return_array);
?>