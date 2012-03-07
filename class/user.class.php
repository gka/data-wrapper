<?php

/**
 * @desc: Manages users
 *
 * @author: nkb
 *
 */


class User { 

	public $id;
	public $email;
	protected $db;

	//Status message to communicate with the front
	public $status;
	public $error;
	public $error_details;

	function __construct(& $db) {  
	      
        // links to the db
        $this->db = & $db;
    }

    function setID($id){
    	$this->id = $id;
    }

	function getID(){

		if (isset($this->id))
			return $this->id;

		elseif (isset($_SESSION["user_email"])){

			$email = $_SESSION["user_email"];

			$q = "SELECT user_id FROM users WHERE email = '$email' LIMIT 1";

			if ($result =  $this->db->query($q)) {
				
				if ($result->num_rows > 0){

					while ($row = $result->fetch_object()) {

						$id = $row->user_id;
					}

					$this->setID($id);

					return $id;
				}else{
					$this->error(_("No user found."));
				}
				
			}else{
				//Error with DB
				$this->error(_("Could not fetch the data in the database."), $this->db->error);
			}
		}
	}

	function getEmail(){

		if ($this->email != null)
			return $this->email;

		elseif ($this->id != null){

			$q = "SELECT email FROM users WHERE user_id = '". $this->id ."' LIMIT 1";

			if ($result =  $this->db->query($q)) {
				
				while ($row = $result->fetch_object()) {

					$email = $row->email;
				}

				$this->email = $email;

				return $this->email;
				
			}else{
				//Error with DB
				$this->error(_("Could not fetch the data in the database."), $this->db->error);
			}
		}
	}


	/*   
	 *	@desc: Disable the quickstart panel
	 */

	function show_quickstart(){

		if (isset($_SESSION["user_id"])){

			$user_id = $_SESSION["user_id"];

			$q = "SELECT quickstart_show FROM users WHERE user_id = '$user_id' LIMIT 1";

			if ($result =  $this->db->query($q)) {
				
				while ($row = $result->fetch_object()) {

					$quickstart_show = $row->quickstart_show;
				}

				return $quickstart_show;
				
			}else{
				//Error with DB
				$this->error(_("Could not fetch the data in the database."), $this->db->error);
			}
		}
	}

	/*   
	 *	@desc: Lists all visualizations from the user
	 */

	function list_vis(){

		if (isset($_SESSION["user_email"])){

			$user_id = $this->getID();

			$list_vis = array();

			$q = "SELECT chart_id, chart_title, chart_type, date_modified FROM charts WHERE user_id = '$user_id' AND chart_title != '' ORDER BY date_modified DESC";

			if ($result =  $this->db->query($q)) {
				
				$return_array["status"] = "200";
				$return_array["vis"] = array();

				while ($row = $result->fetch_object()) {

					 $chart_url = BASE_DIR . "?c=" . alphaID($row->chart_id);


					 $chart_html = "<h2><a href='index.php?m=" . $row->chart_id . "'>" . $row->chart_title ."</a></h2>";
					 $chart_html .= "<p>"._("Last modified on"). " ";
					 $chart_html .= date("F j, Y, g:i a", strtotime($row->date_modified)) ."<br/>";
					 $chart_html .= _("Chart type: ");
					 $chart_html .= $row->chart_type . "<br/>";
					 $chart_html .= _("Visualization URL: ");	
					 $chart_html .=	"<a href='$chart_url' target='_blank'>";	 
					 $chart_html .= $chart_url;
					 $chart_html .= "</a>";
					 $chart_html .= "</p>";
					 $return_array["vis"][] = $chart_html;
				}

				if (count($return_array["vis"]) == 0)
					$return_array["vis"][] = _("No visualization was found");

				return $return_array;
				
			}else{
				//Error with DB
				$this->error(_("Could not fetch the data in the database."), $this->db->error);
			}
		}else{
			//User not logged in
			$this->error(_("User not logged in."));
		}

	}

	/*   
	 *	@desc 	Checks if the user owns a chart
	 * 	@return True if she does, false otherwise
	 */

