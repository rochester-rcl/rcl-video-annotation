<?php

include_once '../marker.php';

$postAction = filter_input(INPUT_POST,'action');


if ($postAction == 'deleteMarker') {

  $id = filter_input(INPUT_POST,'filmMarkerId');

  $filmId = filter_input(INPUT_POST,'filmId');

  FilmMarkerDAO::delete($id);

  $message = array();

  $message['message'] = 'Marker ' . $id . ' deleted forever.';



  //get markers for footnote re-rendering

  $markerResults = FilmMarkerDAO::getAllMarkers($filmId);

  $markerArray = array();
  $iterator = 0;
  foreach ($markerResults as $results) {

    $start = $results['start'];
    $end = $results['end'];
    $note = $results['note'];

    $markerArray[$iterator] = array('start' => $start, 'end' => $end,'note' => $note);

    $iterator += 1;

  }

  $returnArray = json_encode($markerArray);

  echo $returnArray;

} else {

  echo "Couldn't connect to database";

}
