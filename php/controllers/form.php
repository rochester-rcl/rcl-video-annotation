<?php

include_once '../marker.php';

header("content-type:application/json");
error_reporting(E_ALL | E_STRICT);
    ini_set("display_errors", 2);

$postAction = 'getForm';

if ($postAction == 'getForm') {

  $formTop = MarkerTypeDAO::getMarkerFormTopLevel();

  $formButton = MarkerTypeDAO::getMarkerFormButtons();

  foreach ($formTop as $topLevel){

      $name = $topLevel['name'];

      $lowerName = strtolower($name);

      echo '<a href="#" class="category" id="' . $lowerName . '">' . $name . '</a>';

    }

  foreach ($formButton as $button){

    $category = $button['category'];
    $markerId = $button['id'];
    $name = $button['name'];
    $description = $button['description'];

    $lowerCategory = strtolower($category);

    if ($description != NULL) {

      echo '<button value="' . $markerId . '" class="' . $lowerCategory . '" title="' . $description . '">' . $name . '</button>';

    } else {

      echo '<button value="' . $markerId . '" class="' . $lowerCategory . '">' . $name . '</button>';

    }


  }





  echo '<a href="#" id="insertMarkerButton">Insert Marker</a>';

} else {
  echo "Can't connect to Database.";
}
