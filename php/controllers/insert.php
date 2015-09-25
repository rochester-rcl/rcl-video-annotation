<?php

include_once '../marker.php';

header("content-type:application/json");
error_reporting(E_ALL | E_STRICT);
    ini_set("display_errors", 2);

$postAction = filter_input(INPUT_POST,'action');

if ($postAction == 'insertMarker') {

  //construct from input_post array

  $filmMarker = new FilmMarker();

}
