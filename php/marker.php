<?php

include_once 'db.php';
/**Class that represents a Marker Type **/

class FilmMarker {

    protected $id;
    protected $filmId;
    protected $markerId;
    protected $start;
    protected $end;
    protected $text;
    protected $target;
    protected $userId;


    public function __construct(Array $array){

      $this->filmId = $array['filmId'];

      $this->markerId = $array['markerId'];

      $this->start = $array['start'];

      $this->end = $array['end'];

      $this->text = $array['text'];

      $this->target = $array['target'];

      $this->userId = $array['userId'];

    }

    function getId() {
        return $this->id;
    }

    function setId($id) {
        $this->id = $id;
    }

    function getUserId() {
        return $this->userId;
    }

    function setUserId($userId) {
        $this->userId = $userId;
    }

    public function setFilmId($filmId) {
        $this->filmId = $filmId;
    }

    public function getFilmId() {
        return $this->filmId;
    }

    public function setMarkerType($markerId) {
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

            $insert = Db::pdoConnect()->prepare("INSERT INTO film_marker SET film_id=:film_id, marker_type_id=:marker_type_id, start=:start, end=:end, text=:text, target=:target, user_id=:user_id");

            $filmId = $filmMarkerObj->getFilmId();
            $markerId = $filmMarkerObj->getMarkerId();
            $start = $filmMarkerObj->getStart();
            $end = $filmMarkerObj->getEnd();
            $text = $filmMarkerObj->getText();
            $target = $filmMarkerObj->getTarget();
            $userId = $filmMarkerObj->getUserId();

            $insert->bindValue(':film_id', $filmId, PDO::PARAM_INT);
            $insert->bindValue(':marker_type_id', $markerId, PDO::PARAM_INT);
            $insert->bindValue(':start', $start, PDO::PARAM_STR);
            $insert->bindValue(':end', $end, PDO::PARAM_STR);
            $insert->bindValue(':text', $text, PDO::PARAM_STR);
            $insert->bindValue(':target', $target, PDO::PARAM_STR);
            $insert->execute();

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

        $myResult = Db::pdoConnect()->prepare("SELECT * FROM film_marker WHERE film_marker.id=:filmId ORDER BY start");
        $myResult->bindValue(':filmId', $filmId, PDO::PARAM_INT);

        $myResult->execute();

        $results = $myResult->fetchAll(PDO::FETCH_ASSOC);
        $resultsJSON = json_encode($results);

        return $resultsJSON;
    }

    public static function delete($id){
        $sql = "DELETE FROM film_marker WHERE id =  :id";
        $stmt = Db::pdoConnect()->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
