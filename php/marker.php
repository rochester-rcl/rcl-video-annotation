<?php

include_once 'db.php';
/**Class that represents a film marker **/

class FilmMarker {

    protected $filmId;
    protected $markerType;
    protected $start;
    protected $end;
    protected $text;
    protected $target;

    public function __construct($filmId, $markerType, $start, $end, $text, $target) {
        $this->filmId = $filmId;
        $this->markerType = $markerType;
        $this->start = $start;
        $this->end = $end;
        $this->text = $text;
        $this->target = $target;

    }

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

Class MarkerDAO {
  /**
   * Insert a new film
   *
   * @param FilmMarker $filmMarkerObj
   * @return type
   */



    public static function insertMarker(FilmMarker $filmMarkerObj) {

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
            $insert->bindValue(':start', $start);
            $insert->bindValue(':end', $end);
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

    public function getAllMarkers(FilmMarker $filmMarkerObj) {

        $myResult = Db::pdoConnect()->prepare("SELECT * FROM film_marker ORDER BY start");

        $myResult->execute();

        $results = $myResult->fetchAll(PDO::FETCH_ASSOC);
        $resultsJSON = json_encode($results);

        return $resultsJSON;
    }

}
