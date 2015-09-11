<?php

include_once 'film.php';

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
    
   
    
}

Test::addFilm();