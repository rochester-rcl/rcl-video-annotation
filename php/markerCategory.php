<?php


class markerCategory {
    
    protected $id;
    protected $name;
    protected $description;
    

    public function __construct($id, $name, $description) {
      $this->id = $id;
      $this->name = $name;
      $this->description = $description;
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
