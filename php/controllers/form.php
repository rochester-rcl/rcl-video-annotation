<?php

include_once '../markerType.php';

header("content-type:application/json");
error_reporting(E_ALL | E_STRICT);
    ini_set("display_errors", 2);

$postAction = 'getForm';

if ($postAction == 'getForm') {

  $formTop = MarkerTypeDAO::getMarkerFormTopLevel();

  $formButton = MarkerTypeDAO::getMarkerFormButtons();

  $groupArray = [];
  $buttonArray = [];


  foreach ($formTop as $form) {
    $id = $form['id'];
    $name = $form['name'];

    $nameDashed= str_replace(' ','-',$name);

    $lowerName = strtolower($nameDashed);

    $groupArray[$id] = $lowerName;

  }


  foreach ($formButton as $button){

    $category = $button['category'];
    $categoryId = $button['category_id'];
    $markerId = $button['id'];
    $name = $button['name'];
    $description = $button['description'];

    $categoryDashed = str_replace(' ','-',$category);

    $lowerCategory = strtolower($categoryDashed);

    $nameDashed= str_replace(' ','-',$name);

    $lowerName = strtolower($nameDashed);

    if ($description != NULL) {

      $buttonHtml = '<li><button value="' . $markerId . '" id="' . $lowerCategory . '-color">' . $name . '</button></li>';

      $buttonArray[$markerId] = array('html' => $buttonHtml, 'category' => $lowerCategory);

    } else {

      $buttonHtml = '<li><button value="' . $markerId . '" id="' . $lowerCategory . '-color">' . $name . '</button></li>';

      $buttonArray[$markerId] = array('html' => $buttonHtml, 'category' => $lowerCategory);

    }
  }

  $overlayArray['button'] = $buttonArray;
  $overlayArray['group'] = $groupArray;

  $overlay = json_encode($overlayArray);

  echo($overlay);



} else {
  echo "Can't connect to Database.";
}
