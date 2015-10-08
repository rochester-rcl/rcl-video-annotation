<?php

include_once '../marker.php';
include_once '../user.php';
include_once '../markerType.php';
include_once '../film.php';

header("content-type:application/json");
error_reporting(E_ALL | E_STRICT);
    ini_set("display_errors", 2);

$postAction = filter_input(INPUT_POST,'action');

$filmId = filter_input(INPUT_POST, 'filmId');
$markerId = filter_input(INPUT_POST, 'markerId');
$start = filter_input(INPUT_POST, 'start');
$end = filter_input(INPUT_POST, 'end');
$note = filter_input(INPUT_POST, 'note');
$target = filter_input(INPUT_POST, 'target');
$userId = filter_input(INPUT_POST, 'userId');




if ($postAction == 'insertMarker') {

  //construct from input_post array

  $filmMarker = new FilmMarker(NULL, $filmId, $markerId, $start, $end, $note, $target, $userId);

  $markerInsert = FilmMarkerDAO::insertMarker($filmMarker);

  $markerCategory = MarkerTypeDAO::getCategoryByMarker($markerInsert->getMarkerId());

  $filmName = FilmDAO::getFilmName($markerInsert->getFilmId());

  //$displayTime = FilmMarker::startToHHMMSS($markerInsert->getStart());




  /********************************************** Loop for returning all markers *****************/

  $markerResults = FilmMarkerDAO::getAllMarkers($markerInsert->getFilmId());

  $userArray = array();
  $markerArray = array();
  $iterator = 0;
  foreach ($markerResults as $results) {

    $id = $results['id'];
    $filmUserId = $results['user_id'];
    $filmId = $results['film_id'];
    $markerId = $results['marker_type_id'];
    $start = $results['start'];
    $end = $results['end'];
    $note = $results['note'];
    $target = $results['target'];

    $markerCategoryInfo = MarkerTypeDAO::getCategoryByMarker($markerId);

    $userFullName = UserDAO::getUserFullName($userId);

    $userFullName = UserDAO::getUserFullName($filmUserId);

    $category = $markerCategoryInfo['name'];
    $markerTypeName = $markerCategoryInfo['marker_name'];

    $categoryDashed = str_replace(' ','-',$category);

    $lowerCategory = strtolower($categoryDashed);

    $userFullNameString = $userFullName[0]['full_name'];

    $exploded = explode(' ', $userFullNameString);

    $initials = "";

    $displayTime = FilmMarker::startToHHMMSS($start);

    $iterator += 1;

    foreach ($exploded as $words) { //I hate regex so I refuse to use it (I'm actually just too stupid)
      $initials .= $words[0];
    }

    if ($markerInsert->getUserId() == $filmUserId) {

        $formattedHTML = '<li class="' . $lowerCategory . '-color" data-film-marker-id="' . $id . '" data-user-id="' . $userId .
        '" data-start="' . $start .  '" data-marker-type-id="' . $markerId . '"><span class="annotation-author-me">ME</span><span class="time-stamp">' . $displayTime .
        '</span>' . $markerTypeName . '<i class="fa fa-times"></i></li>';

        $markerArray[$iterator] = array('html' => $formattedHTML, 'start' => $start, 'end' => $end, 'note' => $note);

    } elseif($userFullNameString == 'Gen') {

      $formattedHTML = '<li class="' . $lowerCategory . '-color" data-film-marker-id="' . $id . '" data-user-id="' . $userId .
      '" data-start="' . $start .  '" data-marker-type-id="' . $markerId . '"><span class="annotation-author-others">GEN</span><span class="time-stamp">' . $displayTime .
      '</span>' . $markerTypeName . '<i class="fa fa-times"></i></li>';

      $markerArray[$iterator] = array('html' => $formattedHTML, 'start' => $start, 'end' => $end, 'note' => $note);


    } else {

        $formattedHTML = '<li class="' . $lowerCategory . '-color" data-filmMarkerId="' . $id . '" data-userId="' . $userId .
        '" data-start="' . $start . '" data-marker-type-id="' . $markerId . '"><span class="annotation-author-others">' . $initials . '</span><span class="time-stamp">' . $displayTime .
        '</span>' . $markerTypeName . '</li>';

        $markerArray[$iterator] = array('html' => $formattedHTML,  'start' => $start, 'end' => $end, 'note' => $note );

    }

  }

  /*******************JSON*******************/


  $markerReturnArray = array();

  //last thing we need is category name

  $markerReturnArray['id'] = $markerInsert->getId();
  $markerReturnArray['filmName'] = $filmName[0]['film_name'];
  $markerReturnArray['filmId'] = $markerInsert->getFilmId();
  $markerReturnArray['markerId'] = $markerInsert->getMarkerId();
  $markerReturnArray['start'] = $markerInsert->getStart();
  $markerReturnArray['end'] = $markerInsert->getEnd();
  $markerReturnArray['note'] = $markerInsert->getNote();
  $markerReturnArray['target'] = $markerInsert->getTarget();
  $markerReturnArray['userId'] = $markerInsert->getUserId();
  $markerReturnArray['userFullName'] = $userFullNameString;
  $markerReturnArray['userInitials'] = $initials;
  $markerReturnArray['category'] = $category;
  $markerReturnArray['markerArray'] = $markerArray;

  //$markerReturnArray['html'] = $formattedHTML;


  $results = json_encode($markerReturnArray);

  echo $results;


} else {
  echo "Can't connect to database";
}
