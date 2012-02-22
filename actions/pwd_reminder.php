<?php

/****
/*
/*   @desc: Sends an email to the user for her to renew her password 
/*   @author: NKB <hi@nkb.fr>
/*
/****/

require_once "../config.php";
require_once "../libraries/ses.php";

if (isset($_POST['email'])){

	//declares AWS SES object
	$ses = new SimpleEmailService($aws_access_key, $aws_secret);

	//Gets data that was sent over POST
	$email = $_POST['email'];

	//Checks that the e-mail is in the DB
	$q = "SELECT * FROM users WHERE email = '$email' LIMIT 1";

	if ($result = $mysqli->query($q)) {

		$num_rows = $result->num_rows;

		if ($num_rows == 1){

			//generates a new token
			$token = genRandomString();

			//Deletes the previous password hash and inserts new token
			$q_rm_pwd = "UPDATE users SET token='$token' WHERE email='$email'";

			if ($result = $mysqli->query($q_rm_pwd)) {

				//Prepares verify email
				$confirm_link = BASE_DIR."/?new_pwd=$token&email=$email";

				$to      = $email;

				$from_address = "debug@Datawrapper.de";

				$subject = '[Datawrapper] '. _("Password change requested");
				
				$message = _("Dear Datawrapper user,");
				$message .= "\r\n\r\n";
				$message .=	_("Please click on the link below to change your password: ");
				$message .= "\r\n\r\n";
				$message .=	"$confirm_link";
				$message .= "\r\n\r\n";
				$message .= _("Do ignore this message if you did not request a password change from Datawrapper.");
				$message .= "\r\n\r\n";
				$message .= _("Thanks!");
				$message .= "\r\n\r\n";
				$message .= _("The Datawrapper team");

				$m = new SimpleEmailServiceMessage();
				$m->addTo($to);
				$m->setFrom($from_address);
				$m->setSubject($subject);
				$m->setMessageFromString($message);

				$ses->enableVerifyPeer(false);

				//Sends email
				if ($ses->sendEmail($m))
					$return_array["status"] = "200";

				else{

					$return_array["status"] = "600";
					$return_array["error"] = _("Could not send password change e-mail.");

				}
					
			
			}else{

				$return_array["status"] = "600";
				$return_array["error"] = _("Could not send password change email.");
				$return_array["error_details"] = $mysqli->error;

			}

		}else{

			$return_array["status"] = "605";
			$return_array["error"] = _("No user found with this email address.");
		}

	}else{

		$return_array["status"] = "600";
		$return_array["error"] = _("Could not send password change email.");
		$return_array["error_details"] = $mysqli->error;
	}
}else{

	$return_array["status"] = "603";
	$return_array["error"] = _("Not enough parameters were passed.");

}


echo json_encode($return_array);
?>