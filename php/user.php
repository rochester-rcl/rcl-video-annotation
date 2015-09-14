<?php

include_once 'db.php';
/**
 * Represents a user class
 *
 */
class User {

    protected $userId;
    protected $userEmail;
    protected $userFilmId;
    protected $username;
    protected $password;
    
    public function __construct($userId, 
            $userEmail, 
            $userName, 
            $password){
        
        $this->userId = $userId;
        $this->userEmail = $userEmail;
        $this->username = $userName;
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

    public function setUsername($username) {
        $this->username = $username;
    }

    public function getUsername() {
        return $this->username;
    }

    public function setPassword($password) {
        $this->password = $password;
    }

    public function getPassword() {
        return $this->password;
    }

    public function setAllFromArray(Array $arr) {

        $this->setUsername($arr['username']);

        $this->setPassword($arr['user_password']);

        $this->setUserEmail($arr['user_email']);

    }

}

class UserDAO{
    
    public static function add(User $user){
        $insertUser = Db::pdoConnect()->prepare("INSERT INTO user SET username=:username, user_password=:user_password, user_email=:user_email");
        $insertUser->bindValue(':username', $user->getUsername(), PDO::PARAM_STR);
        $insertUser->bindValue(':user_password', $user->getPassword(), PDO::PARAM_STR);
        $insertUser->bindValue(':user_email', $user->getUserEmail(), PDO::PARAM_STR);
        
        $insertUser->execute();
        $lastId = Db::pdoConnect()->lastInsertId();
        $user->setId($lastId);
    }
    
    /**
     * Get the user for the given password - the password MUST be hashed before
     * it is passed in.
     * 
     * @param type $password
     */
    public static function getUser($password){
        $myResult = self::$connection->prepare("SELECT * FROM film_marker WHERE password = :password");

        $myResult->bindValue(':password', $password, PDO::PARAM_STR);
        $myResult->execute();

        $results = $myResult->fetchAll(PDO::FETCH_ASSOC);
        return json_encode($results);
    }
}