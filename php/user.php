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
    protected $fullName;
    protected $password;
    
    public function __construct($userId, 
            $userEmail, 
            $fullName, 
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
}