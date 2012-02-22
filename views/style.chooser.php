<?php

/****
/*
/*   @desc: Prepares the dropdown menu to choose the style
/*   @author: NKB <hi@nkb.fr>
/*
/****/

require_once 'config.php';

//Fetches the JSON that holds the data about the themes
$file_themes = file_get_contents('themes/config.json');

//Convert file into JSON
$json_themes=json_decode($file_themes);

/* Gets the user's email address domain */

//Gets the email address
$email = $_SESSION["user_email"];

//regex pattern
$pattern = "/^.*@(.*?)$/";

//Executes regex
if (preg_match($pattern, $email, $match))
	$domain = $match[1];


/* Builds the themes options */

//Loop through the themes in the JSON
foreach($json_themes->themes as $theme){

	//init
	$authorized = 0;
	$image_w = 0;
	$image_h = 0;
	$image_ext = 0;
	$desc = "";
	$name = "";
	$selected = "";

	//Checks if the theme is restricted
	if ($theme->restricted != null){
		
		//Looks for the email domain in the restricted list
		if (in_array($domain, $theme->restricted))
			$authorized = 1;

	}else{
		//for themes that are free to use
		$authorized = 1;
	
	}

	//If user has access to the current theme
	if ($authorized){
		
		//Retrieves data about the theme's logo
		if ($theme->image != null){
			$image_w = $theme->image->width;
			$image_h = $theme->image->height;
			$image_ext = $theme->image->format;
		}

		//Retrieves the theme's long name
		$desc = $theme->desc;

		//Retrieves the theme's short name
		$name = $theme->name;

		if ($name == "default")
			$selected = " selected='selected' ";

		echo "<option value='$name' image_w='$image_w' image_h='$image_h' image_ext='$image_ext' $selected >$desc</option>";

	}

} //end themes loop

?>