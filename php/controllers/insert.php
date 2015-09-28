<?php

include_once '../marker.php';
include_once '../user.php';
include_once '../markerType.php';

header("content-type:application/json");
error_reporting(E_ALL | E_STRICT);
    ini_set("display_errors", 2);

$postAction = filter_input(INPUT_POST,'action');

$filmId = filter_input(INPUT_POST, 'filmId');
$markerId = filter_input(INPUT_POST, 'markerId');
$start = filter_input(INPUT_POST, 'start');
$end = filter_input(INPUT_POST, 'end');
$text = filter_input(INPUT_POST, 'text');
$target = filter_input(INPUT_POST, 'target');
$userId = filter_input(INPUT_POST, 'userId');


if ($postAction == 'insertMarker') {

  //construct from input_post array

  $filmMarker = new FilmMarker($filmId, $markerId, $start, $end, $text, $target, $userId);

  $markerInsert = FilmMarkerDAO::insertMarker($filmMarker);

  $userFullName = UserDAO::getUserFullName($markerInsert->getUserId());

  $markerCategory = MarkerTypeDAO::getCategoryByMarker($markerInsert->getMarkerId());

  $displayTime = $markerInsert->startToHHMMSS();

  $category = $markerCategory['name'];

  $markerName = $markerCategory['marker_name'];

  $categoryDashed = str_replace(' ','-',$category);

  $lowerCategory = strtolower($categoryDashed);

  $userFullNameString = $userFullName[0]['full_name'];

  $exploded = explode(' ', $userFullNameString);

  $initials = "";

  foreach ($exploded as $words) { //I hate regex so I refuse to use it (I'm actually just too stupid)
    $initials .= $words[0];
  }

  if ($markerInsert->getUserId() == $userId) {

      $formattedHTML = '<li id="' . $lowerCategory . '-color" data-film-marker-id="' . $markerInsert->getId() . '" data-user-id="' . $markerInsert->getUserId() .
      '" data-start="' . $markerInsert->getStart() .  '" data-marker-type-id="' . $markerInsert->getMarkerId() . '"><span class="annotation-author-me">ME</span><span class="time-stamp">' . $displayTime .
      '</span>' . $markerName . '<i class="fa fa-times"></i></li>';

  } else {

      $formattedHTML = '<li id="' . $lowerCategory . '-color" data-filmMarkerId="' . $markerInsert->getId() . '" data-userId="' . $markerInsert->getUserId() .
      '" data-start="' . $markerInsert->getStart() . '" data-marker-type-id="' . $markerInsert->getMarkerId() . '"><span class="annotation-author-me">' . $initials . '</span><span class="time-stamp">' . $displayTime .
      '</span>' . $markerName . '</li>';

  }

  $markerReturnArray = [];

  //last thing we need is category name

  $markerReturnArray['id'] = $markerInsert->getId();
  $markerReturnArray['filmId'] = $markerInsert->getFilmId();
  $markerReturnArray['markerId'] = $markerInsert->getMarkerId();
  $markerReturnArray['start'] = $markerInsert->getStart();
  $markerReturnArray['end'] = $markerInsert->getEnd();
  $markerReturnArray['text'] = $markerInsert->getText();
  $markerReturnArray['target'] = $markerInsert->getTarget();
  $markerReturnArray['userId'] = $markerInsert->getUserId();
  $markerReturnArray['userFullName'] = $userFullNameString;
  $markerReturnArray['userInitials'] = $initials;
  $markerReturnArray['category'] = $category;
  $markerReturnArray['html'] = $formattedHTML;


  $results = json_encode($markerReturnArray);

  echo $results;


}
