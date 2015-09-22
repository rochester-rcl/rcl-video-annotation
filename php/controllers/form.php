<?php

include_once '../marker.php';

header("content-type:application/json");
error_reporting(E_ALL | E_STRICT);
    ini_set("display_errors", 2);

$postAction = 'getForm';

if ($postAction == 'getForm') {

  $myForm = MarkerTypeDAO::getMarkerForm();

  foreach ($myForm as $form){
    
      $cat = $form['category'];
      $markerCode = $form['marker_code'];
      $name = $form['name'];
      $desc = $form['description'];

      echo '<button value="' . $markerCode . '" class="' . $cat . '" title="' . $desc . '">' . $name . '</button>';

    }

  echo '<a href="#" id="insertMarkerButton">Insert Marker</a>';

} else {
  echo "Can't connect to Database.";
}