	function own_vis($chart_id){

		$q = "SELECT chart_id, user_id FROM charts WHERE user_id = '". $this->id . "' AND chart_id = '". $chart_id ."'";

			if ($result =  $this->db->query($q)) {
				if ($result->num_rows == 1)
					return true;
				else
					return false;
			}else{
				$this->error(_("Could not fetch the data in the database."), $this->db->error);
			}
	}

	/*   
	 *	@desc: Prevents the quickstart div to appear
	 */

	function quickstart_noshow(){

		if (isset($_SESSION["user_id"])){

			$id = $_SESSION["user_id"];

			if (isset($_POST['checked'])) {

				$q = "UPDATE users SET quickstart_show=0 WHERE user_id=$id ";

				if ($this->db->query($q)){

					$this->status = "200";
				
				}else{
					
					$this->error(_("Could not fetch the data in the database."), $this->db->error);
					
				}

			}else{

				$this->error(_("No action required."));

			} 
		}

	}


	/*   
	 *	@desc: Sends an email to change password
	 */

	function pwd_reminder(){

		if (isset($_POST['email'])){

			//Gets data that was sent over POST
			$email = $_POST['email'];

			//Checks that the e-mail is in the DB
			$q = "SELECT * FROM users WHERE email = '$email' LIMIT 1";

			if ($result = $this->db->query($q)) {

				$num_rows = $result->num_rows;

				if ($num_rows == 1){

					//generates a new token
					$token = genRandomString();

					//Deletes the previous password hash and inserts new token
					$q_rm_pwd = "UPDATE users SET token='$token' WHERE email='$email'";

					if ($result = $this->db->query($q_rm_pwd)) {

						//Prepares verify email
						$confirm_link = BASE_DIR."?new_pwd=$token&email=$email";

						$to      = $email;

						$from_address = "Datawrapper <debug@datawrapper.de>";

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

						if ($this->sendEmail($message, $to, $from_address, $subject))
							$this->status = "200";

						else{

							$this->error(_("Could not send email."));

						}
							
					}else{

						$this->error(_("Could not fetch the data in the database."), $this->db->error);

					}

				}else{

					$this->error(_("No user found with this email address."));
				}

			}else{

				$this->error(_("Could not fetch the data in the database."), $this->db->error);
			}
		}else{

			$this->error(_("Not enough parameters were passed."));

		}

	}

	/*   
	 *	@desc: Changes the password
	 */

	function pwd_change(){

		if (isset($_POST["token"])){
	
			$token=$_POST["token"];
			$email=$_POST["email"];
			$pwd=$_POST["pwd"];

			//Checks that the token is valid
			$q = "SELECT * FROM users WHERE email = '$email' AND token='$token' LIMIT 1";

			if ($result = $this->db->query($q)) {

				$num_rows = $result->num_rows;

				if ($num_rows == 1){
					
					//query to change password
					$q_change_pwd = "UPDATE users SET pwd='". md5($pwd) ."' WHERE email='$email'";

					if ($result = $this->db->query($q_change_pwd)) {
						//success
						$this->status = "200";

					}else{
						//failed to update user table
						$this->error(_("Could not fetch the data in the database."), $this->db->error);

					}
				//token is not valid
				}else{

					$this->error(_("No request for new password from this email address."));
				}
			//unable to complete query
			}else{
				$this->error(_("Could not fetch the data in the database."), $this->db->error);
			}

		}else{

			$this->error(_("No password change request from this email address."));

		}

	}


	/*   
	 *	@desc: Creates new user
	 */

