<?php

include_once 'db.php';
/**
 * Class that represents a film
 *
 */
class Film {
    
    protected $id;
    protected $name;
    protected $url;
    
    public function __construct($id, $name, $url) {
        $this->id = $id;
        $this->name = $name;
        $this->url = $url;
    }
    
    function setId($id) {
        $this->id = $id;
    }

    function setName($name) {
        $this->name = $name;
    }

    function setUrl($url) {
        $this->url = $url;
    }

    function getId() {
        return $this->id;
    }

    function getName() {
        return $this->name;
    }

    function getUrl() {
        return $this->url;
    }


}

class FilmDAO{
    
    /**
     * Insert a new film
     *  
     * @param Film $film
     * @return type
     */
    public static function insert(Film $film) {

        $insertFilm = Db::pdoConnect()->prepare("INSERT INTO film SET film_name=:name, film_url=:url");
        $insertFilm->bindValue(':name', $film->getName(), PDO::PARAM_STR);
        $insertFilm->bindValue(':url', $film->getUrl(), PDO::PARAM_STR);
        $insertFilm->execute();
        
        $lastId = Db::pdoConnect()->lastInsertId();
        $film->setId($lastId);
        
    }
    
    public static function delete($id){
        $sql = "DELETE FROM film WHERE id =  :id";
        $stmt = Db::pdoConnect()->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);   
        return $stmt->execute();
    }
}
