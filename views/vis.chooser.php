<?php

/****
/*
/*   @desc: Prepares the dropdown menu to choose the vis
/*   @author: NKB <hi@nkb.fr>
/*
/****/

require_once 'config.php';

//Fetches the JSON that holds the data about the visualisations
require_once 'visualizations/config.json.php';

//Convert file into JSON
$json_vis = json_decode($file_vis);

/* Prepares the HTML that will describe each vis */

//Loop through the visualizations in the JSON
foreach($json_vis->visualizations as $visualization){

	$vis_name = $visualization->name;

	//init the html
	$html = "";

	if (isset($visualization->resources)){
		//adds the resources
		$html .= "<b>". _("Useful resources") . "</b>";
		$html .= "<br>";
		
		//parse through the resources
		foreach($visualization->resources as $title => $url){
			$html .= "<a href='$url' target='_blank'>$title</a>";
			$html .= "<br>";
		}
	}

	//builds the html further
	$html .= "<b>"._("Browser support")."</b>";
	$html .= "<br>";

	//figures out the lib
	$lib = $visualization->library;

	//figures out the compatibility
	$compatibility = $json_vis->librairies->$lib->compatibility;

	foreach($compatibility as $browser => $version){
		
		$html .= "<img src='images/$browser.png'>$version";
	
	}

	$json_vis->visualizations->$vis_name->html_code = $html;

}

?>

<div class="chart_customizator"  style="margin-right:0">
	<select id="chart_type" onchange="update_options()" >
		<option value="none"><?php echo _("Visualization type") ?> </option>

		<?php
			/* Displays the possible visualizations based on the config JSON */
			
			//Loop through the visualizations in the JSON
			foreach($json_vis->visualizations as $visualization){

				//Adds an exception: The bar chart is selected by default
				if ($visualization->name == "column")
					$selected = ' selected="selected"';
				else
					$selected = "";

				//Adds the option
				echo '<option value="'. $visualization->name .'" library="'. $visualization->library .'" html_code="'. $visualization->html_code .'" vis_code="'. $visualization->vis_code .'" '. $selected .'>'. $visualization->desc .'</option>';
			}
		?>

	</select>
</div>
<div id="chart_info"></div>
<div id="chart_desc_box" style="display=none"></div>