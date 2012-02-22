<?php

/****
/*
/*   @desc: Logs out the user
/*   @author: NKB <hi@nkb.fr>
/*
/****/

require_once "../config.php";

unset($_SESSION["user_id"]);
unset($_SESSION["user_email"]);

if ( !isset($_SESSION["user_id"]) && !isset($_SESSION["user_email"])){

	$return_array["status"] = "200";

}else{

	$return_array["status"] = "605";
	$return_array["error"] = _("Could not log out.");

}

echo json_encode($return_array);
?>