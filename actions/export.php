<?php

/****
/*
/*   @desc: Outputs the CSV file
/*   @author: NKB <hi@nkb.fr>
/*
/****/

require_once("../config.php");

if (isset($_GET['c'])){
	
	$chart_id = intval($_GET['c']);

	$chart = new Chart($mysqli);

	$chart->setID($chart_id);

	$chart->refreshData();

	if ($chart->csv_data) {
		

		//Formats file name using chart title and removing special chars
		if ($chart->title == "")
			$filename = "ExportfromDatawrapper";
		else
			$filename = str_replace(array("?", "[", "]", "/", "\\", "=", "+", "<", ">", ":", ";", "\"", ",", "*", " ", "'"), "", $chart->title);

		/***********************/
		/* Prints the CSV file */
		/***********************/

		//Sends headers
		header("Content-type: application/csv");
		header("Content-Disposition: attachment; filename=". $filename .".csv");
		header("Pragma: no-cache");
		header("Expires: 0");

		//Gets the data
		foreach ($chart->csv_data as $row){

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

	}

}else{ //no chart_id specified

	echo _("This page cannot be accessed.");

}
?>