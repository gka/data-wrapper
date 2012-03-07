<script type="text/javascript">

function initHeader(){
	$(".language").click(function(){

		lang = jQuery(this).attr("lang");
		lang_long = jQuery(this).html();

		$.post("actions/lang_change.php", { lang: lang, lang_long: lang_long }, function(data){
			if (data != ""){

     			data = jQuery.parseJSON(data);

     			if (data.status == 200){
	     			
	     			//Displays the new language
	     			error("<?php echo _("Language set to ") ?>" + data.lang)

	     			//language has changed, reload page
	     			location.reload();

	     		}else if (data.status == 201){

	     			//if the language is the same as the current language
	     			error("<?php echo _("Language is the same as current language.") ?>")
	     			return false;

		     	}else{
	     			error(data.error);	
	     		}
	     	}else{
	     		error("<?php echo _("Could not change language.") ?>")
	     	}
		});

	});

	$("#logo").click(function(){
		
		//goes back home
		location.replace("<?php echo BASE_DIR ?>");
		
	});

	$("#logout").click(function(){

		$.post("actions/user.php", {action:"logout"}, function(data){
			
			if (data != ""){

     			data = jQuery.parseJSON(data);

     			if (data.status == 200){
	     			
	     			//User is no longer logged in, reload page to go to login screen
	     			location.replace("<?php echo BASE_DIR ?>");

	     		}else{
	     			error(data.error);	
	     		}
	     	}else{
	     		error("<?php echo _("Could not log out.") ?>")
	     	}
		});

	});
}
</script>

<div id="header">
	<div id="logo">
	</div>

	<div id="navbar">
		
		<div id="languages">
			<div class="language" lang="de_DE">deutsch</div>
			<span class=".separator"> • </span>
			<div class="language" lang="en_US">english</div>
			<span class=".separator"> • </span>
			<div class="language" lang="fr_FR">français</div>
			
		</div>

		<div id="promo">
			<a href="#quickstart" class="fancybox"><?php echo _("Quickstart") ?></a>
			<span class=".separator"> • </span>
			<a href="#tutorial" class="fancybox"><?php echo _("Tutorial") ?></a>
			<span class=".separator"> • </span>
			<a href="https://github.com/n-kb/data-wrapper" target="_blank"><?php echo _("Fork me on GitHub!") ?></a>
		</div>

		<?php 
		if (isset($user)):
		?>

		<div id="loggedin">

			<div id="my_vis">
				<a href="<?php echo BASE_DIR ?>?vis_list=true"><?php echo _("my data");  ?></a>
			</div>
			
			<div id="logout">
				<?php echo _("Log out"); ?>
			</div>

			<div id="loggedas">
				<?php echo sprintf(_("Welcome, %s!"), $user->getEmail());  ?>
			</div>
		</div>
	
		<?php endif; ?>
	</div>
</div>