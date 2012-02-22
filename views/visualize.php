<!-- This file holds all HTML/JS contents for the screen "5.VISUALIZE" -->

<?php
  
  /* Adds the JS files for the vis libs */

//Fetches the JSON that holds the data about the visualisations
require_once('visualizations/config.json.php');

//Convert file into JSON
$json_vis=json_decode($file_vis);

//Loop through the libs  in the JSON
foreach($json_vis->librairies as $librairy){

	//Loop throught the dependancies array
	foreach($librairy->dependancies as $dependancy){

		//Adds the lib
		echo '<script src="visualizations/'. $dependancy .'" type="text/javascript"></script>';

	}
}

?>

<script src="js/onfinishinput.js" type="text/javascript"></script>
<script src="js/json-serialization.js" type="text/javascript"></script>

<script type="text/javascript">

options = {
    chart: {
        defaultSeriesType: 'column'
    },
    title: {
        text: "<?php echo _("Title") ?>"
    },
    subtitle: {
        text: "<?php echo _("Subtitle") ?>"
    },
    credits: {
    	enabled: false
    },
    xAxis: null,
    yAxis: null,
    tooltip: {
        style: {
            width:'150px'
        }
    },
    series: []
};

function js_enterScreen_visualize(){

	$.post("actions/check.php", { chart_id: chart_id, action: "current" },
   		function(data) {

   			loader_hide();

   			if (data != ""){

     			data = jQuery.parseJSON(data);

     			if (data.status == 200){

     				csv_data = data.csv_data;
     				vertical_headers = data.vertical_headers;
     				horizontal_headers = data.horizontal_headers;

     				update_options();

     			}else{
     				error(data.error);
     			}

     		}else{
     			error();
     		}

   		});

   	//init the chart info button
	
	$('#chart_info').click(function() {

		//retrieves the html code of the vis chosen
		var chart_desc = $("#chart_type option[value="+ chart_type +"]").attr("html_code");

		//shoves the code in the div
		$("#chart_desc_box").html(chart_desc);
		
   		//displays the div
		$("#chart_desc_box").show();
	
	});	

	var mouse_in_chart_desc_box = false;

	//Watches if the mouse inside the div
	$('#chart_desc_box').hover(function(){ 
        mouse_in_chart_desc_box=true; 
    }, function(){ 
        mouse_in_chart_desc_box=false; 
    });

   	//init the description box's close
   	$("body").mouseup(function(){ 
        if(! mouse_in_chart_desc_box) $('#chart_desc_box').hide();
    });

}


function update_options(){

	//Gets the name of the chosen theme
	var theme = $("#chart_theme").val();

	//Stores the theme
	options.chart.chart_theme = theme;

	//renders here
	options.chart.renderTo = "chart";

	//clears the data from the chart
	options.series = [];
	options.categories = new Array();

	/* Gets and sets the texts */

	//title
	var title = $("#chart_title").val();
	options.title.text = title;

	//subtitle
	var subtitle = $("#chart_subtitle").val();
	if (subtitle != "" && subtitle != "<?php echo _("Subtitle") ?>"){
		options.subtitle.text = subtitle
	} else {
		options.subtitle.text = "";
	}
	
	//yAxis
	yAxis = $("#chart_yAxis").val();

	//source URL
	var source_url = $("#chart_source_url").val();
	if (source_url == "<?php echo _("Source URL") ?>"){
		source_url = "";
	}else if(source_url.substr(0,7) != "http://"){
		source_url = "";
		error("<?php echo _("Source URL must begin with 'http://'") ?>");
	}else{
		options.source_url = source_url;	
	}

	//source
	var source = $("#chart_source").val();
	if (source == "<?php echo _("Source") ?>"){
		source = "";
	}else{
		options.source = source;	
	}

	//Description
	var desc = $("#chart_desc").val();
	if (desc == "<?php echo _("Chart description") ?>"){
		desc = "";
	}else{
		options.desc = desc;	
	}

	//Assigns a chart type according to the user's choice in the drop down menu
	chart_type = $("#chart_type").val();

	//If the chose option is "visualization type"
	if (chart_type == "none"){
		return null;
	}

	//gets the name of the library
	var chart_lib = $("#chart_type option[value="+ chart_type +"]").attr("library");

	//sets the name of the library in the option JSON
	options.chart.chart_lib = chart_lib;

	//gets the name of the file to load
	var vis_code = $("#chart_type option[value="+ chart_type +"]").attr("vis_code");

	//loads the appropriate JS
	$.getScript('visualizations/types/'+vis_code, function(){
	   
		//updates the chart
		render_chart(options, theme);

		//stores the var options
		$("#visualize_data").val(JSON.stringify(options));

	});



}

</script>

<div class="screen" id="visualize">

	<div id="explainer"><?php echo _("Build your visualization.") ?></div>

	<!-- This textarea is used to hold the options var that'll be passed on to the next screen -->
	<textarea id="visualize_data" style="display:none"></textarea>

	<div id = "chart_customization">
		<div class="chart_customizator">
			<input type="text" id="chart_title" class="chart_builder title" value="<?php echo _("Title (required)") ?>" onfinishinput="update_options()"/>
		</div>
		<div class="chart_customizator">
			<input type="text" id="chart_subtitle" class="chart_builder subtitle" value="<?php echo _("Subtitle") ?>" onfinishinput="update_options()"/>
		</div>
		

		<?php require_once "views/vis.chooser.php" ?>

		
		<div class="chart_customizator">
			<select id="chart_theme" onchange="update_options()">
				
				<?php require_once "views/style.chooser.php" ?>

			</select>
		</div>

		<div class="chart_customizator">
			<input type="text" id="chart_yAxis" class="chart_builder yAxis column" value="<?php echo _("Vertical axis title (required)") ?>" onfinishinput="update_options()"/>
		</div>

		<div class="chart_customizator" style="margin-right:0">
			<input type="text" id="chart_source" class="chart_builder source" value="<?php echo _("Source") ?>" onfinishinput="update_options()" />
		</div>

		<div class="chart_customizator">
			<input type="text" id="chart_source_url" class="chart_builder source_url" value="<?php echo _("Source URL") ?>" onfinishinput="update_options()"/>
		</div>

		<div class="chart_customizator" style="margin-right:0">
			<input type="text" id="chart_desc" class="chart_builder desc" value="<?php echo _("Chart description") ?>" onfinishinput="update_options()" />
		</div>

		
	</div>
	<div id="chart"></div>
</div>