	function signup(){

		if (isset($_POST['email']) && isset($_POST['pwd'])){

			//Gets data that was sent over POST
			$email = $_POST['email'];
			$pwd = $_POST['pwd'];

			//Checks that the e-mail is not in the DB
			$q = "SELECT * FROM users WHERE email = '$email' LIMIT 1";

			if ($result = $this->db->query($q)) {

				$num_rows = $result->num_rows;

				if ($num_rows == 0){

					//generates a new token
					$token = genRandomString();

					//Creates a new user
					$q_adduser = "INSERT INTO users (email, pwd, date_created, token) VALUES ('$email', '". md5($pwd) ."', '". date('Y-m-d H:i:s') ."', '$token')";

					if ($result = $this->db->query($q_adduser)) {

						//Prepares verify email
						$confirm_link = BASE_DIR."?verify=$token&email=$email";

						$to      = $email;

						$from_address = "Datawrapper <debug@datawrapper.de>";

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

						//Sends email
						if ($this->sendEmail($message, $to, $from_address, $subject))
							$this->status = "200";

						else{

							$this->error(_("Could not send verification email."));

						}
							
					
					}else{

						$this->error(_("Could not fetch the data in the database."), $this->db->error);

					}

				}else{

					$this->error(_("A user already has this email address."));
				}

			}else{

				$this->error(_("Could not add user in the DB."), $this->db->error);
			}
		}else{

			$this->error(_("Not enough parameters were passed."));

		}
	}

	/*   
	 *	@desc: Checks the credentials of the user
	 */

	function connect(){
		
		if (isset($_POST['email']) && isset($_POST['pwd'])){

			//Gets data that was sent over POST
			$email = $_POST['email'];
			$pwd = $_POST['pwd'];
			
			//Checks that the e-mail and password match
			$q = "SELECT user_id FROM users WHERE email = '$email' AND pwd = '". md5($pwd) ."' AND activated=1 LIMIT 1";		

			if ($result = $this->db->query($q)) {

				if ($result->num_rows){

					while ($row = $result->fetch_object()) {

						$id = $row->user_id;
					}

					//Sets the user_email and returns success
					if ($_SESSION["user_email"] = $email){
						
						$this->setID($id);

						$this->status = "200";

					}

				}else{

					$this->error(_("User and password do not match or user not activated."));
				}

			}else{

					$this->error(_("Could not fetch the data in the database."), $this->db->error);
			}
		}else{

				$this->error(_("Not enough parameters were passed."));

		}

	}


	/*   
	 *	@desc: Logs out
	 */

	function logout(){

		unset($_SESSION["user_id"]);
		unset($_SESSION["user_email"]);

		if ( !isset($_SESSION["user_id"]) && !isset($_SESSION["user_email"])){

			$this->status = "200";

		}else{

			$this->error(_("Could not log out."));

		}

	}

	/*   
	 *	@desc: Verifies the e-mail address
	 */

	function verify(){

		$token=$_GET["verify"];
		$email=$_GET["email"];

		//checks that the user exists
		$q = "SELECT user_id FROM users WHERE email='$email' && token='$token'";

		if ($result = $this->db->query($q)){

			if ($result->num_rows > 0){

				//updates the DB
				$q_update = "UPDATE users SET activated=1 WHERE email='$email' && token='$token'";

				if ($this->db->query($q_update)){
			
					//Sets the user email in the session var
					$_SESSION["user_email"] = $email;

					//reloads page
					header("location:". BASE_DIR);
			

				}else{

					//DB problem
					require_once "views/error.php";
	
				}

			}else{
				//no address exists
				require_once "views/error.php";
			}
		}else{

		//DB problem
		require_once "views/error.php";

		}
	}


	/*   
	 *	@desc: Takes care of errors within the class
	 */

	function error($error_msg, $error_details = null){
		$this->status = "600";
		$this->error = $error_msg;
		$this->error_details = $error_details;
	}

	function sendEmail($message, $to, $from, $subject){

		if (defined('AWS_ACCESS_KEY')){
			//uses Amazon's SES

			//declares AWS SES object
			$ses = new SimpleEmailService(AWS_ACCESS_KEY, AWS_SECRET);

			$m = new SimpleEmailServiceMessage();
			$m->addTo($to);
			$m->setFrom($from);
			$m->setSubject($subject);
			$m->setMessageFromString($message);

			$ses->enableVerifyPeer(false);

			//Sends email
			if ($ses->sendEmail($m))
				return true;
			else
				return false;
		}else{
			//uses mail()

			if (mail($to, $subject, $message))
				return true;
			else
				return false;
		}
	}

}

?>