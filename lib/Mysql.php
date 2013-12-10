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
		        array_push($arrData,$row);
		    }
		}
	    return $arrData;
	}




	public function getAccounts() {
		$query1 = 'SELECT "" AS Ketegorie, "" AS Branche, "Firma" AS Kontaktart, LEFT(a.name,80) AS Name1, "" AS Name2, "" AS Anrede, "" AS Titel, 
		a.billing_address_street AS Adresse, a.billing_address_postalcode AS PLZ, a.billing_address_city AS Ort, 
		a.billing_address_country AS Land, c.email_address AS Email, "" AS Email2, a.phone_office AS Telefon, a.phone_alternate AS Telefon2,
		"" AS Mobile, TRIM(a.phone_fax) AS Fax, a.website AS Webseite, "" AS Skype, "" AS Anredeform, "" AS Geburtstag, a.description AS Bemerkung,
		"steven" AS Ansprechpartner, "" AS Sprache
		FROM accounts AS a
		LEFT JOIN email_addr_bean_rel AS b ON a.id = b.bean_id 
		LEFT JOIN email_addresses AS c ON b.email_address_id = c.id
		GROUP BY a.name;';

		$arrAccounts = $this->do_query($query1);
		return $arrAccounts;
	}

	public function getContactsById($id) {
		$query = 'SELECT "" AS Ketegorie, "" AS Branche, d.salutation AS Anrede, "" AS Titel,  d.last_name AS Nachname, d.first_name AS Vorname,
		d.primary_address_street AS Adresse, d.primary_address_postalcode AS PLZ, d.primary_address_city AS Ort, d.primary_address_country AS Land,
		f.email_address AS Email, "" AS Email2, d.phone_home AS Telefon, d.phone_other AS Telefon2, d.phone_mobile AS Mobile, d.phone_fax AS Fax,
		"" AS Webseite, "" AS Skype, d.title AS Funktion, "" AS Anredeform, d.birthdate AS Geburtstag, d.description AS Bemerkungen,
		"" AS Ansprechpartner, "" AS Sprache 
		FROM contacts AS d
		LEFT JOIN email_addr_bean_rel AS e ON d.id = e.bean_id 
		LEFT JOIN email_addresses AS f ON e.email_address_id = f.id
		where d.`id` = "' . $id .'"';

		$arrContact = $this->do_query($query);
		return $arrContact;
	}


	public function getContactIdFromAccountName($name){
		$query = 'select a.`id` as account_id, a.`name`,c.`id` as contact_id, c.`first_name`, c.`last_name`
		from accounts as a
		join accounts_contacts as b on a.id = b.`account_id`
		join contacts as c on b.`contact_id` = c.`id`
		where a.`name` like "'.$name.'"
		group by c.`first_name`,c.`last_name`
		;';

		$arrData = $this->do_query($query);
		return $arrData;
	}



}

?>