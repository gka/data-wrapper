<?php

/****
/*
/*   @desc: Signs up new users and logs them in 
/*   @author: NKB <hi@nkb.fr>
/*
/****/

require_once "../config.php";
require_once "../libraries/ses.php";

if (isset($_POST['email']) && isset($_POST['pwd'])){


	//declares AWS SES object
	$ses = new SimpleEmailService($aws_access_key, $aws_secret);

	//Gets data that was sent over POST
	$email = $_POST['email'];
	$pwd = $_POST['pwd'];

	//Checks that the e-mail is not in the DB
	$q = "SELECT * FROM users WHERE email = '$email' LIMIT 1";

	if ($result = $mysqli->query($q)) {

		$num_rows = $result->num_rows;

		if ($num_rows == 0){

			//generates a new token
			$token = genRandomString();

			//Creates a new user
			$q_adduser = "INSERT INTO users (email, pwd, date_created, token) VALUES ('$email', '". md5($pwd) ."', '". date('Y-m-d H:i:s') ."', '$token')";

			if ($result = $mysqli->query($q_adduser)) {

				//Prepares verify email
				$confirm_link = BASE_DIR."/?verify=$token&email=$email";

				$to      = $email;

				$from_address = "debug@datawrapper.de";

				$subject = '[Datawrapper] '. _("Please verify your e-mail address");
				
				$message = _("Dear Datawrapper user,");
				$message .= "\r\n\r\n";
				$message .=	_("Please click on the link below to verify your e-mail address: ");
				$message .= "\r\n\r\n";
				$message .=	"$confirm_link";
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
					$return_array["error"] = _("Could not send verification e-mail.");

				}
					
			
			}else{

				$return_array["status"] = "600";
				$return_array["error"] = _("Could not add user in the DB.");
				$return_array["error_details"] = $mysqli->error;

			}

		}else{

			$return_array["status"] = "605";
			$return_array["error"] = _("A user already has this email address.");
		}

	}else{

		$return_array["status"] = "600";
		$return_array["error"] = _("Could not add user in the DB.");
		$return_array["error_details"] = $mysqli->error;
	}
}else{

	$return_array["status"] = "603";
	$return_array["error"] = _("Not enough parameters were passed.");

}


echo json_encode($return_array);
?>