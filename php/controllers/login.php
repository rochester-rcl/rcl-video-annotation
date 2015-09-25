<?php


include_once '../user.php';
include_once '../film.php';
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

  if($userReturn){

    $filmUrl = FilmDAO::getFilmUrl($userReturn->getUserFilmId());

    $userArray = [];

    $userArray['email'] = $userReturn->getUserEmail();
    $userArray['filmUrl'] = $filmUrl;
    $userArray['fullName'] = $userReturn->getFullName();

    echo(json_encode($userArray));


  } else {
    echo("USER NOT found!!!!");
  }

}
