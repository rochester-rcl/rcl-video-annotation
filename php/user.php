<?php

include_once 'db.php';
//Uncomment for php < 5.4
require 'password.php';
/**
 * Represents a user class
 *
 */
class User {

    protected $userId;
    protected $userEmail;
    protected $fullName;
    protected $password;

    public function __construct($userId,
            $fullName,
            $userEmail,
            $password){

        $this->userId = $userId;
        $this->userEmail = $userEmail;
        $this->fullName = $fullName;
        $this->password = $password;
    }

    public static function hash($stringToHash){
        return password_hash($stringToHash, PASSWORD_BCRYPT);
    }

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

    public function setFullName($fullName) {
        $this->fullName = $fullName;
    }

    public function getFullName() {
        return $this->fullName;
    }

    public function setPassword($password) {
        $this->password = $password;
    }

    public function getPassword() {
        return $this->password;
    }

    public function setUserFilmId($filmId) {
      $this->filmId = $filmId;
    }

    public function getUserFilmId() {
      return $this->filmId;
    }

    public function setAllFromArray(Array $arr) {

        $this->setFullName($arr['fullName']);

        $this->setPassword($arr['user_password']);

        $this->setUserEmail($arr['user_email']);

        $this->setUserId('user_id');

    }

}

class UserDAO{

    public static function add(User $user){
        $insertUser = Db::pdoConnect()->prepare("INSERT INTO user SET full_name=:fullname, user_password=:user_password, user_email=:user_email");
        $insertUser->bindValue(':fullname', $user->getFullName(), PDO::PARAM_STR);
        $insertUser->bindValue(':user_password', $user->getPassword(), PDO::PARAM_STR);
        $insertUser->bindValue(':user_email', $user->getUserEmail(), PDO::PARAM_STR);

        $insertUser->execute();
        $lastId = Db::pdoConnect()->lastInsertId();
        $user->setUserId($lastId);
        return $user;
    }

    public static function delete($id){
        $sql = "DELETE FROM user WHERE id =  :id";
        $stmt = Db::pdoConnect()->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    /**
     * Get the user for the given email.  Returns a user object if the user
     * is found otherwise returns false
     *
     * @param type $email
     */
    public static function getUser($email){
        if(!$email || trim($email) == ""){
            return false;
        }
        $myResult = Db::pdoConnect()->prepare("SELECT * FROM user WHERE user_email = :email");

        $myResult->bindValue(':email', $email, PDO::PARAM_STR);
        $myResult->execute();

        $results = $myResult->fetch(PDO::FETCH_ASSOC);
        if($results){
            return new User($results['id'],
                      $results['full_name'],
                      $results['user_email'],
                      $results['user_password'] );
        } else {
            return false;
        }

    }

    public static function loginUser($email, $password){
        $user = UserDAO::getUser($email);
        if($user && password_verify($password, $user->getPassword())){
            return $user;
        } else {
            return false;
        }
    }

    public static function getUserFullName($userId) {
        $myResult = Db::pdoConnect()->prepare("SELECT full_name FROM user WHERE user.id=:user_id");
        $myResult->bindValue(':user_id', $userId, PDO::PARAM_INT);

        $myResult->execute();

        $results = $myResult->fetchAll(PDO::FETCH_ASSOC);

        return $results;
    }

    public static function getFilms($userId){
        $myResult = Db::pdoConnect()->prepare("SELECT film.* FROM film, user_film WHERE film.id = user_film.film_id AND user_film.user_id = :user_id");

        $myResult->bindValue(':user_id', $userId, PDO::PARAM_INT);

        $myResult->execute();

        $results = $myResult->fetchAll(PDO::FETCH_ASSOC);

        return $results;

    }

    public static function addFilm($userId, $filmId){
        $insertUser = Db::pdoConnect()->prepare("INSERT INTO user_film SET user_id=:user_id, film_id=:film_id");
        $insertUser->bindValue(':user_id', $userId, PDO::PARAM_INT);
        $insertUser->bindValue(':film_id', $filmId, PDO::PARAM_INT);

        return $insertUser->execute();
    }

    public static function removeFilm($userId, $filmId){
        $sql = "DELETE FROM user_film WHERE user_id =  :user_id and film_id=:film_id";
        $stmt = Db::pdoConnect()->prepare($sql);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->bindParam(':film_id', $filmId, PDO::PARAM_INT);
        return $stmt->execute();
    }


}
