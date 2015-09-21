<?php

include_once '../marker.php';

$code = 21;

$name = 'Opening Credits Start';

$description = "When a film's opening credits begin";

$category = "credits";

$myMarkerType = new MarkerType($code,$name,$description,$category);

//$cat = $myMarkerType->getCat();

$insert = MarkerTypeDAO::insertMarkerType($myMarkerType);
