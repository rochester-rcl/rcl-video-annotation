<?php

include_once '../marker.php';
include_once '../user.php';
include_once '../markerType.php';
include_once '../film.php';

error_reporting(E_ALL | E_STRICT);
    ini_set("display_errors", 2);

$queryObject = filter_input(INPUT_POST,'queryObject');

$filetype = filter_input(INPUT_POST,'filetype');

$queryArray = json_decode($queryObject, true);

$filmIdArray = $queryArray['filmIds'];

$filmMarkerCategoryArray = $queryArray['markerCategoryIds'];

$filmIdArrayLength = sizeof($filmIdArray);

$markerIdArrayLength = sizeof($filmMarkerCategoryArray);

/**************Get all of the markers / names for the types and categories first*********/

$markerArray = array();

foreach ($filmMarkerCategoryArray as $categoryId) {

   $categoryMarkers = MarkerTypeDAO::getMarkerTypeByCategory($categoryId);

   array_push($markerArray, $categoryMarkers);

}

/****************************************************************************************/

$allMarkers = array();

foreach ($filmIdArray as $filmId){

  for ($i = 0; $i < sizeof($markerArray); $i++) {

      foreach($markerArray[$i] as $marker){

        $markerId = $marker['markerId'];

        $query = FilmMarkerDAO::getAllMarkersByTypeFilm($filmId, $markerId);

        array_push($allMarkers, $query);

      }
  }

}

$errors = array_filter($allMarkers);

if (!empty($errors)) {

/******CSV EXPORT******************/
if ($filetype == 'csv') {

  $newlineChar = "\r\n";

  $filename = uniqid('markerData') . '.csv';

  $csvArray = array();

  $i = 0;
  foreach ($allMarkers as $key => $value){

    $valueErrors = array_filter($value);
    
    if ($i > 1){
      break;
    } if (!empty($valueErrors)) {
      $i = 0;
    }
    foreach($value as $headings){
      $headerRow = array_keys($headings);
      array_push($headerRow, 'time_hhmmss');
    }
      $i++;
    }

  $headerImplode = implode(',', $headerRow);

  $headerImplode .= ",\r\n";

  //array_push($csvArray, $headerRow);

    $row = '';

    $row .= $headerImplode;

    foreach ($allMarkers as $markers) {

      foreach($markers as $marker){

        $newlineChar = "\r\n";

        $searchArray = array($newlineChar,',',"\r","\n");

        $note = $marker['note'];

        $cleaned = str_replace($searchArray,'', $marker);

        $seconds = ',' . FilmMarker::startToHHMMSS($marker['time_seconds']);

        $commaSeparated = implode(",", $cleaned);

        $newline = $commaSeparated . $seconds . "," . "\r\n";

        $row .= $newline;
      }

}

    echo json_encode(array('dataType' => 'csv','data' => $row, 'filename' => $filename));


}

/******JSON EXPORT******************/
if ($filetype == 'json') {

  $filename = uniqid('markerData') . '.json';

  $jsonData = array();

  header( 'Content-Type: application/json' );

    foreach ($allMarkers as $markers) {

          array_push($jsonData, $markers);

      }
      //fclose($json);
    echo json_encode(array('dataType' => 'json','data' => $jsonData, 'filename' => $filename));

}
} else echo json_encode(array('data' => 'none'));
