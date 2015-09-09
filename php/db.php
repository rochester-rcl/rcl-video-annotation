<?php

//Classes for working with our users, markers, and database connections

include 'config.php';
error_reporting(E_ALL);

class User {
  protected $userId;
  protected $userEmail;
  protected $userFilmId;
  protected $username;
  protected $password;

  public function setUserId($userId) {
    $this->userId = $userId;
  }

  public function getUserId() {
    return $this->userId;
  }

  public function setUserEmail($userEmail) {
    return $this->userEmail = $userEmail;
  }

  public function getUserEmail() {
    return $this->userEmail;
  }

  public function setUserFilmId($userFilmId) {
    $this->userFilmId = $userFilmId;
  }

  public function getUserFilmId() {
    return $this->userFilmId;
  }

  public function setUsername($username) {
    $this->username = $username;
  }

  public function getUsername() {
    return $this->username;
  }

  public function getPasswordHash() {
    $password = $this->password;
    $hash = password_hash($password, PASSWORD_BCRYPT);

    return $hash;
  }

  public function setPassword($password) {
    $this->password = $password;
  }

  public function getPassword() {
    return $this->password;
  }

  public function setAllFromArray(Array $arr) {


    $this -> setUsername($arr['username']);

    $this -> setPassword($arr['user_password']);

    $this -> setUserEmail($arr['user_email']);

    $this -> setUserFilmId($arr['user_film_id']);


  }



}

class FilmMarker {
  protected $filmId;
  protected $markerType;
  protected $start;
  protected $end;
  protected $text;
  protected $target;

  public function setFilmId($filmId){
    $this->filmId = $filmId;
  }

  public function getFilmId() {
    return $this->filmId;
  }

