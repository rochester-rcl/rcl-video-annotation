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
            "test@test.com", 
            "john doe", 
            User::hash("password"));
        
        $updatedUser = UserDAO::add($user);
        
        $emailUser = UserDAO::loginUser("test@test.com", "bad");
        
        var_dump($emailUser);
        
      
        
        $numDeleted = UserDAO::delete($updatedUser->getUserId());
        
        var_dump($numDeleted);
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
        print($markerType->getId() . "");
        
        
        $array = array( "id" => NULL, 
                "filmId" => $updatedFilm->getId(),
                "markerId" => $markerType->getId(),
                "start" => 0.5,
                "end" => 0.6,
                "text" => "this is stuff", 
                "target" => "target", 
                "userId" => $updatedUser->getUserId());
        
        $marker = new FilmMarker($array);
        $markerWithId = FilmMarkerDAO::insertMarker($marker);
        var_dump($markerWithId);
        
        FilmMarkerDAO::delete($markerWithId->getId());
        UserDAO::delete($updatedUser->getUserId());
        FilmDAO::delete($film->getId());
        

        
    }
    
   
    
}

Test::addMarker();