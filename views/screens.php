<!DOCTYPE html>
<html>
    <head>

        <meta http-equiv="content-type" content="text/html; charset=utf-8" />

        <title><?php echo _("Datawrapper, a project by ABZV") ?></title>

        <!-- General styles -->
        <link rel="stylesheet" type="text/css" href="css/stylesheets/general.css" />

        <!-- JQuery library -->
        <script src="js/jquery-1.6.4.js" type="text/javascript"></script>

        <!-- JQueryUI library -->
        <script src="js/jquery-ui-1.8.16.custom.min.js" type="text/javascript"></script>       
        
        <!-- Fancybox assets -->
        <script type="text/javascript" src="js/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
        <link rel="stylesheet" href="js/fancybox/jquery.fancybox-1.3.4.css" type="text/css" media="screen" />

        <!-- The JS function that help navigate the app -->
        <script src="js/navigation.js" type="text/javascript"></script> 
        
        <!-- More general functions for the app -->
        <script src="js/functions.js" type="text/javascript"></script> 

        <!-- Loads Favicon -->
        <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon" />

    </head>


    <body>
    
	    <script type="text/javascript">
	    
	    /********************/
	    /* Global vars init */
	    /********************/

	    //Keeps track of the screen we're at
	    var currentSlide = "empty";

	    //Keeps track of the chart that's being worked on
	    var chart_id;

        var csv_data = {};

        var chart_type;

        var yAxis;

        var options;

	    /* END global vars init */

	     $(document).ready(function() {

            //hides all screens on startup
            $('.screen').hide();

            <?php if (isset($_GET["m"])):

                //This section appears only if user comes from the vis_list page

                $chart_id = intval($_GET["m"]);

                //finds the chart
                $chart = new Chart($mysqli); 

                //gets the vars
                $chart->setID($chart_id);

                ?>
                
                //sets the globals options, data and chart_id according to what has been transmitted
                options = <?php echo  $chart->js_code ?>;
                chart_id = <?php echo $chart_id ?>;
                csv_data = <?php echo json_encode($chart->csv_data) ?>;
                tsv_data = "<?php echo $chart->tsv_data ?>";
                horizontal_headers = <?php echo  $chart->has_horizontal_headers ?>;

                //Populates the first field (1. INPUT)
                $("#input_data").val(tsv_data);

                //Makes sure screen 2. CHECK looks good too
                js_enterScreen_check();

                //populates the descriptive fields

                //title
                if (options.title.text){ $("#chart_title").val(options.title.text); }

                //subtitle
                if (options.subtitle.text){ $("#chart_subtitle").val(options.subtitle.text); }
                
                //yAxis
                if (options.yAxis.title.text){ $("#chart_yAxis").val(options.yAxis.title.text); }

                //source URL
                if (options.source_url){ $("#chart_source_url").val(options.source_url); }

                //source
                if (options.source){ $("#chart_source").val(options.source); }

                //description
                if (options.desc){ $("#chart_desc").val(options.desc); }

                //chart type
                $("#chart_type").val(options.chart.defaultSeriesType);

                //theme
                $("#chart_theme").val(options.chart.chart_theme);

                //renders chart
                update_options();

                //sends the user directly to the 3. Visualize screen
                showSlide("visualize", "empty");

                //End of the section from vis_list
            <?php else:?>
    	        
    	        //Starts the slideshow 
    	        showNext();

	        <?php endif; ?>

            //Init all inputs fields so they react properly onBlur
            initInputs();

            //Init the buttons in the header
            initHeader();

	        //Tells the next prev buttons what to do
	        $('#next').click(function(){
                dispatchNext(currentSlide);
            });

            $('#prev').click(function(){
                showPrev();
            });

            //Tells the new chart button what to do
            $('#new_chart').click(function(){
                //goes back home
                location.replace("<?php echo BASE_DIR ?>");
            });

            //init the error box
            $('#error').click(function() {
                $(this).hide();
            });

            <?php
                //shows only if user hasn't deactivated quickstart 
                if ($user->show_quickstart()):
            ?>
                $('body').append("<a id='hidden_link' style='display:none'></a>");

                //Loads the quickstart div
                $("#hidden_link").fancybox({href:"#quickstart", 'hideOnContentClick': false})
                                .trigger('click');
                
                $("a.fancybox").fancybox({
                    'hideOnContentClick': false
                });
            
            <?php
            //if user has deactivated quickstart, just loads the fancybox
            else:
            ?>
                //Loads the fancybox
                $("a.fancybox").fancybox({
                    'hideOnContentClick': false
                });

            <?php
            //ends if user hasn't deactivated quickstart
            endif;
            ?>

	     });

        jQuery(window).load(function(){
            //hides loader when page is fully loaded
            loader_hide();   
        });

	    </script>

        <!-- A div that serves for popups and loading screens -->
        <div id="black_veil"></div>

        <!-- A div that serves for loading screens -->
        <div id="loader">
            <img src="images/ajax-loader.gif" />   
        </div>

        <div id="container">
    	    <div id="error" style="display:none;"><?php echo _("Errors are displayed here") ?></div>

            <!-- Start header -->
        	<?php require_once "header.php" ?>
            <!-- End header -->
        	
        	<div id="breadcrumbs">
        		<div id="crumbs_input" class="off" style="margin-left:0">
                    <?php echo _("1. Input data") ?>
                </div>
        		<div id="crumbs_check" class="off">
                    <?php echo _("2. Check data") ?>
                </div>
        		<div id="crumbs_visualize" class="off">
                    <?php echo _("3. Visualize") ?>
                </div>
        		<div id="crumbs_publish" class="off" style="margin-right:0; margin-left:7px;">
                    <?php echo _("4. Publish") ?>
                </div>
        	</div>

        	<div id="button_next">
        		<button id="next" class="button nav">
        			<?php echo _("Next") ?>&nbsp;&rsaquo;
        		</button>

                <button id="new_chart" class="button nav" style="display:none">
                    <?php echo _("New") ?>&nbsp;&rsaquo;
                </button>
        	</div>
        	<div id="button_prev" style="display:none">
        		<button id="prev" class="button nav">
        			&lsaquo;&nbsp;<?php echo _("Prev") ?>
        		</button>
        	</div>

            <?php if (isset($_GET["m"])): ?>
                <div id="warning_edit">
                    <?php echo _("The chart you're editing is already published online. Use caution.") ?>
                </div>
            <?php endif; ?>

        	<div id="screen_container">
        		<!-- Loads the different screens -->

                <!-- We need an empty screen for smooth transitions when user is landing -->
        		<?php require_once "views/empty.php"; ?>
        		<?php require_once "views/input.php"; ?>
        		<?php require_once "views/check.php"; ?>
        		<?php require_once "views/visualize.php"; ?>
        		<?php require_once "views/publish.php"; ?>

        	</div>

            <!-- Start Footer -->
            <?php require_once "views/footer.php"; ?>        