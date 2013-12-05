<?php

class Mysql {

	// DB settings
	private $_db_host = '127.0.0.1';
	private $_db_user = 'root';
	private $_db_pass = '123123';
	private $_db_db = 'sugarcrm';

	private $_mysqli;

	public function __construct() {
		//Datenbankverbindung
		$mysqli = @new mysqli($this->_db_host, $this->_db_user, $this->_db_pass, $this->_db_db);

		if ($mysqli->connect_errno) {
		    printf("Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error);
		}
		/* change character set to utf8 */
		// if (!$mysqli->set_charset("utf8")) {
		//     printf("Error loading character set utf8: " . $mysqli->error, TRUE);
		// } else {
		//     printf("Current character set: " . $mysqli->character_set_name(), TRUE);
		// }
		$this->_mysqli = $mysqli;
	}

	public function do_query($query) {	   	    
	    try {
	        $res = $this->_mysqli->query($query);    
	        if (!$res) {
	            throw new Exception($this->_mysqli->error, 1);	            
	        }
	    } catch (Exception $e) {
	        echo $e->getMessage();
	        echo "\n" . $query ."\n";	   
	    } 

	    $arrData = array();
	    while (($row = mysqli_fetch_assoc($res))) {
		    if (count($row) > 0) {
		        $arrData = $row;
		    }
		}
	    return $arrData;
	}

}

?>