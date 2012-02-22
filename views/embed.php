<!DOCTYPE html>
<html>
    <head>

        <meta http-equiv="content-type" content="text/html; charset=utf-8" />

        <title><?php echo _("A chart created by Data Story") ?></title>

        <!-- General styles -->
        <link rel="stylesheet" type="text/css" href="css/stylesheets/general.css" />

        <!-- Specific embed styles -->
        <link rel="stylesheet" type="text/css" href="css/stylesheets/embed.css" />

        <!-- JQuery library -->
        <script src="js/jquery-1.6.4.js" type="text/javascript"></script>

        <!-- JQueryUI library -->
        <script src="js/jquery-ui-1.8.16.custom.min.js" type="text/javascript"></script>       

    </head>


    <body>
	<?php

	require_once("config.php");

	if (isset($_GET["c"])){

		//Retreives the chart id
		$chart_text_id = $_GET["c"];
		$chart_id = alphaID($chart_text_id, true);

		//Looks for the chart in the DB
		$q = "SELECT chart_library, chart_type, chart_theme, chart_js_code, chart_lang, additional_text, source, source_url FROM charts WHERE chart_id='$chart_id' LIMIT 1";

		if ($result = $mysqli->query($q)) {
			
			//fetches the result
			while ($row = $result->fetch_object()) {

				$chart_library = $row->chart_library;
				$chart_type = $row->chart_type;
				$chart_theme = $row->chart_theme;
				$chart_lang = $row->chart_lang;
				$chart_js_code = $row->chart_js_code;
				$chart_desc = $row->additional_text;
				$chart_source = $row->source;
				$chart_source_url = $row->source_url;
				
			}

			//Sets the appropriate language
			setLanguage($chart_lang);

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
				<script src="js/functions.js" type="text/javascript"></script>
				<script type="text/javascript">
					$(document).ready(function(){

						//init the download CSV button
						$("#export_csv").click(function(){
							window.location.href = 'actions/export.php?c=<?php echo $chart_id ?>';
						});

						var opt = <?php  echo $chart_js_code ?>;

						//Arranges for the Label and Tooltip functions
						<?php if ($chart_type == "column" || $chart_type == "line"): ?>
							opt.tooltip.formatter = function(){return barTooltip(this); };
						<?php elseif ($chart_type == "pie"): ?>
							opt.tooltip.formatter = function(){return pieTooltip(this); };
						<?php endif; ?>

						//Sets the chart's height
						var chart_h = $("html").height() - $("#embed_extras").height();
						$("#chart").height(chart_h);

						//gets the theme
						var theme = "<?php echo $chart_theme ?>";
	     				
	     				render_chart(opt, theme);

					});
				</script>
				<?php

		}else{ //no data could be fetched in DB

			//Displays error
			echo $mysqli->error;
		} 
	?>	
		<div id="chart">
		</div>
		<div id="embed_extras">
			
			<?php if ($chart_desc != ""): ?>
				<p class="desc"><?php echo $chart_desc ?></p>
			<?php endif; ?>

			<?php if ($chart_source != ""): ?>
				<p class="source">
					<span id="source"><?php echo $chart_source ?></span>

					<?php if ($chart_source_url != ""): ?>
						<span id="source_url">(<a href="<?php echo $chart_source_url ?>" class="source_url"><?php echo _("Link") ?></a>)</span>
					<?php endif; ?>
				
				</p>
			<?php endif; ?>

			<button id="export_csv" class="button">
				<?php echo _("Export data") ?>
			</button>

			<div id="promo_embed"><?php printf(_("Chart created with %sDatawrapper%s."), "<a href='http://www.Datawrapper.de' target='_blank'>", "</a>") ?></div>

		</div>

		<?php
		}else{ //no GET var
			echo _("Page cannot be displayed.");
		}
		?>

		
		<!-- Piwik Image Tracker -->
		<img src="http://www.datastory.de/piwik/piwik.php?idsite=1&rec=1" style="border:0" alt="" />
		<!-- End Piwik -->
		
    </body>
</html>