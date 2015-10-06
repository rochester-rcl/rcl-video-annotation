<?php

error_reporting(E_ALL | E_STRICT);
    ini_set("display_errors", 2);


include_once '../user.php';
include_once '../film.php';
include_once '../marker.php';
include_once '../markerType.php';
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$postAction = filter_input(INPUT_POST,'action');

$email = filter_input(INPUT_POST,"email");
$userPassword = filter_input(INPUT_POST,"password");

if ($postAction == 'login') {

$userReturn = UserDAO::loginUser($email, $userPassword);

$userFilm = UserDAO::getFilms($userReturn->getUserId());

$userFilmUrl = $userFilm[0]['film_url'];


$userArray = array();
$markerArray = array();

$iterator = 0;

  if($userReturn){

    //get all the markers, process them, and stuff it into an array
    $markerResults = FilmMarkerDAO::getAllMarkers($userFilm[0]['id']);


    foreach ($markerResults as $results) {

      $id = $results['id'];
      $userId = $results['user_id'];
      $filmId = $results['film_id'];
      $markerId = $results['marker_type_id'];
      $start = $results['start'];
      $end = $results['end'];
      $note = $results['note'];
      $target = $results['target'];

      $markerCategoryInfo = MarkerTypeDAO::getCategoryByMarker($markerId);

      $userFullName = UserDAO::getUserFullName($userId);

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

      if ($userReturn->getUserId() == $userId) {

          $formattedHTML = '<li id="' . $lowerCategory . '-color" data-film-marker-id="' . $id . '" data-user-id="' . $userId .
          '" data-start="' . $start .  '" data-marker-type-id="' . $markerId . '"><span class="annotation-author-me">ME</span><span class="time-stamp">' . $displayTime .
          '</span>' . $markerTypeName . '<i class="fa fa-times"></i></li>';

          $markerArray[$iterator] = array('html' => $formattedHTML, 'start' => $start, 'end' => $end, 'note' => $note );

      }

      elseif($userFullNameString == 'Gen') {

        $formattedHTML = '<li id="' . $lowerCategory . '-color" data-film-marker-id="' . $id . '" data-user-id="' . $userId .
        '" data-start="' . $start .  '" data-marker-type-id="' . $markerId . '"><span class="annotation-author-others">GEN</span><span class="time-stamp">' . $displayTime .
        '</span>' . $markerTypeName . '<i class="fa fa-times"></i></li>';

        $markerArray[$iterator] = array('html' => $formattedHTML, 'start' => $start, 'end' => $end, 'note' => $note);

      } else {

          $formattedHTML = '<li id="' . $lowerCategory . '-color" data-filmMarkerId="' . $id . '" data-userId="' . $userId .
          '" data-start="' . $start . '" data-marker-type-id="' . $markerId . '"><span class="annotation-author-others">' . $initials . '</span><span class="time-stamp">' . $displayTime .
          '</span>' . $markerTypeName . '</li>';

          $markerArray[$iterator] = array('html' => $formattedHTML, 'start' => $start, 'end' => $end, 'note' => $note );

      }

    }


    $userArray['userId'] = $userReturn->getUserId();
    $userArray['email'] = $userReturn->getUserEmail();
    $userArray['filmUrl'] = $userFilmUrl;
    $userArray['fullName'] = $userReturn->getFullName();
    $userArray['userFilmId'] = $userFilm[0]['id'];
    $userArray['markerArray'] = $markerArray;
    echo(json_encode($userArray));


  } else {
    echo("USER NOT found!!!!");
  }

}
