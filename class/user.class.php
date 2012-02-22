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

	function __construct(& $db) {  
	      
        // links to the db
        $this->db = & $db;
                
    }

	function getID(){

		if (isset($_SESSION["user_email"])){

			$email = $_SESSION["user_email"];

			$q = "SELECT user_id FROM users WHERE email = '$email' LIMIT 1";

			if ($result =  $this->db->query($q)) {
				
				while ($row = $result->fetch_object()) {

					$id = $row->user_id;
				}

				return $id;
				
			}else{
				//Error with DB
				 return json_encode( Array("status" => 600, "message" => _("Error while trying to retrieve user from database.") ) );
			}
		}
	}

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
				 return json_encode( Array("status" => 600, "message" => _("Error while trying to retrieve show_quickstart from DB.") ) );
			}
		}
	}

	function list_vis(){

		if (isset($_SESSION["user_email"])){

			$user_id = $this->getID();

			$list_vis = array();

			$q = "SELECT chart_id, chart_title, chart_type, date_modified, chart_js_code, chart_csv_data FROM charts WHERE user_id = '$user_id' AND chart_title != '' ORDER BY date_modified DESC";

			if ($result =  $this->db->query($q)) {
				
				$return_array["status"] = "200";
				$return_array["vis"] = array();

				while ($row = $result->fetch_object()) {

					 $chart_url = BASE_DIR . "?c=" . alphaID($row->chart_id);

					 //makes TSV
					 $tsv_data = "";
					 foreach(unserialize($row->chart_csv_data) as $row_data){
					 	foreach ($row_data as $col_data){
					 		$tsv_data .= "$col_data@@TAB@@";
					 	}
					 	$tsv_data .= "@@BREAK@@";
					 }

					 $chart_html = "<h2><a href='javascript:formSubmit(\"". addslashes($row->chart_js_code) ."\", " . $row->chart_id . ", \"". addslashes($row->chart_csv_data) ."\", \"" . $tsv_data . "\");'>" . $row->chart_title ."</a></h2>";
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
				 return array("status" => 600, "message" => _("Error while trying to retrieve list from database.") );
			}
		}else{
			//User not logged in
			return array("status" => 600, "message" => _("User not logged in.") );
		}

	}

	function connect($email, $pwd){

		//Checks that the e-mail and password match
		$q = "SELECT * FROM users WHERE email = '$email' AND pwd = '". md5($pwd) ."' AND activated=1 LIMIT 1";		

		if ($stmt = $this->db->prepare($q)) {

			$stmt->execute();

			$stmt->store_result();

			$num_rows = $stmt->num_rows;

			if ($num_rows == 1){

				//Sets the user_email and returns success
				if ($_SESSION["user_email"] = $email){

					$return_array["status"] = "200";

				}

			}else{

				$return_array["status"] = "604";
				$return_array["error"] = _("User and password do not match or user not activated.");
			}

		}else{

				$return_array["status"] = "600";
				$return_array["error"] = _("Could not check the user credentials in the DB.");
				$return_array["error_details"] = $mysqli->error;
		}

		return $return_array;
	}
}

?>