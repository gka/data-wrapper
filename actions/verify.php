<?php

/****
/*
/*   @desc: Validates the email address of the user in the DB, then reloads page
/*   @author: NKB <hi@nkb.fr>
/*
/****/

require_once "config.php";

if (isset($_GET["verify"])){
	
	$token=$_GET["verify"];
	$email=$_GET["email"];

	//updates the DB
	$q_verify = "UPDATE users SET activated=1 WHERE email='$email'";
	if ($mysqli->query($q_verify)){
		
		//Sets the user email in the session var
		$_SESSION["user_email"] = $email;

		//reloads page
		header("location:". BASE_DIR);
	}else{

		echo _("Could not verify e-mail address.");
	
	}

}else{
	echo _("Could not verify e-mail address.");
}

?>