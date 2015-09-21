<?php

include_once '../marker.php';

header("content-type:application/json");
error_reporting(E_ALL | E_STRICT);
    ini_set("display_errors", 2);

$postAction = 'getForm';

if ($postAction == 'getForm') {

  $myForm = MarkerTypeDAO::getMarkerForm();

  echo($myForm);

} else {
  echo "Can't connect to Database.";
}
