<?php
error_reporting(E_ALL);
date_default_timezone_set("GMT");

include 'lib/Logger.php';
include 'lib/Mysql.php';

class Csv {
	public function fwritecsv($handle, $fields, $delimiter = ',', $enclosure = '"') {
	    # Check if $fields is an array
	    if (!is_array($fields)) {
	        return false;
	    }
	    # Walk through the data array
	    for ($i = 0, $n = count($fields); $i < $n; $i ++) {
	        # Only 'correct' non-numeric values
	        if (!is_numeric($fields[$i])) {
	            # Duplicate in-value $enclusure's and put the value in $enclosure's
	            $fields[$i] = $enclosure . str_replace($enclosure, $enclosure . $enclosure, $fields[$i]) . $enclosure;
	        }
	        # If $delimiter is a dot (.), also correct numeric values
	        if (($delimiter == '.') && (is_numeric($fields[$i]))) {
	            # Put the value in $enclosure's
	            $fields[$i] = $enclosure . $fields[$i] . $enclosure;
	        }
	    }
	    # Combine the data array with $delimiter and write it to the file
	    $line = implode($delimiter, $fields) . "\n";
	    fwrite($handle, $line);
	    # Return the length of the written data
	    return strlen($line);
	}
}


$header = array(
	'Kategorie',
	'Branche',
	'Kontaktart',
	'Name 1',
	'Name 2',
	'Anrede',
	'Titel',
	'Adresse',
	'PLZ',
	'Ort',
	'Land',
	'Email',
	'Email 2',
	'Telefon',
	'Telefon 2',
	'Mobile',
	'Fax',
	'Website',
	'Skype',
	'Anredeform',
	'Geburtsdatum',
	'Bemerkungen',
	'Ansprechpartner',
	'Sprache'
);

$key = 1;

$kontaktperson = array(
	'Kontaktperson '.$key.' Kategorie',
	'Kontaktperson '.$key.' Branche',
	'Kontaktperson '.$key.' Anrede',
	'Kontaktperson '.$key.' Titel',
	'Kontaktperson '.$key.' Nachname',
	'Kontaktperson '.$key.' Vorname',
	'Kontaktperson '.$key.' Adresse',
	'Kontaktperson '.$key.' PLZ',
	'Kontaktperson '.$key.' Ort',
	'Kontaktperson '.$key.' Land',
	'Kontaktperson '.$key.' Email',
	'Kontaktperson '.$key.' Email 2',
	'Kontaktperson '.$key.' Telefon',
	'Kontaktperson '.$key.' Telefon 2',
	'Kontaktperson '.$key.' Mobile',
	'Kontaktperson '.$key.' Fax',
	'Kontaktperson '.$key.' Website',
	'Kontaktperson '.$key.' Skype',
	'Kontaktperson '.$key.' Funktion',
	'Kontaktperson '.$key.' Anredeform',
	'Kontaktperson '.$key.' Geburtstag',
	'Kontaktperson '.$key.' Bemerkungen',
	'Kontaktperson '.$key.' Ansprechpartner',
	'Kontaktperson '.$key.' Sprache'
);


foreach ($kontaktperson as $value) {
	array_push($header,$value);
}


$fp = fopen('file.csv', 'w');

$csv = new Csv();

$csv->fwritecsv($fp,$header,";");

$log = new Logger();
// $log->info("Info");
// $log->warn("Warnung");
// $log->err("Fehler");


$db = new Mysql();


$arrBvDb = array();
$qry = $db->do_query("SELECT * FROM users");
var_dump($qry);







fclose($fp);


?>