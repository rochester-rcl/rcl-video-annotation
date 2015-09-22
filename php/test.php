<?php

include_once 'film.php';
include_once 'user.php';

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
    
   
    
}

Test::addUser();