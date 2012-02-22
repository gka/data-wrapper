<?php

/****
/*
/*   @desc: Changes the locale
/*   @author: NKB <hi@nkb.fr>
/*
/****/

require_once "../config.php";

if (isset($_POST["lang"])){

	$lang = $_POST["lang"];
	$lang_long = $_POST["lang_long"];

	//Detects the current locale
	$current_locale =  getLocale(false, false);
	
	//if the demanded language is different from the current one
	if (trim($current_locale) !== trim($lang.".UTF-8")){

		$pattern = "/[a-z]_[A-Z]/";

		//Checks that the locale is correctly set
		if (preg_match($pattern, $lang)){

			//sets the language
			$newLocale = setLanguage($lang);
			$return_array["status"] = "200";
			$return_array["lang"] = $lang_long;
		
		//if the language doesn't match the regex
		}else{
			$return_array["status"] = "603";
			$return_array["error"] = _("Unknown language code.");
		}

	//if the language wasn't changed
	}else{
		$return_array["status"] = "201";
	}

	echo json_encode($return_array);

}


?>