<!-- This file holds all HTML/JS contents for the screen "5.VISUALIZE" -->

<script src="highcharts/highcharts.js" type="text/javascript"></script>
<script src="js/onfinishinput.js" type="text/javascript"></script>
<script src="js/json-serialization.js" type="text/javascript"></script>

<script type="text/javascript">

var csv_data = {};

var options = {
	chart_lib: "Highcharts",
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
	var yAxis = $("#chart_yAxis").val();

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
	var chart_type = $("#chart_type").val();

	//If the chose option is "visualization type"
	if (chart_type == "none"){
		return null;
	}

	/***********************/
	/* Bar and Line charts */
	/***********************/

	if (chart_type == "column" || chart_type=="line"){

		//Shows the attributes specific to column charts
		$(".column").removeClass("inactive");

		//Prepares Highcharts
		options.chart.defaultSeriesType = chart_type;

		//Axes
		options.xAxis = {};
		options.xAxis.categories = new Array();
		options.yAxis= {};
		options.yAxis.min = 0;
		
		//Y axis name
		options.yAxis.title = {text: yAxis};

		//Tooltip
		options.tooltip.formatter = function(){return barTooltip(this); };

		var count_rows = 0;

		$.each(csv_data, function() {
			//New row

			//if this is the first row, populates the categories
			if (count_rows == 0 && horizontal_headers == 1){
				
				var count_cols = 0;

				$.each(this, function() {

					if (count_cols>0) options.xAxis.categories.push(String(this));

					count_cols++;
				});
				
				header_row = false;
			}else{

				var count_cols = 0;
			
				$.each(this, function() {
					//New col

					if (count_cols == 0){
						//if this is the first cell, adds series
						
						options.series.push({name: String(this), data: new Array});

					}else{
						//else, populates the series	
						options.series[options.series.length-1].data.push(parseFloat(this));
					}

					count_cols++;
				});

			}
			count_rows++;
		});
				
					
	}else if (chart_type == "pie"){
		/***********************/
		/*      Pie chart      */
		/***********************/
		
		//Shows/hides the attributes specific to pie charts
		$(".column").addClass("inactive");

		//Prepares Highcharts
		options.chart.defaultSeriesType = chart_type;

		//Tooltip
		options.tooltip.formatter = function(){return pieTooltip(this); };

        //Axes (remove)
        options.xAxis = null;
        options.yAxis = null;

		//Prepares the series
		options.series[0] = {};
		options.series[0].type = 'pie';
		options.series[0].name = options.title.text;
		options.series[0].data = new Array();

		//To build the pie, we only care about the first 2 columns
		var count_rows = 0;

		$.each(csv_data, function() {
			//New row
			var point_name = this[0];
			var point_value = parseFloat(this[1]);

			//Checks that the (name, value) pair is correct
			if (isNumber(point_value)){
				var point = {name: point_name, y: point_value};
				//var point = new Array(point_name, point_value);
				options.series[0].data.push(point);
			}

		});
		
	}

	//updates the chart
	render_chart(options, theme);

	//stores the var options
	$("#visualize_data").val(JSON.stringify(options));

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
		<div class="chart_customizator">
			<select id="chart_type" onchange="update_options()">
				<option value="none"><?php echo _("Visualization type") ?> </option>
				<option value="column"  selected="selected"><?php echo _("Bar chart") ?> </option>
				<option value="line"><?php echo _("Line chart") ?> </option>
				<option value="pie"><?php echo _("Pie chart") ?> </option>
			</select>
		</div>
		
		<div class="chart_customizator">
			<select id="chart_theme" onchange="update_options()">
				
				<?php require_once "views/style.chooser.php" ?>

			</select>
		</div>

		<div class="chart_customizator">
			<input type="text" id="chart_yAxis" class="chart_builder yAxis column" value="<?php echo _("Vertical axis title (required)") ?>" onfinishinput="update_options()"/>
		</div>

		<div class="chart_customizator">
			<input type="text" id="chart_source" class="chart_builder source" value="<?php echo _("Source") ?>" onfinishinput="update_options()"/>
		</div>

		<div class="chart_customizator">
			<input type="text" id="chart_source_url" class="chart_builder source_url" value="<?php echo _("Source URL") ?>" onfinishinput="update_options()"/>
		</div>

		<div class="chart_customizator">
			<input type="text" id="chart_desc" class="chart_builder desc" value="<?php echo _("Chart description") ?>" onfinishinput="update_options()"/>
		</div>

		
	</div>
	<div id="chart"></div>
</div>