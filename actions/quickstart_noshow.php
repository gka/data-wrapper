<?php

/****
/*
/*   @desc: Makes sure the user will not see the quickstart again
/*   @author: NKB <hi@nkb.fr>
/*
/****/

require_once "../config.php";

if (isset($_POST['checked'])) {
	
	$user_id = $_SESSION["user_id"];

	$q = "UPDATE users SET quickstart_show=0 WHERE user_id=$user_id ";

	if ($mysqli->query($q)){

		$return_array["status"] = "200";
	
	}else{
		
		$return_array["status"] = "600";
		$return_array["error"] = _("Could not disable quickstart in the database.");
		
	}

}else{

	$return_array["status"] = "600";
	$return_array["error"] = _("No action required.");

} 

echo json_encode($return_array);

$mysqli->close();

 ?>