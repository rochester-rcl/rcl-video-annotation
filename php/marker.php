<?php

include_once 'db.php';
/**Class that represents a Marker Type **/

class MarkerType {
    protected $markerCode;
    protected $name;
    protected $description;
    protected $category;

    public function __construct($markerCode, $name, $description, $category) {
      $this->markerCode = $markerCode;
      $this->name = $name;
      $this->description = $description;
      $this->category = $category;
    }

    public function setMarkerCode() {
      $this->markerCode = $markerCode;
    }

    public function getMarkerCode() {
      return $this->markerCode;
    }

    public function setName() {
      $this->name = $name;
    }

    public function getName() {
      return $this->name;
    }

    public function setDesc() {
      $this->description = $description;
    }

    public function getDesc() {
      return $this->description;
    }

    public function getCat() {
      return $this->category;
    }

}

class MarkerTypeDAO {
  /**
   * Insert a new marker type
   *
   * @param MarkerType $markerTypeObj
   * @return type
   */
   public static function insertMarkerType(MarkerType $markerTypeObj) {

       if ($markerTypeObj->getMarkerCode() != '') {

           $insert = Db::pdoConnect()->prepare("INSERT INTO marker_type SET marker_code=:marker_code, name=:name, description=:description, category=:category");

           $markerCode = $markerTypeObj->getMarkerCode();
           $name = $markerTypeObj->getName();
           $description = $markerTypeObj->getDesc();
           $category = $markerTypeObj->getCat();

           $insert->bindValue(':marker_code', $markerCode, PDO::PARAM_INT);
           $insert->bindValue(':name', $name, PDO::PARAM_STR);
           $insert->bindValue(':description', $description, PDO::PARAM_STR);
           $insert->bindValue(':category', $category, PDO::PARAM_STR);


           return $insert->execute();

           echo 'MarkerType' . $name . 'inserted';
       } else {
           echo 'Marker Code Required';
       }

   }

   public static function getMarkerForm() { //Returns everything from the marker_type table so we can generate a form from it.
     $statement = Db::pdoConnect()->prepare("SELECT * FROM marker_type");

     $statement->execute();

     $results = $statement->fetchAll(PDO::FETCH_ASSOC);

     return $results;
   }


}

class FilmMarker {

    protected $filmId;
    protected $markerType;
    protected $start;
    protected $end;
    protected $text;
    protected $target;

    public function setFilmId($filmId) {
        $this->filmId = $filmId;
    }

    public function getFilmId() {
        return $this->filmId;
    }

    public function setMarkerType($markerType) {
        $this->markerType = $markerType;
    }

    public function getMarkerType() {
        return $this->markerType;
    }

    public function setStart($start) {
        $this->start = $start;
    }

    public function getStart() {
        return $this->start;
    }

    public function setEnd($end) {
        $this->end = $end;
    }

    public function getEnd() {
        return $this->end;
    }

    public function setText($text) {
        $this->text = $text;
    }

    public function getText() {
        return $this->text;
    }

    public function setTarget($target) {
        $this->target = $target;
    }

    public function getTarget() {
        return $this->target;
    }

    public function setAllFromArray(Array $arr) {

        $this->setFilmId($arr['filmId']);

        $this->setMarkerType($arr['markerType']);

        $this->setStart($arr['start']);

        $this->setEnd($arr['end']);

        $this->setText($arr['text']);

        $this->setTarget($arr['target']);
    }

}



Class FilmMarkerDAO {
  /**
   * Insert a new film marker
   *
   * @param FilmMarker $filmMarkerObj
   * @return type
   */

    public function insertMarker(FilmMarker $filmMarkerObj) {

        if ($filmMarkerObj->getFilmId() != '') {

            $insert = Db::pdoConnect()->prepare("INSERT INTO film_marker SET film_id=:film_id, marker_type_id=:marker_type_id, start=:start, end=:end, text=:text, target=:target");

            $filmId = $filmMarkerObj->getFilmId();
            $markerType = $filmMarkerObj->getMarkerType();
            $start = $filmMarkerObj->getStart();
            $end = $filmMarkerObj->getEnd();
            $text = $filmMarkerObj->getText();
            $target = $filmMarkerObj->getTarget();

            $insert->bindValue(':film_id', $filmId, PDO::PARAM_INT);
            $insert->bindValue(':marker_type_id', $markerType, PDO::PARAM_INT);
            $insert->bindValue(':start', $start, PDO::PARAM_STR);
            $insert->bindValue(':end', $end, PDO::PARAM_STR);
            $insert->bindValue(':text', $text, PDO::PARAM_STR);
            $insert->bindValue(':target', $target, PDO::PARAM_STR);

            return $insert->execute();
        } else {
            echo 'Film ID required';
        }

    }

    public function getMostRecent(FilmMarker $filmMarkerObj) {

        $filmId = $filmMarkerObj->getFilmId();
        $markerType = $filmMarkerObj->getMarkerType();

        $myResult = Db::pdoConnect()->prepare("SELECT * FROM film_marker WHERE film_id = film_id=:film_id AND marker_type_id = marker_type_id=:marker_type_id ORDER BY id DESC LIMIT 1");

        $myResult->bindValue(':film_id', $filmId, PDO::PARAM_INT);
        $myResult->bindValue(':marker_type_id', $markerType, PDO::PARAM_STR);

        $myResult->execute();

        $results = $myResult->fetchAll(PDO::FETCH_ASSOC);
        $resultsJSON = json_encode($results);

        return $resultsJSON;
    }

    public function getMarkerByType(FilmMarker $filmMarkerObj) {

        $filmId = $filmMarkerObj->getFilmId();
        $markerType = $filmMarkerObj->getMarkerType();

        $myResult = Db::pdoConnect()->prepare("SELECT * FROM film_marker WHERE film_id = film_id=:film_id AND marker_type_id = marker_type_id=:marker_type_id ORDER BY start");

        $myResult->bindValue(':film_id', $filmId, PDO::PARAM_INT);
        $myResult->bindValue(':marker_type', $markerType, PDO::PARAM_INT);

        $myResult->execute();

        $results = $myResult->fetchAll(PDO::FETCH_ASSOC);
        $resultsJSON = json_encode($results);

        return $resultsJSON;
    }

    public function getAllMarkers() {

        $myResult = Db::pdoConnect()->prepare("SELECT * FROM film_marker ORDER BY start");

        $myResult->execute();

        $results = $myResult->fetchAll(PDO::FETCH_ASSOC);
        $resultsJSON = json_encode($results);

        return $resultsJSON;
    }

}
