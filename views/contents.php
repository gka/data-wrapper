<div style="display:none">

	<div id="about_Datawrapper" class="popup" style="overflow:scroll">
		
		<h1><?php echo _("About") ?></h1>
		<h3><?php echo _("What is Datawrapper?") ?></h3>

		<p><b><?php echo _("In short: This is a little tool for journalists. It reduces the time to create and embed a simple chart from hours to seconds.") ?></b></p>

		<h3><?php echo _("Motivation") ?></h3>
		<?php echo _("There are many uses of data in journalism. The first step though is to use data more and often as a basis for reporting. Doing this has become easier, because of the large amounts of data becoming available, thanks to the OpenData movement and other initiatives.") ?></p>

		<p><?php echo _("But there are bottlenecks.") ?></p>

		<p><?php echo _("One is that creating even a simple visual chart and embedding it into a story is still too complex and time consuming. Yes, there are extensive other offerings, like IBM ManyEyes or the growing Google Chart API. They are great. But they have downsides, if used by journalists. For example you often have to store your trials data in public, can't get it out again. Plus, control over the look and feel of your charts is limited or complex to change if you are not a coder.") ?></p>

		<h3><?php echo _("Create simple, embeddable charts in seconds, not hours") ?></h3>
		<p><?php echo _("This is what Datawrapper does: This little tool reduces the time needed to create a correct chart and embed it into any CMS from hours to seconds.") ?></p>

		<p><?php echo _("Furthermore, Datawrapper is not a honey-trap. The data you work with or store is yours and yours alone. Trials are not openly published.") ?></p> 

		<p><?php echo _("On top of that, we encourage news organizations to fork Datawrapper via Github and install it on one of your own servers.") ?></p>
		<p><?php echo _("The CSS is accessible, meaning that in one day you can make sure that the charts generated with Datawrapper have your logo, your visual styles and colours.") ?></p> 

		<p><?php printf(_("A short tutorial on %show to use Datawrapper is here%s."), '<a href="#tutorial" class="fancybox">', "</a>") ?></p>

		<h3><?php echo _("Background") ?></h3>

		<p><?php echo _("Datawrapper was developed for ABZV, a journalism training organization affiliated to BDVZ (German Association of Newspaper Publishers). It is part of our efforts to develop a comprehensive curriculum for data-driven journalism.") ?></p>

		<h3><?php echo _("Features") ?></h3>

		<p><?php echo _("Use of this tool is free.") ?></p>

		<p><?php echo _("Datawrapper 0.1 is a non-commercial, open source software, licensed under the MIT License.") ?></p>

		<p><?php echo _("Datawrapper uses HTML5 Javascript libraries, namely Highcharts and D3.js, with more to come.") ?></p>

		<p><?php echo _("Datawrapper can be forked on GitHub and installed on your own server.") ?></p>

	</div>

	<div id="motivation" class="popup" style="overflow:scroll">
		<h1><?php echo _("Datawrapper: Goals and Features"); ?></h1>

		<p><?php echo _("Data Journalism opens new perspectives to do deeper and better reporting. If Journalists do really know the numbers and the data - locally, regionally or worldwide - this could lead to higher trustability and relevancy. The readers want clear signals, not some muddled up guessing. Datawrapper is a tool that makes working from data to story easier. Data should be the foundation when starting a new story, not an afterthought. In many newsrooms this is the other way round so far. „Infographics“ are usually started when the story is already done. That leads to actionism, omissions and mistakes. "); ?>

		<h2><?php echo _("Open Source"); ?></h2>

		<p><?php echo _("The most important feature of Datawrapper is its fully open source character. Journalists, bloggers and any media company can download this little helper and install it on a private server. The design of the charts can be adjusted to your outfit's style - you can change the colors, the visual style and the logos. This is increasingly important, because in too many „free“ platforms someone is somehow lurking over the journalists shoulder. Not here. ");?>

		<h2><?php echo _("HTML5 Chart Libraries"); ?></h2>

		<p><?php printf(_("Datawrapper uses modern Javascript, HTML5 Libraries like Highcharts oder D3.JS. We want to provide an access to these powerful options. This is a step towards the future as the web prepares for a switch to new visualization options in the near future. So far, especially on news websites, some %sfancy features%s where not used in order to not loose any users who still have incompatible (read: very old) browsers. But developers are about to change their mind. The message to users is: Get a decent browser. Downloading and installing a modern, HTML5 capable browser takes a few minutes and opens the door to many, many future options."), "<a href='http://de.wikipedia.org/wiki/Canvas_(HTML-Element)' target='_blank'>", "</a>"); ?>

		<h2><?php echo _("Visualize fast, very fast"); ?></h2>

		<p><?php echo _("Using Datawrapper you can create a chart in minutes. Interestingly, doing visualization fast is not the goal of Datawrapper. Preparation, thinking, digging into data and make sense of it is still the main work of data journalists. Datawrapper does the visualization job fast, but merely to not stand in the way to publish something cool. Throwing nonsensical data into this will most probably lead to nonsensical results."); ?>

		<h2><?php echo _("Chart types"); ?></h2>

		<p><?php echo _("The development of this (small) tool was more winded than initially thought. No surprise here. The main challenge was to find a way to reduce the number of steps to a minimum and at the same time offer a lot of features and options."); ?>

		<p><?php echo _("This is why this beta version does only have five basic chart types. But it is a start and shows what is possible. In the future we would like to add more compelling visualizations. To do that we need the support of the data journalism community. If you are a developer who is interested in journalism, please help us."); ?>

		<h2><?php echo _("Motivation"); ?></h2>

		<p><?php printf(_("We are data journalists. We believe, that digging into numbers, structures and influence patterns is extremely important. Doing this with a journalist's mind will build trustability in what is reported. And it opens new perspectives, for example to turn media companies into %s trusted data hubs %s. Who wants to join us?"), "<a href='http://www.niemanlab.org/2011/03/voices-news-organizations-must-become-hubs-of-trusted-data-in-an-market-seeking-and-valuing-trust/' target='_blank'>", "</a>"); ?>

	<p>- Mirko Lorenz, Nicolas Kayser-Bril, 2012</p>

	</div>

	<div id="installation" class="popup">
		<p><?php echo _("To install Datawrapper on your server, download all files from GitHub or do a 'git pull'. Create the appropriate tables in your database using the .sql dump. Then create a file with your database passwords to be stored in /actions/passwords.php under the form") ?></p>

		<blockquote>
			<code>&lt;?php<br /> $hostname = "hostname";<br /> $database = "database_name";<br /> $username = "user_name";<br /> $password = "password";<br /> ?&gt;</code>
		</blockquote>

		<p><?php echo _("Then modify the production domain name in /config.php ('$prod_domain') if you do not host your application on CloudControl.") ?></p>
		<p><?php printf(_("If you are a for-profit venture, make sure to %sbuy a license for the use of HighCharts%s."), "<a href='http://shop.highsoft.com/highcharts.html' target='_blank'>","</a>" ) ?></p>
	</div>

	<div id="terms_of_use" class="popup">

		<h1><?php echo _("Terms of use") ?></h1>
		<h2><?php echo _("Fair usage policy") ?></h2>
		<p><?php echo _("Datawrapper is licensed to visualize data that comes from public, legal sources or your own research. Should we detect uses that might violate rights of organizations or single persons we reserve the right to block an account, notify the owner and ask them to stop using Datawrapper.") ?></p>
		<h2><?php echo _("Limited responsibility") ?></h2>
		<p><?php echo _("This service is provided as is. DataStory will certainly not be held accountable if your data is damaged by a server failure or any other cause.") ?></p>
		<h2><?php echo _("Privacy") ?></h2>
		<p><?php echo _("Datawrapper will not use your private data in any way not necessary for the provision of the Service. However, you have the right to ask for the modification or removal of any personal data in accordance with the laws of Germany.") ?></p>
		<p><?php echo _("Note that for installation on your own server a license fee for Highcharts is mandatory.") ?></p>
	</div>
	<div id="impressum" class="popup">

		<h1><?php echo _("Legal imprint") ?></h1>

		<h2><?php echo _("Publisher") ?></h2>
		<p><?php echo _("ABZV • Bildungswerk der Zeitungen, 2011") ?></p>
		<p><?php echo _("The Academy of Vocational Education of the German Newspaper Publishers Association (ABZV) is a training center for German newspapers. Founded in 1989, it supports the efforts of its members and organizes its own seminars.") ?></p>

		<p><?php echo _("Address: In der Wehrhecke 1, 53125, Bonn Germany") ?></p>

		<p><?php echo _("Tel : 0228 - 20 77 66 22 Fax: 0228 - 20 77 66 23 E-Mail: info@abzv.de") ?></p>

		<p><?php echo _("Registered in the Vereinsregister in Bonn under:  20 VR 7689") ?></p>

		<p><?php echo _("In charge of content: Beate Füth (same address).") ?></p>
		<h2><?php echo _("Host") ?></h2>
		<p><?php echo _("CloudControl • Helmholtz-Str. 2-9, D-10587 Berlin") ?></p>
		<h2><?php echo _("Credits") ?></h2>
		<p><?php echo _("Idea/Concept") ?>: Mirko Lorenz, <?php echo _("Development") ?>: Nicolas Kayser-Bril, 2011</p>
	</div>


	<div id="tutorial" class="popup">
		
		<script type="text/javascript">
			
			function tutorial_next(tutorial_id){

				$("#"+(tutorial_id)).hide();

				$("#"+(tutorial_id+1)).show();
			
			}

		</script>

		<h1><?php echo _("Tutorial: How to get good charts out of Datawrapper") ?></h1>

		<div id="1" class="tutorial_class" style="display:block">
			<p><?php echo _("Yes, no one reads the manual, but this one is really short. Here we show you how to get the most out of Datawrapper - what data to look for and how to format it to get a correct, good looking chart. Our tool can help you, but if you feed it the wrong data it will fail.") ?></p>
			
			<h2><?php echo _("Why only five types of charts?") ?></h2>

			<p><?php echo _("We had to start somewhere and we had to stop somewhere. In the future we would like to add more chart types, to this end we are looking for developers/designers. Contact us at ") ?><a href="mailto:info@datastory.de">info@datastory.de</a></p>
			<button class="button_tutorial" onClick="tutorial_next(1)"><?php echo _("On to part 1. Lines") ?> &raquo;</button>
		</div>

		<div id="2" class="tutorial_class">

			<h2><?php echo _("Line chart") ?></h2>
			
			<p><?php echo _("This is easy. You can visualize one or multiple lines. In order to graph them properly here is the best way to prepare your table or spreadsheet.") ?></p>
			
			<p><?php echo _("Your data for a single line should like this:") ?></p>
				<img src="images/tutorial/line.png" />

			<p><a target="_blank" href="https://docs.google.com/spreadsheet/ccc?key=0Ainrk2-JqCiydGpUbkxFM1VObDM4cjZmQ3FjeTQ5OVE&hl=en_US#gid=0"><?php echo _("Sample data for a single line chart.") ?></a></p>
			<button class="button_tutorial" onClick="tutorial_next(2)"><?php echo _("On to part 2. Bar charts") ?> &raquo;</button>
		</div>
		<div id="3" class="tutorial_class">

			<h2><?php echo _("Bar chart") ?></h2>
			
			<p><?php echo _("If you have data describing a certain value say month by month or if you want to compare the revenue of company A with the revenue from company B, a bar chart is the way to go.") ?></p>

			<p><?php echo _("Your data for a bar chart should like this:") ?></p>
				<img src="images/tutorial/bar.png" />

			<p><a target="_blank" href="https://docs.google.com/spreadsheet/ccc?key=0Ainrk2-JqCiydEliVjQ1QjhCQWJZVEpEU0EtejE4ZGc&hl=en_US#gid=0"><?php echo _("Sample dataset for a bar chart.") ?></a></p>
			<button class="button_tutorial" onClick="tutorial_next(3)"><?php echo _("On to part 3. Pie chart") ?> &raquo;</button>
		</div>
		<div id="4" class="tutorial_class">

			<h2><?php echo _("Pie chart") ?></h2>
			
			<p><?php echo _("Careful, pie charts can be misused and then they distort the message. Use a pie chart if you have data that can be compared proportionally - say, to show how after an election 100 per cent of the vote are spread to the various political parties.") ?></p> 

			<p><?php echo _("Do not use a pie chart if there are to many labels. Often a bar chart is better than a pie chart to show the relation and trend.") ?><a target="_blank" href="http://en.wikipedia.org/wiki/Pie_chart"><?php echo _(" Read more about pie charts.") ?></a></p>

			<p><?php echo _("By the way: In a correct pie chart the biggest pie should start at twelve o'clock. And just forget about the shadows and 3D effects of desktop programs. This will get you into a shitstorm.") ?></p>

			<p><?php echo _("Your data for a pie chart should like this:") ?></p>
				<img src="images/tutorial/pie.png" />

			<p><a target="_blank" href="https://docs.google.com/spreadsheet/ccc?key=0Ainrk2-JqCiydEliVjQ1QjhCQWJZVEpEU0EtejE4ZGc&hl=en_US#gid=0"><?php echo _("Sample dataset for a bar chart.") ?></a></p>
			<button class="button_tutorial" onClick="tutorial_next(4)"><?php echo _("On to part 4. Streamgraph") ?> &raquo;</button>
		</div>
		<div id="5" class="tutorial_class">

			<h2><?php echo _("Streamgraph") ?></h2>
			
			<p><?php echo _("This is our fancy graph. You can use this form to show the pattern of a lot of data over long periods of time. Some people love these, some hate them (because what the chart really says is sometimes a mystery).") ?><a href="http://www.leebyron.com/else/streamgraph/"><?php echo _(" Here is a long paper for all of you who want to learn more.") ?></a></p>

			<p><?php echo _("A streamgraph will effectively draw lines and fill the space between these. This is good to display how music preferences have changed over time or how certain topics have been cited more or less often.") ?></p>

			<p><?php echo _("Your data for a streamgraph should like this:") ?></p>
				<img src="images/tutorial/streamgraph.png" />

			<p><a target="_blank" href="https://docs.google.com/spreadsheet/ccc?key=0Aj910EQuus3bdHZVdEhtNVhsMDhFdVNiMDlOVG5BZ3c"><?php echo _("Sample dataset for a streamgraph.") ?></a></p>
			<p><?php echo _("If you have better examples, better datasets or just want to vent off, contact us via") ?> <a href="mailto:info@datastory.de">info@datastory.de</a></p>

			<button class="button_tutorial" onClick="$.fancybox.close();"><?php echo _("Let's go!") ?></button>
		</div>
	</div>




	<div id="quickstart" class="popup">
		<script type="text/javascript">
			function quickstart_noshow(){
				var checked = $("input[@id='quickstart_noshow_box']:checked").length;
				if (checked){
					$.post("actions/quickstart_noshow.php", { checked: checked },
   						function(data) {
   							if (data != ""){

				     			data = jQuery.parseJSON(data);

				     			if (data.status == 200){
				     				
				     				//changes the text on the page
				     				$("#quickstart_noshow_text1").hide();
				     				$("#quickstart_noshow_text2").show();

				     			}else{
				     				error(data.error);
				     			}

				     		}else{
				     			error();
				     		}
	   					}
	   				);
            
				}else{
					return null;
				}
			}
		</script>

		<h1><?php echo _("Quickstart") ?></h1>

		<h2><?php echo _("Using Datawrapper is simple") ?></h2>
		
		<ol>
			<li><!-- 1 -->
				<?php echo _("Search for a data set - can be an Excel chart, a Google Table or even a table in any web page. Make sure that the data has no copyright restrictions for further use. ") ?>
			</li>
			<li><!-- 2 -->
				<?php echo _("Copy the table ") ?>
			</li>
			<li><!-- 3 -->
				<?php echo _("Go to Datawrapper and drop the content into the first screen") ?>
			</li>
			<li><!-- 4 -->
				<?php echo _("Click next and check your data.") ?>
			</li>
			<li><!-- 5 -->
				<?php echo _("Click next and you see the options for visualization") ?>
			</li>
			<li><!-- 6 -->
				<?php echo _("Still on this screen you have options to add a description, a link to the source, etc.") ?>
			</li>
			<li><!-- 7 -->
				<?php echo _("Click next, check the visualization, copy the embed code and off you go.  ") ?>
			</li>
		</ol>
		<p>
			<?php printf(_("Datawrapper has some other interesting functions, which you can experience %sin our tutorial%s."),'<a href="#tutorial" class="fancybox">',"</a>") ?>
		</p>
		<button class="button_tutorial" onClick="$.fancybox({href:'#tutorial', 'hideOnContentClick': false});"><?php echo _("On to the tutorial ") ?>&raquo;</button>

		<?php
		if (isset($user)):
			//shows only if user hasn't deactivated quickstart 
			if ($user->show_quickstart()):
		?>
		<div id="quickstart_noshow">
			<span id="quickstart_noshow_text1"><input type="checkbox" id="quickstart_noshow_box" onclick="quickstart_noshow()"><?php echo _("Do not show again on start-up.") ?></span>
			<span id="quickstart_noshow_text2" style="display:none;"><?php echo _("This quick tutorial will not be shown again.") ?></span>
		</div>
		<?php
			//ends if user hasn't deactivated quickstart
			endif;
			//end if no user is set
		endif;
		?>

	</div>
	
</div>