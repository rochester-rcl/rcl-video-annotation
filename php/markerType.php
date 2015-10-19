<?php

include_once 'db.php';

class MarkerType {

    protected $id;
    protected $name;
    protected $description;
    protected $categoryId;

    public function __construct($id, $name, $description, $categoryId) {
      $this->name = $name;
      $this->description = $description;
      $this->categoryId = $categoryId;
      $this->id = $id;
    }

    function getId() {
        return $this->id;
    }

    function setId($id) {
        $this->id = $id;
    }

    public function setName($name) {
      $this->name = $name;
    }

    public function getName() {
      return $this->name;
    }

    public function setDescscription($description) {
      $this->description = $description;
    }

    public function getDescription() {
      return $this->description;
    }

    public function getCategoryId() {
      return $this->categoryId;
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

           $insert = Db::pdoConnect()->prepare("INSERT INTO marker_type SET name=:name, description=:description, category_id=:categoryId");

           $name = $markerTypeObj->getName();
           $description = $markerTypeObj->getDescription();
           $categoryId = $markerTypeObj->getCategoryId();

           $insert->bindValue(':name', $name, PDO::PARAM_STR);
           $insert->bindValue(':description', $description, PDO::PARAM_STR);
           $insert->bindValue(':category_id', $categoryId, PDO::PARAM_STR);


           return $insert->execute();

           echo 'MarkerType' . $name . 'inserted';
       } else {
           echo 'Marker Code Required';
       }

   }

   public static function getMarkerFormTopLevel() { //Returns everything from the marker_type table so we can generate a form from it.
     $statement = Db::pdoConnect()->prepare("SELECT name, id FROM marker_category ORDER BY marker_category.id");

     $statement->execute();

     $results = $statement->fetchAll(PDO::FETCH_ASSOC);

     return $results;
   }

   public static function getMarkerFormButtons() {
     $statement = Db::pdoConnect()->prepare("SELECT marker_type.id, marker_type.name, marker_type.description, marker_category.name AS category, marker_category.id AS category_id
     FROM marker_type INNER JOIN marker_category ON marker_category.id = marker_type.marker_category_id ORDER BY marker_type.id");

     $statement->execute();

     $results = $statement->fetchAll(PDO::FETCH_ASSOC);

     return $results;
   }

   public static function getCategoryByMarker($markerId) {
     $statement = Db::pdoConnect()->prepare("SELECT marker_category.name, marker_type.name AS marker_name FROM marker_category INNER JOIN marker_type ON marker_type.marker_category_id = marker_category.id
       WHERE marker_type.id = :marker_type_id");

     $statement->bindValue(':marker_type_id', $markerId, PDO::PARAM_INT);

     $statement->execute();

     $results = $statement->fetch(PDO::FETCH_ASSOC);

     return $results;
   }

   public static function getMarkerTypeByCategory($categoryId) {

     $statement = Db::pdoConnect()->prepare("SELECT marker_type.id AS markerId, marker_category.id AS categoryId FROM marker_type INNER JOIN marker_category ON
       marker_type.marker_category_id = marker_category.id WHERE marker_type.marker_category_id = :marker_category_id");

     $statement->bindValue(':marker_category_id', $categoryId, PDO::PARAM_INT);

     $statement->execute();

     $results = $statement->fetchAll(PDO::FETCH_ASSOC);

     return $results;

   }

   public static function getByName($name) {
       if(!$name || trim($name) == ""){
            return false;
        }
        $myResult = Db::pdoConnect()->prepare("SELECT * FROM marker_type WHERE name = :name");

        $myResult->bindValue(':name', $name, PDO::PARAM_STR);
        $myResult->execute();

        $results = $myResult->fetch(PDO::FETCH_ASSOC);
        if($results){
            return new MarkerType($results['id'],
                      $results['name'],
                      $results['description'],
                      $results['marker_category_id'] );
        } else {
            return false;
        }
   }


}
