<?php

include_once 'db.php';
/**Class that represents a Marker Type **/

class FilmMarker {

    protected $id;
    protected $filmId;
    protected $markerId;
    protected $start;
    protected $end;
    protected $note;
    protected $target;
    protected $userId;


    public function __construct($id, $filmId, $markerId, $start, $end, $note, $target, $userId){

      $this->id = $id; 
        
      $this->filmId = $filmId;

      $this->markerId = $markerId;

      $this->start = $start;

      $this->end = $end;

      $this->note = $note;

      $this->target = $target;

      $this->userId = $userId;

    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getUserId() {
        return $this->userId;
    }

    public function setUserId($userId) {
        $this->userId = $userId;
    }

    public function setFilmId($filmId) {
        $this->filmId = $filmId;
    }

    public function getFilmId() {
        return $this->filmId;
    }

    public function setMarkerId($markerId) {
        $this->markerId = $markerId;
    }

    public function getMarkerId() {
        return $this->markerId;
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

    public function setNote($note) {
        $this->note = $note;
    }

    public function getNote() {
        return $this->note;
    }

    public function setTarget($target) {
        $this->target = $target;
    }

    public function getTarget() {
        return $this->target;
    }

    //Don't know where else to put this so it'll go here for now ;)

    public static function startToHHMMSS($start) {

          $secNum = intVal($start);
          $hours = floor($secNum / 3600);
          $minutes = floor(($secNum / 60) % 60);
          $seconds = $secNum % 60;

          if ($hours < 10) {
              $hours = "0" . $hours;
          }
          if ($minutes < 10) {
              $minutes = "0" . $minutes;
          }
           if ($seconds < 10) {
              $seconds = "0" . $seconds;
          }
          $time = $hours . ":" . $minutes . ":" . $seconds;
          return $time;
      }

}


Class FilmMarkerDAO {
  /**
   * Insert a new film marker
   *
   * @param FilmMarker $filmMarkerObj
   * @return type
   */

    public static function insertMarker(FilmMarker $filmMarkerObj) {

        if ($filmMarkerObj->getFilmId() != '') {

            $insert = Db::pdoConnect()->prepare("INSERT INTO film_marker SET film_id=:film_id, user_id=:user_id, marker_type_id=:marker_type_id, start=:start, end=:end, note=:note, target=:target");

            $filmId = $filmMarkerObj->getFilmId();
            $markerId = $filmMarkerObj->getMarkerId();
            $start = $filmMarkerObj->getStart();
            $end = $filmMarkerObj->getEnd();
            $note = $filmMarkerObj->getNote();
            $target = $filmMarkerObj->getTarget();
            $userId = $filmMarkerObj->getUserId();

            $insert->bindValue(':film_id', $filmId, PDO::PARAM_INT);
            $insert->bindValue(':marker_type_id', $markerId, PDO::PARAM_INT);
            $insert->bindValue(':start', $start, PDO::PARAM_STR);
            $insert->bindValue(':end', $end, PDO::PARAM_STR);
            $insert->bindValue(':note', $note, PDO::PARAM_STR);
            $insert->bindValue(':target', $target, PDO::PARAM_STR);
            $insert->bindValue(':user_id', $userId, PDO::PARAM_INT);
            $insert->execute();

            $lastId = Db::pdoConnect()->lastInsertId();

            $filmMarkerObj->setId($lastId);

            return $filmMarkerObj;

        } else {
            echo 'Film ID required';
        }

    }

    public static function getMostRecent(FilmMarker $filmMarkerObj) {

        $filmId = $filmMarkerObj->getFilmId();
        $markerId = $filmMarkerObj->getMarkerId();

        $myResult = Db::pdoConnect()->prepare("SELECT * FROM film_marker WHERE film_id = film_id=:film_id AND marker_type_id = marker_type_id=:marker_type_id ORDER BY id DESC LIMIT 1");

        $myResult->bindValue(':film_id', $filmId, PDO::PARAM_INT);
        $myResult->bindValue(':marker_type_id', $markerId, PDO::PARAM_STR);

        $myResult->execute();

        $results = $myResult->fetchAll(PDO::FETCH_ASSOC);
        $resultsJSON = json_encode($results);

        return $resultsJSON;
    }

    public static function getMarkerByType(FilmMarker $filmMarkerObj) {

        $filmId = $filmMarkerObj->getFilmId();
        $markerId = $filmMarkerObj->getMarkerId();

        $myResult = Db::pdoConnect()->prepare("SELECT * FROM film_marker WHERE film_id = film_id=:film_id AND marker_type_id = marker_type_id=:marker_type_id ORDER BY start");

        $myResult->bindValue(':film_id', $filmId, PDO::PARAM_INT);
        $myResult->bindValue(':marker_type', $markerId, PDO::PARAM_INT);

        $myResult->execute();

        $results = $myResult->fetchAll(PDO::FETCH_ASSOC);
        $resultsJSON = json_encode($results);

        return $resultsJSON;
    }

    public static function getAllMarkers($filmId) {

        $myResult = Db::pdoConnect()->prepare("SELECT * FROM film_marker WHERE film_marker.film_id=:filmId ORDER BY film_marker.start ASC");
        $myResult->bindValue(':filmId', $filmId, PDO::PARAM_INT);

        $myResult->execute();

        $results = $myResult->fetchAll(PDO::FETCH_ASSOC);

        return $results;
    }

    public static function delete($id){
        $sql = "DELETE FROM film_marker WHERE id =  :id";
        $stmt = Db::pdoConnect()->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
