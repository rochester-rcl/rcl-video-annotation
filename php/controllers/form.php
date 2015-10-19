<?php

include_once '../markerType.php';
include_once '../film.php';

header("content-type:application/json");
error_reporting(E_ALL | E_STRICT);
    ini_set("display_errors", 2);

$postAction = filter_input(INPUT_POST,'action');


if ($postAction == 'getForm') {

  $formTop = MarkerTypeDAO::getMarkerFormTopLevel();

  $formButton = MarkerTypeDAO::getMarkerFormButtons();

  $filmNames = FilmDAO::getAllFilmNames();

  $films = array();
  $groupArray = array();
  $buttonArray = array();
  $markerGroup = array();

  foreach ($filmNames as $names) {

    $name = $names['film_name'];
    $filmId = $names['id'];

    $optionHTML = '<option class="film-select-option" value="' . $filmId . '">' . $name . '</option>';

    $films[$name] = array('html' => $optionHTML);

  }

  foreach ($formTop as $form) {

    $id = $form['id'];

    $name = $form['name'];

    $nameDashed= str_replace(' ','-',$name);

    $lowerName = strtolower($nameDashed);

    $groupArray[$id] = $lowerName;

    $groupHTML = '<option class="marker-title-select" value="' . $id . '">' . $name . '</option>';

    $markerGroup[$name] = array("html" => $groupHTML);

  }


  foreach ($formButton as $button){

    $category = $button['category'];
    $categoryId = $button['category_id'];
    $markerId = $button['id'];
    $name = $button['name'];
    $description = $button['description'];

    $categoryDashed = str_replace(' ','-',$category);

    $nameDashed= str_replace(' ','-',$name);

    $lowerName = strtolower($nameDashed);

    $lowerCategory = strtolower($categoryDashed);

    if ($name == $category) {

      $arrayCategory = 'top-level';

    } elseif ($name == 'Turning Point') {

        $arrayCategory = 'top-level';

      } else {

      $arrayCategory = $lowerCategory;

    }

    if ($description != NULL) { //

      $buttonHtml = '<li><button value="' . $markerId . '" class="' . $lowerCategory . '-color">' . $name . '</button></li>';

      $buttonArray[$markerId] = array('html' => $buttonHtml, 'category' => $arrayCategory, 'markerName' => $lowerName);


  } else {

      $buttonHtml = '<li><button value="' . $markerId . '" class="' . $lowerCategory . '-color">' . $name . '</button></li>';

      $buttonArray[$markerId] = array('html' => $buttonHtml, 'category' => $arrayCategory, 'markerName' => $lowerName);

    }
  }

  $overlayArray['button'] = $buttonArray;
  $overlayArray['group'] = $groupArray;
  $overlayArray['films'] = $films;
  $overlayArray['markers'] = $markerGroup;

  $overlay = json_encode($overlayArray);

  echo($overlay);



} else {
  echo "Can't connect to Database.";
}
