<?php

/****
/*
/*   @desc: Changes the password
/*   @author: NKB <hi@nkb.fr>
/*
/****/

require_once "../config.php";

if (isset($_POST["token"])){
	
	$token=$_POST["token"];
	$email=$_POST["email"];
	$pwd=$_POST["pwd"];

	//Checks that the token is valid
	$q = "SELECT * FROM users WHERE email = '$email' AND token='$token' LIMIT 1";

	if ($result = $mysqli->query($q)) {

		$num_rows = $result->num_rows;

		if ($num_rows == 1){
			
			//query to change password
			$q_change_pwd = "UPDATE users SET pwd='". md5($pwd) ."' WHERE email='$email'";

			if ($result = $mysqli->query($q_change_pwd)) {
				//success
				$return_array["status"] = "200";

			}else{
				//failed to update user table
				$return_array["status"] = "600";
				$return_array["error"] = _("Could not change password in the DB.");
				$return_array["error_details"] = $mysqli->error;

			}
		//token is not valid
		}else{

			$return_array["status"] = "605";
			$return_array["error"] = _("No request for new password from this email address.");
		}
	//unable to complete query
	}else{
		$return_array["status"] = "600";
		$return_array["error"] = _("Could not change password in the DB.");
		$return_array["error_details"] = $mysqli->error;
	}

}else{

	$return_array["status"] = "603";
	$return_array["error"] = _("Not enough parameters were passed.");

}


echo json_encode($return_array);

?>