<?php

	/*********************************************************************************
	*** Languages functions library
	*
	* @author	Development Team (XL) <contact@web-e-tic.fr>
	* @desc		
	*********************************************************************************/

	/** Function setLanguage
	* @author	Development Team (XL based on Yosra's) <contact@web-e-tic.fr>
	* @desc		set language info for gettext stuff and co
	*
	* @param	$lang		: string ; looks like "fr_FR" or "en_US" ...
	* @param	$domain		: string ; typically the name of the language files
	* @param	$baseFolder	: string ; under the document root ; it's the folder that contain sth like "fr_FR/LC_MESSAGES/*.[pm]o"
	* @return	the new locale
	*/

	function setLanguage($lang, $domain = "messages", $baseFolder = "") {

				$baseFolder = dirname(__FILE__)."/../locale";
				
				$_SESSION["lang"] = $lang;

                $codeset = "UTF-8";
                
				putenv("LC_ALL=$lang");
				putenv("LANG=$lang.$codeset");
                putenv("LANGUAGE=$lang.$codeset");

                $newLocale = setlocale(LC_ALL, "$lang.$codeset");

                bindtextdomain($domain, $baseFolder);
                bind_textdomain_codeset($domain, $codeset);
				textdomain($domain);

				return $newLocale;
                
	}

	/** Function getLocale
	* @author	NKB <hi@nkb.fr>
	* @desc		Rerturns current locale
    * @param 	check: Checks if the returned locale is valid, sends back en_US if not
    * @param 	trim: trims the UTF-8 after the locale
	*/


	function getLocale($check=true, $trim=true){

		//Detects the current locale
		$current_locale =  setlocale(LC_ALL, '0');

		if ($check){
			
			$pattern = "/[a-z]_[A-Z]\.UTF-8/";

			//Checks that the locale is correctly set (won't work on Windows systems)

			if (!(preg_match($pattern, $current_locale))) //if the current locale is not correctly formatted
				$returned_locale = "de_DE.UTF-8";

			else //correctly formatted
				$returned_locale = $current_locale;

		}else{ //check is false,returns row locale
			$returned_locale = $current_locale;
		}

		if ($trim)
			$returned_locale = substr($returned_locale, 0, 5);

		return $returned_locale;

	}

	/** Function initLanguage
	* @author	Pierre Romera, Team 22mars <pierre.romera@gmail.com>
	* @desc		Define application language
        * 
	*/
        if(! function_exists("initLanguage") ) {

            function initLanguage() {

                if(isset($_GET["lang"]))
                     setLanguage($_GET["lang"]);

                elseif( isset($_SESSION["lang"]) )
                     setLanguage($_SESSION["lang"]);

                else setLanguage("de_DE");

            }
        }

?>