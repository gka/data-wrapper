<?php

/****
/*
/*   @desc: Gets the data from the DB and sends it back to the client
/*   @author: NKB <hi@nkb.fr>
/*
/****/

require_once "../config.php";

$chart_id = $_POST['chart_id'];

$action = $_POST['action'];

//If user has pressed the 'next' button
if ($action == "next"){
	$return_array["status"] = "200";
	$return_array["chart_id"] = $chart_id;

//Returns the data for the given chart
}else{

	$q = "SELECT chart_csv_data, horizontal_headers, vertical_headers FROM charts WHERE chart_id='$chart_id' LIMIT 1";

	if ($result = $mysqli->query($q)) {
		
		//fetches the result
		while ($row = $result->fetch_object()) {

			$csv_data = unserialize($row->chart_csv_data);
			$horizontal_headers = $row->horizontal_headers;
			$vertical_headers = $row->vertical_headers;
			
		}

		//success
		$return_array["status"] = "200";
		
		//returns the chart data
		$return_array["csv_data"] = $csv_data;

		//returns the headers details
		$return_array["vertical_headers"] = $vertical_headers;
		$return_array["horizontal_headers"] = $horizontal_headers;

		//returns the id of the chart
		$return_array["chart_id"] = $chart_id;

	}else{

		$return_array["status"] = "600";
		$return_array["error"] = _("Could not fetch the data from the database.");
		$return_array["error_details"] = $mysqli->error;
	} 
}


echo json_encode($return_array);

$mysqli->close();

 ?>