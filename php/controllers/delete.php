<?php

include_once '../marker.php';

$postAction = filter_input(INPUT_POST,'action');


if ($postAction == 'deleteMarker') {

  $id = filter_input(INPUT_POST,'filmMarkerId');

  FilmMarkerDAO::delete($id);

  $message = array();

  $message['message'] = 'Marker ' . $id . ' deleted forever.';

  echo json_encode($message);

} else {

  echo "Couldn't connect to database";

}
