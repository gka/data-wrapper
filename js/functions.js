

/*
 * @desc: Triggers error messages
 * @param1: The message to be displayed
 * @returns: Nothing
 *
 */

function error(msg){

	$('#error').html("");

	if(msg == "" || msg == undefined){
		msg = "Oops, that's not supposed to happen.";
	}

    $('#error').html(msg);
    $('#error').show();
    $('#error')
    	.effect("bounce", {
        times:3
    }, 300);

    setTimeout(function() {
        $("#error").fadeOut(100)
    }, 5000);

}


/*
 * @desc: Checks if the param is a numeric value
 * @param1: A variable of any type
 * @returns: true if n is a number, false otherwise
 *
 */

 function isNumber(n) {
  return !isNaN(parseFloat(n)) && isFinite(n);
}

/*
 * @desc: Rounds number with precision
 * @param1: The number to be rounded
 * @param2: The precision (decimals)
 * @returns: The rounded number
 *
 */

 function roundNumber(num, dec) {
	var result = Math.round(num*Math.pow(10,dec))/Math.pow(10,dec);
	return result;
}


/****************************************************************/
/* These functions have to do with Highchart (tooltip & labels) */
/****************************************************************/

function pieLabels(value) {return '<b>'+ value.point.name +'</b>: '+ roundNumber(value.percentage, 2) +' %';}

function pieTooltip(value) { return '' + value.point.name + ': ' + value.y ; }

function barTooltip(value) { return '' + value.x +': '+ value.y ; }

/****************************************************************/
/* These functions show/hide the loading animations             */
/****************************************************************/

function loader_show(){
	$("#black_veil").fadeIn("fast", function(){
		
	});
	$("#loader").show();
}

function loader_hide(){

	$("#loader").hide();
	$("#black_veil").fadeOut("fast");
}

/***************************************************************************************/
/* Initializes the input fields so they behave properly onfocus and onblur             */
/***************************************************************************************/

function initInputs(){
	$(document).find("input").each(function(){
		var default_content = jQuery(this).val();
		jQuery(this).focus(function(){
			if (jQuery(this).val() == default_content){
				jQuery(this).val("");
			}
		});
		jQuery(this).blur(function(){
			if (jQuery(this).val() == ""){
				jQuery(this).val(default_content);

				//Updates the graph
				if(typeof update_options == 'function') update_options();
				
			}
		});
	});
}


/*********************************/
/* Renders the chart             */
/*********************************/

function render_chart(opt, theme){

	//gets chart width & height
	var render_div = opt.chart.renderTo;
	var chart_w = $("#"+ render_div).width();
	var chart_h = $("#"+ render_div).height();
	var image_w = 0;
	var image_h = 0;
	var image_ext = '';

	//gets the JSON to find the data for the current theme
	$.getJSON("themes/config.json", function(data){

		//Checks that the theme exists
		if (data.themes[theme] !== undefined){
			
			//Checks if the theme has an image
			if(data.themes[theme].image != null){

				image_w = data.themes[theme].image.width;
				image_h = data.themes[theme].image.height;
				image_ext = data.themes[theme].image.format;

			}
		}
	

		//Sets the correct dimensions for the chart
		opt.chart.width = chart_w;
		opt.chart.height = chart_h;

		if(typeof theme == 'string'){
			//If a theme is specified
			
			$.getScript('themes/js/' + theme + '.js', function(){

				//Once the theme is loaded, renders chart
				if (opt.chart.chart_lib == "highcharts"){

					chart = new Highcharts.Chart(opt, function (chart){

						if (image_w != 0){
							//Add logo to the chart

							//Computes logo position (chart width minus image width minus margin)
							logo_x = chart_w-image_w-(chart_w * .05);
							logo_y = chart_h-image_h-(chart_h * .05);

							//Renders the logo
							chart.renderer.image('themes/images/'+theme+'.'+image_ext, logo_x, logo_y, image_w, image_h)
		        			.add(); 
		        			
		        		}
		        	});
	        	}else if (opt.chart.chart_lib == "responsive"){
	        		
	        		responsive_render(render_div, opt, theme);

	        	}else if (opt.chart.chart_lib == "flotr2"){
	        		
	        		basic_pie(render_div, opt, theme);

	        	}else if (opt.chart.chart_lib == "d3"){

	        		if (opt.chart.defaultSeriesType == "stream"){
	        			$.getScript('visualizations/d3/vis.stream.js', function(){
	        				stream_render(render_div, opt, theme);
	        			});
	        		}

	        	}
			});

		}else{
			//If no theme is specified
			chart = new Highcharts.Chart(opt);
		}

	});

}

function stripslashes (str) {
    // +   original by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +   improved by: Ates Goral (http://magnetiq.com)
    // +      fixed by: Mick@el
    // +   improved by: marrtins
    // +   bugfixed by: Onno Marsman
    // +   improved by: rezna
    // +   input by: Rick Waldron
    // +   reimplemented by: Brett Zamir (http://brett-zamir.me)
    // +   input by: Brant Messenger (http://www.brantmessenger.com/)
    // +   bugfixed by: Brett Zamir (http://brett-zamir.me)
    // *     example 1: stripslashes('Kevin\'s code');
    // *     returns 1: "Kevin's code"
    // *     example 2: stripslashes('Kevin\\\'s code');
    // *     returns 2: "Kevin\'s code"
    return (str + '').replace(/\\(.?)/g, function (s, n1) {
        switch (n1) {
        case '\\':
            return '\\';
        case '0':
            return '\u0000';
        case '':
            return '';
        default:
            return n1;
        }
    });
}

/*
* Checks if a string is a valide email address
*/

function test_email(email){
	var emailReg = new RegExp(/^([a-zA-Z0-9_.-])+@([a-zA-Z0-9_.-])+\.([a-zA-Z])+([a-zA-Z])+/);

    if(emailReg.test(email)) {
    	return true;
    }else{
    	return false;
    }
}