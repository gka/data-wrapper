
<!-- This file holds all HTML contents for the screen "1.INPUT" -->

<script type="text/javascript">

function js_enterScreen_input(){
	
	$(".sample_data_fill").click(function(){
		
		var file = "samples/" + $(this).attr("type") + ".txt";

		$.ajax({
	        type: "GET",
	        url: file,
	        async: false,
	        success: function(data){
	            		//fills the textarea with sample data
						$("#input_data").val(data);
	        }
	    });

	});
}

</script>
<div class="screen" id="input">

	<div id="explainer"><?php echo _("Paste data here") ?></div>

	<textarea id="input_data"></textarea>

	<div id="sample_data">
		<p><?php echo _("Try Datawrapper with some sample data:") ?></p>
		<ul>
			<li class="sample_data_fill" type="bars"><strong><?php echo _("Bar chart")?>:</strong> <?php echo ("Gini coefficient in Germany, Sweden and South Africa (2005).") ?></li>
			<li class="sample_data_fill" type="multiple_bars"><strong><?php echo _("2-dimensional bar chart")?>:</strong> <?php echo ("Evolution of the Gini coefficient in Germany, France and Greece at 5-year intervals, 1995-2010.") ?></li>
			<li class="sample_data_fill" type="lines"><strong><?php echo _("Line chart")?>:</strong> <?php echo ("Median income according to education status in Germany, 2005-2010.") ?></li>
			<li class="sample_data_fill" type="pie"><strong><?php echo _("Pie chart")?>:</strong> <?php echo ("Income distribution in Germany in the 1990's.") ?></li>
			<li class="sample_data_fill" type="responsive"><strong><?php echo _("Responsive table")?>:</strong> <?php echo ("Gini coefficient in Europe, 2001-2010.") ?></li>
			<li class="sample_data_fill" type="streamgraph"><strong><?php echo _("Streamgraph")?>:</strong> <?php echo ("Evolution of income distribution by quintile in Germany, 1995-2010.") ?></li>
		</ul>
	</div>

</div>

<!-- End screen "1.INPUT" -->