Datawrapper
====================

Datawrapper is a tool that enables to create enticing visualizations in seconds, without any programming skills.

It draws inspiration from ManyEyes and GoogleCharts but remains entirely open-source and independent from a third-party server.

Any developper can add a visualization type, using (or not) a JavaScript library like D3 or Raphael, and a specific theme.

Install
---------------------

To install Datawrapper on your server, download all files from GitHub or do a 'git pull'. Create the appropriate tables in your database using the .sql dump. Then create a file with your database passwords to be stored in /actions/passwords.prod.php under the form

	//DB credentials
	define("DW_HOST", "your_db_hostname");
	define("DW_DATABASE", "your_db_name");
	define("DW_USERNAME", "your_db_username");
	define("DW_PASSWORD", "your_db_password");

	//To be used in Amazon Simple Email Service
	//If none is defined, the server uses PHP mail() function instead
	define("AWS_SECRET", "your_aws_secret");
	define("AWS_ACCESS_KEY", "your_aws_key");

	//gets the base URL to use in the app
	define("BASE_DIR", "your_app_URL");

	//Piwik analytics
	define("PIWIK_PATH", "path_to_your_piwik_server");


v. 0.8.1 Release notes
---------------------
* Improved user and chart objects
* Debugged access to previously made charts
* Corrected bug re: streamgraph legends
* Improvements to translations
* Security flaw fixed
* Various bug fixes

To-Do
---------------------

* Remove the hardcoded elements to visualization building
* Clean the JS in the app
* Improve tutorials
* Improve the responsive table option (auto-resize the iframe)
* Simplifiy the process of adding a JS lib
* Add a fallback solution for less compatible JS libs
* Use gettext in JS

Themes
---------------------

Themes are meant to let organizations create charts that have their own look-and-feel.

Themes are listed in /themes/config.json using the following structure:

	"theme_slug":
	{
	    "name": "theme_slug",
	    "desc": "theme_name",
	    "link": "link_on_logo"
	    "image": {
	        "width": image_width,
	        "height": image_height,
	        "format": "image_extension"
	    },
	    "restricted": ["domain1", "domain2"]
	}

### Theme name

'theme_slug' is the identifier of the theme. 'theme_name' is the long form name that will be displayed (no multi-language support). 

### Theme image

You can specify an image (e.g. the organization's logo) for your theme, to be stored in themes/images/ under the name 'theme_slug'.'image_extension'.

Set "image" to 'null' if you don't have one.

### Restrictions

A theme can be restricted to certain users only, using their e-mail address as a filter. 'restricted' is an array of domain names. Only users with an e-mail address from 'domain1' or 'domain2' will be able to use the theme.

Set 'restricted' to 'null' if the theme is free for all to use.

### Theme structure

Themes are JS files stored in '/themes/js' under the format 'theme_slug'.js.

They use the structure of [Highchart themes](http://www.highcharts.com/ref/#plotOptions)

Visualizations
---------------------

Datawrapper makes it easy to add a new type of visualization.

Visualizations are listed in the file '/visualizations/config.json.php'

### Adding a JS library

	"d3":
	{
	    "name": "D3.js",
	    "dependancies": ["d3/d3.js", "d3/d3.layout.js"],
	    "compatibility": {
	        "IE": "9.0+",
	        "FF": "3.0+",
	        "Chrome": "2.0+",
	        "Safari": "4.0+" 
	    }
	}

'dependancies' is an array of files stored in the '/visualizations/' folder.

'compatibility' lets users know with which browsers the library is compatible. The list of browsers so far only include IE, Firefox, Chrome and Safari. If you haven't tested the library under one of these browsers, just leave the line blank.

### Adding a visualization

	"pie":{
	    "name": "pie",
	    "desc": "'. _("Pie chart").'",
	    "library": "highcharts",
	    "vis_code": "pie.js",
	    "resources":{
	        "'. _("Understanding Pie Charts").'": "http://eagereyes.org/techniques/pie-charts"
	    }
	}

Each visualization is described in the file 'visualizations/config.json.php'. They have a slug_name ('pie' in this case) and a long-form name users will see, under 'desc'. The long-form name is translated using gettext.

Additionally, a visualization can have "ressources" attached to it, which are links (with titles translated) displayed when users click the question mark next to the visualization when building their charts.

The JS file that adapts the csv data to the visualization's needs is stored in 'vis_code'. Files are stored in 'visualizations/types/vis_code'.

### Building a visualization

Visualizations are built in 2 parts. The first part formats the data according to the visualization's needs, the second part builds the actual chart.

The first part is found in the file under 'vis_code'. It takes the variable 'csv_data' and stores the data in the 'options' object.

The second part is built on a ad-hoc basis. In '/js/functions.js', the function render_chart(opt, theme) renders the chart. As of now (see to-do), appropriate functions building the chart are hard-coded. They need to be made dynamic.