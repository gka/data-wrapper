<!DOCTYPE html>
<html>
    <head>

        <meta http-equiv="content-type" content="text/html; charset=utf-8" />

        <title><?php echo _("Datawrapper, a project by DataStory") ?></title>

        <!-- General styles -->
        <link rel="stylesheet" type="text/css" href="css/stylesheets/general.css" />

        <!-- Vis_list styles -->
        <link rel="stylesheet" type="text/css" href="css/stylesheets/vis_list.css" />

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

	     $(document).ready(function() {
	        
            //Init all inputs fields so they react properly onBlur
            initInputs();

            //Init the buttons in the header
            initHeader();

            //Loads the fancybox
            $("a.fancybox").fancybox({
                'hideOnContentClick': true
            });

            //init the error box
            $('#error').click(function() {
                $(this).hide();
            });		

            //loads the list of visualizations
            $.post('actions/list_vis.php', function(data){
                if (data != ""){
                    data = jQuery.parseJSON(data);

                    if (data.status == 200){
                        
                        //appends the list of vis to the div
                        $.each(data.vis, function(key, value){
                            
                            $("#vis_list_inform").append(value);
                        
                        });

                    }else{
                        error(data.message);
                    }
                }else{
                    error();
                }
            });

	     });

        function formSubmit(opt, chart_id, csv_data, tsv_data){

          document.forms[0].options.value = opt;
          document.forms[0].chart_id.value = chart_id;
          document.forms[0].csv_data.value = csv_data;
          document.forms[0].tsv_data.value = tsv_data;
          document.forms[0].submit();

        }

	    </script>

        <div id="container">
    	    <div id="error" style="display:none;"><?php echo _("Errors are displayed here") ?></div>

            <!-- Start header -->
        	<?php require_once "header.php" ?>
            <!-- End header -->

        	<div id="screen_container">

                <div id="vis_list">
                    <h1><?php echo _("Your visualizations") ?></h1>

                    <!-- Form that is used to pass the "options" var to the edit page -->

                    <form action="<?php echo BASE_DIR ?>" method=POST>
                    <input type=hidden name="options" value=-1>
                    <input type=hidden name="csv_data" value=-1>
                    <input type=hidden name="chart_id" value=-1>
                    <input type=hidden name="tsv_data" value=-1>

                        <!-- List of visualizations goes here -->
                        <div id="vis_list_inform"></div>
                    
                    </form>
                    <!-- end form -->


                </div>

        	</div>

            <!-- Start Footer -->
            <?php require_once "views/footer.php"; ?>