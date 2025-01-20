<?php

namespace app\models;
require_once __DIR__ . '/../../vendor/autoload.php';


use app\classes\Category;
use PDO;
use PDOException;

class Categories {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function saveCategory($category) {
        $name = $category->getName();
        $description = $category->getDescription(); // Get description
    
        $query = "INSERT INTO category (name, description) VALUES (:name, :description)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description); // Bind description
    
        try {
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }
    public function getAllCategories() {
        $query = "SELECT * FROM category";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $categoryObjects = [];
        foreach ($categories as $category) {
            $categoryObjects[] = new Category($category['id'], $category['name']);
        }

        return $categoryObjects;
    }

    public function deleteCategory($id) {
        $query = "DELETE FROM category WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        try {
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function updateCategory($category) {
        $id = $category->getId();
        $name = $category->getName();

        $query = "UPDATE category SET name = :name WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        try {
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function findCategory($id) {
        $query = "SELECT * FROM category WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $category = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($category) {
            return new Category($category['id'], $category['name']);
        } else {
            return null;
        }
    }
}