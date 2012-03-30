<?php 

require_once "config.php"; 



if (isset($_GET["c"])){
	//User is loading an embedded visualization
	require_once "views/embed.php";

}elseif (isset($_GET["verify"])){
	//User is verifying her email address
	require_once "actions/user.php";

}else if(isset($_SESSION["user_email"])){

	//User is signed in, can build a datavis
	
	//Gets user_id
	$user = new User($mysqli);
	$user_id = $user->getID();
	$_SESSION["user_id"] = $user_id;

	if (isset($_GET["vis_list"])){
	
		//User is viewing her vis list
		require_once "views/vis_list.php";
	
	}else{

		//if user is modifying a vis
		if (isset($_GET["m"])){

			//verifies that the vis belongs to user
			if ($user->own_vis(intval($_GET["m"])) === true)
				require_once "views/screens.php";
			else
				require_once "views/error.php";

		}else{

			//new vis
			require_once "views/screens.php";
		}
	}

}else{
	//Not signed in
	require_once "views/login.php";
}

?>
