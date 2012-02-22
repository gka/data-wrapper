<?php

/****
/*
/*   @desc: Transposes data
/*   @author: NKB <hi@nkb.fr>
/*
/****/

require_once "../config.php";

$chart_id = $_POST['chart_id'];

$q = "SELECT chart_csv_data, horizontal_headers, vertical_headers FROM charts WHERE chart_id='$chart_id' LIMIT 1";

if ($result = $mysqli->query($q)) {
	
	//fetches the result
	while ($row = $result->fetch_object()) {

		$csv_data = unserialize($row->chart_csv_data);
		$horizontal_headers = $row->horizontal_headers;
		$vertical_headers = $row->vertical_headers;	
	}

	if ($horizontal_headers && $vertical_headers){

		//Transposes the data
		$csv_data = transpose($csv_data);

		$q_transpose = "UPDATE charts SET chart_csv_data = '" . serialize($csv_data) . "' WHERE chart_id = '$chart_id'";
		if ($result = $mysqli->query($q_transpose)) {

			//success
			$return_array["status"] = "200";

			//returns the id of the chart
			$return_array["chart_id"] = $chart_id;

		}else{
				$return_array["status"] = "600";
				$return_array["error"] = _("Could not transpose the data in the database.");
				$return_array["error_details"] = $mysqli->error;
		}

	}else{
		
		//Error message when trying to transpose a table with only one header

		$return_array["status"] = "601";
		$return_array["error"] = _("You can only transpose a table with two entries.");
	}

}else{

	$return_array["status"] = "600";
	$return_array["error"] = _("Could not fetch the data from the database.");
	$return_array["error_details"] = $mysqli->error;
} 



echo json_encode($return_array);

$mysqli->close();

 ?>