<?php
namespace app\classes;

class Category {
    private $id;
    private $name;
    private $description; // Add description property

    public function __construct($id = null, $name, $description = '') {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description; // Initialize description
    }

    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function getDescription() {
        return $this->description; // Add getter for description
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function setDescription($description) {
        $this->description = $description; // Add setter for description
    }
}
?>