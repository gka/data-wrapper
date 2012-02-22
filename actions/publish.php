<?php


/****
/*
/*   @desc: Sends back the code for the visualization
/*   @author: NKB <hi@nkb.fr>
/*
/****/


require_once "../config.php";

$chart_id = $_POST['chart_id'];

$action = $_POST['action'];

$q = "SELECT chart_js_code, chart_type, chart_library, chart_theme, additional_text, source, source_url FROM charts WHERE chart_id='$chart_id' LIMIT 1";

if ($result = $mysqli->query($q)) {
	
	//fetches the result
	while ($row = $result->fetch_object()) {

		$chart_js_code = $row->chart_js_code;
		$chart_library = $row->chart_library;
		$chart_type = $row->chart_type;
		$chart_theme = $row->chart_theme;
		$chart_desc = $row->additional_text;
		$chart_source = $row->source;
		$chart_source_url = $row->source_url;
		
}

	//success
	$return_array["status"] = "200";

	//returns the chart JS code in an array
	$return_array["chart_js_code"] = json_decode($chart_js_code, true);

	//returns the chart type & lib & theme & additional info
	$return_array["chart_type"] = $chart_type;
	$return_array["chart_library"] = $chart_library;
	$return_array["chart_theme"] = $chart_theme;
	$return_array["chart_desc"] = $chart_desc;
	$return_array["chart_source"] = $chart_source;
	$return_array["chart_source_url"] = $chart_source_url;

	//returns the id of the chart
	$return_array["chart_id"] = $chart_id;

	//returns the text id
	$return_array["chart_text_id"] = alphaID($chart_id);

}else{

	$return_array["status"] = "600";
	$return_array["error"] = _("Could not fetch the data from the database.");
	$return_array["error_details"] = $mysqli->error;
} 



echo json_encode($return_array);

$mysqli->close();