  public function setMarkerType($markerType){
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

  public function setText($text){
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

    $this -> setFilmId($arr['filmId']);

    $this -> setMarkerType($arr['markerType']);

    $this -> setStart($arr['start']);

    $this -> setEnd($arr['end']);

    $this -> setText($arr['text']);

    $this -> setTarget($arr['target']);

  }

}


class Db {
protected static $connection;

//Main connection method
public function pdoConnect($server, $username, $password) {
  try {
    self::$connection = new PDO("mysql:host=$server;dbname=video_annotation", $username, $password);

    self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      echo "Connected successfully";
      }
  catch(PDOException $e)
      {
          echo "Connection failed: " . $e->getMessage();
      }

      return self::$connection;
}

//Methods for handling user related queries

public function insertUser(User $user) {
  if ($user->getUserId() != '' ) {

    $userEmail = $user->getUserEmail();
    $username = $user->getUsername();
    $password = $user->getPassword();
    $userFilmId = $user->getUserFilmId();

    $hash = $user->getPasswordHash();

    $insertUser = self::$connection->prepare("INSERT INTO user SET username=:username, user_password=:user_password, user_email=:user_email, user_film_id=:user_film_id");

    $insertUser->bindValue(':username', $username, PDO::PARAM_STR);
    $insertUser->bindValue(':user_password', $hash, PDO::PARAM_STR);
    $insertUser->bindValue(':user_email', $userEmail, PDO::PARAM_STR);
    $insertUser->bindValue(':user_film_id', $userFilmId, PDO::PARAM_INT);

    return $insertUser->execute();


  }
}

public function userSignIn(User $user) {

  $username = $user->getUsername();
  $password = $user->getPassword();

  $passQuery = self::$connection->prepare("SELECT password FROM users WHERE username=:username");

  $passQuery->bindValue(':username', $username, PDO::PARAM_STR);

  $passQuery->execute();

  $results = $passQuery->fetchAll(PDO::FETCH_ASSOC);

  $returnPassword = $results['password'];

  if (password_verify($password, $returnPassword)) {
    echo 'Password is valid';
  } else {
    echo 'Invalid password';
  }

  //Figure out what to return


}

//Methods for inserting and querying film markers

public function insertMarker(FilmMarker $filmMarkerObj) {

  if ($filmMarkerObj->getFilmId != '') {

    $insert = self::$connection->prepare("INSERT INTO film_marker SET film_id=:film_id, marker_type_id=:marker_type_id, start=:start, end=:end, text=:text, target=:target");

    $filmId = $filmMarkerObj -> getFilmId();
    $markerType = $filmMarkerObj -> getMarkerType();
    $start = $filmMarkerObj -> getStart();
    $end = $filmMarkerObj -> getEnd();
    $text = $filmMarkerObj -> getText();
    $target = $filmMarkerObj -> getTarget();

    $insert->bindValue(':film_id', $filmId, PDO::PARAM_INT);
    $insert->bindValue(':marker_type_id', $markerType, PDO::PARAM_INT);
    $insert->bindValue(':start', $start, PDO::PARAM_FLOAT);
  	$insert->bindValue(':end', $end, PDO::PARAM_FLOAT);
  	$insert->bindValue(':text', $text, PDO::PARAM_STR);
  	$insert->bindValue(':target', $target, PDO::PARAM_STR);

    return $insert->execute();

  } else {
    echo 'Film ID required';
  }

  }

public function getMostRecent(FilmMarker $filmMarkerObj) {

    $filmId = $filmMarkerObj -> getFilmId();
    $markerType = $filmMarkerObj -> getMarkerType();

    $myResult = self::$connection->prepare("SELECT * FROM film_marker WHERE film_id = film_id=:film_id AND marker_type_id = marker_type_id=:marker_type_id ORDER BY id DESC LIMIT 1");

    $myResult->bindValue(':film_id', $filmId, PDO::PARAM_INT);
    $myResult->bindValue(':marker_type_id', $markerType, PDO::PARAM_STR);

    $myResult->execute();

    $results = $myResult->fetchAll(PDO::FETCH_ASSOC);
    $resultsJSON = json_encode($results);

    return $resultsJSON;

  }



public function getMarkerByType(FilmMarker $filmMarkerObj) {

    $filmId = $filmMarkerObj -> getFilmId();
    $markerType = $filmMarkerObj -> getMarkerType();

    $myResult = self::$connection->prepare("SELECT * FROM film_marker WHERE film_id = film_id=:film_id AND marker_type_id = marker_type_id=:marker_type_id ORDER BY start");

    $myResult->bindValue(':film_id', $filmId, PDO::PARAM_INT);
    $myResult->bindValue(':marker_type', $markerType, PDO::PARAM_INT);

    $myResult->execute();

    $results = $myResult->fetchAll(PDO::FETCH_ASSOC);
    $resultsJSON = json_encode($results);

    return $resultsJSON;

}

public function getAllMarkers(FilmMarker $filmMarkerObj) {

  $myResult = self::$connection->prepare("SELECT * FROM film_marker ORDER BY start");

  $myResult->execute();

  $results = $myResult->fetchAll(PDO::FETCH_ASSOC);
  $resultsJSON = json_encode($results);

  return $resultsJSON;

}

//Write some methods for handling users - specifically the user login

}

//$userArray = array('username' => 'testuser', 'user_password' => 'myPassword', 'user_email' => 'myemail@net.com', 'user_film_id' => '1');

$testArray = array('filmId' => '1', 'markerType' => '1', 'start' => '0.01', 'end' => '0.02', 'text' => 'shot change', 'target' => 'target');

/*$myUser = new user();

$myUser -> setAllFromArray($userArray);

var_dump($myUser);*/

$myMarker = new FilmMarker();

$myMarker -> setAllFromArray($testArray);

$myConnection = new Db();

$myConnection -> pdoConnect($server, $username, $password);

$myConnection -> insertMarker($myMarker);

$mostRecent = $myConnection -> getAllMarkers($myMarker);



//$results = $dbConnect -> getAllMarkers($myMarker);

$return = json_decode($mostRecent);

var_dump($return);
