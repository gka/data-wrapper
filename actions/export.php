<?php

/****
/*
/*   @desc: Outputs the CSV file
/*   @author: NKB <hi@nkb.fr>
/*
/****/

require_once("../config.php");

if (isset($_GET['c'])){
	
	$chart_id = $_GET['c'];

	//Asks the DB for the data
	$q = "SELECT chart_csv_data, chart_title FROM charts WHERE chart_id='$chart_id' LIMIT 1";

	if ($result = $mysqli->query($q)) {
		
		//fetches the result
		while ($row = $result->fetch_object()) {

			$csv_data = unserialize($row->chart_csv_data);
			$chart_title = $row->chart_title;
			
		}

		//Formats file name using chart title and removing special chars
		if ($chart_title == "")
			$chart_title = "ExportfromDataStory";
		else
			$chart_title = str_replace(array("?", "[", "]", "/", "\\", "=", "+", "<", ">", ":", ";", "\"", ",", "*", " ", "'"), "", $chart_title);

		/***********************/
		/* Prints the CSV file */
		/***********************/

		//Sends headers
		header("Content-type: application/csv");
		header("Content-Disposition: attachment; filename=". $chart_title .".csv");
		header("Pragma: no-cache");
		header("Expires: 0");

		//Gets the data
		foreach ($csv_data as $row){

			$cell_count = 0;

			foreach ($row as $cell){
				
				$cell_count++;

				echo '"'.$cell.'"';
				
				//if it's not the last cell
				if (count($row) != $cell_count)
					echo ",";
			
			}

			//line break at the end of the line
			echo "\n";
		}
	}else{ //no mysql result

		echo  _("Could not fetch the data from the database.");
		echo "<br>";
		echo $mysqli->error;

	}

}else{ //no chart_id specified

	echo _("This page cannot be accessed.");

}
?>