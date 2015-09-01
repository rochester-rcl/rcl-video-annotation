<?php
	include 'config.php';
	header("content-type:application/json");
	error_reporting(E_ALL | E_STRICT);
    	ini_set("display_errors", 2);	
        
$postAction = filter_input(INPUT_POST,'action');
$getAction =  filter_input(INPUT_GET,'action');


	
if ($postAction == "retrieveData") {

try {
	$connection = new PDO("mysql:host=$server;dbname=videoAnnotation", $username, $password);
	
	$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	//echo "Connected successfully";
    }

catch(PDOException $e)
    {
	//echo "Connection failed: " . $e->getMessage();
    }
$filmName = filter_input(INPUT_POST, 'filmName');
    
$myResult = $connection->query("SELECT markerType, start, end, text, target FROM $filmName ORDER BY start");

$results = $myResult->fetchAll(PDO::FETCH_ASSOC);

$resultsJSON = json_encode($results);

echo($resultsJSON);

$connection = null;
}
    

if ($postAction == "postNewRecord" ) {

try {
	$connection = new PDO("mysql:host=$server;dbname=videoAnnotation", $username, $password);
	
	$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	//echo "Connected successfully";
    }

catch(PDOException $e)
    {
	//echo "Connection failed: " . $e->getMessage();
    }

$filmName = filter_input(INPUT_POST, 'filmName');
$markerType = filter_input(INPUT_POST, 'markerType');
$timestamp = filter_input(INPUT_POST, 'timecode');
$start = filter_input(INPUT_POST, 'start');
$end = filter_input(INPUT_POST, 'end');
$text = filter_input(INPUT_POST, 'text');
$target = filter_input(INPUT_POST, 'target');


$insertTest = $connection->prepare("INSERT INTO $filmName SET filmName=:filmName, markerType=:markerType, timestamp=:timestamp, start=:start, end=:end, text=:text, target=:target");

$insertTest->bindValue(':filmName', $filmName, PDO::PARAM_STR);
$insertTest->bindValue(':markerType', $markerType, PDO::PARAM_STR);
$insertTest->bindValue(':timestamp', $timestamp, PDO::PARAM_STR);
$insertTest->bindValue(':start', $start, PDO::PARAM_STR);
$insertTest->bindValue(':end', $end, PDO::PARAM_STR);
$insertTest->bindValue(':text', $text, PDO::PARAM_STR);
$insertTest->bindValue(':target', $target, PDO::PARAM_STR);

$insertTest->execute();

$myResult = $connection->query("SELECT * FROM $filmName ORDER BY id  DESC LIMIT 0,1");



$results = $myResult->fetchAll(PDO::FETCH_ASSOC);

$resultsJSON = json_encode($results);

//echo 'Data logged:';

echo($resultsJSON);

$connection = null;

//Do a new query based on timestamp plus add user and config + note flag

}







