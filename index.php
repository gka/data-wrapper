<?php 

require_once "config.php"; 



if (isset($_GET["c"])){
	//User is loading an embedded visualization
	require_once "views/embed.php";

}elseif (time() > 1329868800 || isset($_GET["preview"])){
	//shows page after 2/22/2012 or if preview is set

	if (isset($_GET["verify"])){
		//User is verifying her email address
		require_once "actions/verify.php";

	}else if(isset($_SESSION["user_email"])){

		//User is signed in, can build a datavis
		
		//Gets user_id
		$user = new User($mysqli);
		$user_id = $user->getID();
		$user_email = $_SESSION["user_email"];
		$_SESSION["user_id"] = $user_id;

		if (isset($_GET["vis_list"])){
		
			//User is verifying her email address
			require_once "views/vis_list.php";
		
		}else{

			//new vis
			require_once "views/screens.php";
		}

	}else{
		//Not signed in
		require_once "views/login.php";
	}
}else{
	require_once "views/comingsoon.php";
}
?>
