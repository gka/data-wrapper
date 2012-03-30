<?php

/****
/*
/*   @desc: Manages the charts
/*
/****/

if (isset($_POST['action'])){
	
	require_once "../config.php";

	$chart = new Chart($mysqli);

	if  (isset($_POST['chart_id'])){
		
		$chart_id = intval($_POST['chart_id']);

		$chart->setID($chart_id);
	
	}

	switch($_POST['action']){
		
		case "setData":
			$data = $_POST['data'];
			$chart->loadData($data);
			break;

		case "getData":

			$chart->refreshData();

			$return_array["vertical_headers"] = $chart->has_vertical_headers;
			$return_array["horizontal_headers"] = $chart->has_horizontal_headers;
			$return_array["csv_data"] = $chart->csv_data;
			$return_array["chart_text_id"] = $chart->id_text;
			$return_array["user_id"] = $chart->user_id;
			$return_array["chart_additional_text"] = $chart->desc;
			$return_array["chart_js_code"] = $chart->js_code;
			$return_array["date_create"] = $chart->date_create;
			$return_array["chart_library"] = $chart->library;
			$return_array["chart_theme"] = $chart->theme;
			$return_array["chart_type"] = $chart->type;
			$return_array["chart_title"] = $chart->title;
			$return_array["source"] = $chart->source;
			$return_array["source_url"] = $chart->source_url;
			$return_array["chart_lang"] = $chart->lang;
			break;

		case "transpose":
			$chart->transpose();
			break;

		case "storeVis":
			$opts = $_POST['opts'];
			$chart->setOpts($opts);
			$chart->storeOpts();
			break;

		case "toggle_header":
			$chart->toggle_header();
			break;

	}

	$return_array["chart_id"] = $chart->id;
	$return_array["status"] = $chart->status;
	$return_array["error"] = $chart->error;
	$return_array["error_details"] = $chart->error_details;

}else{

	$return_array["status"] = "603";
	$return_array["error"] = _("No action defined.");

}

echo json_encode($return_array);
?>