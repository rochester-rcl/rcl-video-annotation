<?php

include_once 'film.php';
include_once 'user.php';
include_once 'marker.php';
include_once 'markerType.php';

/**
 * Simple class for testing php code
 *
 * @author nathans
 */
class Test {


    public static function addFilm(){
        $film = new Film(null, "a film", "http://www.cnn.com");
        $updatedFilm =  FilmDAO::insert($film);
        var_dump($film);
        $numDeleted = FilmDAO::delete($film->getId());
        var_dump($numDeleted);
    }

    public static function addUser(){


        $user = new User(null,

            "Gen",
            "genuser",
            User::hash("DigitalHum15")); //Change this info to reflect your user info you want to enter


        var_dump($user);
        $updatedUser = UserDAO::add($user);
        return $user;
        //Comment out lines 34 - 42 so user is saved

        // $emailUser = UserDAO::loginUser("test@test.com", "bad");
        //
        // var_dump($emailUser);
        //
        //
        // $numDeleted = UserDAO::delete($updatedUser->getUserId());
        //
        // var_dump($numDeleted);
    }

    public static function addUserFilm($userId){
      //Need to match the film we want to assign to the user, I'm using big buck bunny for now. Before you do this make sure you run insert_data.sql so the films are in there
      $userNameId = $userId;

      $filmId = 8;

      $insertFilm = UserDAO::addFilm($userId, $filmId);
    }

    public static function addMarker(){

        $film = new Film(null, "a film", "http://www.cnn.com");

        $updatedFilm =  FilmDAO::insert($film);

        $user = new User(null,
            "test@test.com",
            "john doe",
            User::hash("password"));
        $updatedUser = UserDAO::add($user);
        $markerType = MarkerTypeDAO::getByName('Event');

        UserDAO::addFilm($updatedUser->getUserId(), $updatedFilm->getId());
        $myVideos = UserDAO::getFilms($updatedUser->getUserId());
        var_dump($myVideos);

        //$filmId, $markerId, $start, $end, $note, $target, $userId
        $marker = new FilmMarker(NULL,
                $updatedFilm->getId(),
                $markerType->getId(),
                0.5,
                0.6,
                "this is stuff",
                "target",
                $updatedUser->getUserId());
        $markerWithId = FilmMarkerDAO::insertMarker($marker);
        var_dump($markerWithId);

        UserDAO::removeFilm($updatedUser->getUserId(), $updatedFilm->getId());
        FilmMarkerDAO::delete($markerWithId->getId());
        UserDAO::delete($updatedUser->getUserId());
        FilmDAO::delete($film->getId());



    }



}
 // Uncomment to add user and add a film for that user
//$user = Test::addUser();
Test::addUserFilm(2);
//Test::addMarker();
