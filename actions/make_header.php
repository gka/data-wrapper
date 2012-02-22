<?php

/****
/*
/*   @desc: Sets the first line of the data as header row
/*   @author: NKB <hi@nkb.fr>
/*
/****/

require_once "../config.php";

$chart_id = $_POST['chart_id'];

$q_transpose = "UPDATE charts SET horizontal_headers = '1' WHERE chart_id='$chart_id' LIMIT 1";

if ($result = $mysqli->query($q_transpose)) {

	//success
	$return_array["status"] = "200";

	//returns the id of the chart
	$return_array["chart_id"] = $chart_id;

}else{
		$return_array["status"] = "600";
		$return_array["error"] = _("Could not add a header row.");
		$return_array["error_details"] = $mysqli->error;
}

echo json_encode($return_array);

$mysqli->close();

 ?>