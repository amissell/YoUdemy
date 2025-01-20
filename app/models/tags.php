<?php

namespace app\models;
require_once __DIR__ . '/../../vendor/autoload.php';


use app\classes\Tag;
use PDO;
use PDOException;

class Tags {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }
    
    public function findTag($id) {
        $queryFindTag = "SELECT * FROM tags WHERE id = :id";
        $stmtselectTag = $this->conn->prepare($queryFindTag);
        $stmtselectTag->bindParam(':id', $id, PDO::PARAM_INT);
        $stmtselectTag->execute();
        $tag = $stmtselectTag->fetch(PDO::FETCH_ASSOC);

        if ($tag) {
            return new Tag($tag['id'], $tag['name']);
        } else {
            return null;
        }
    }

    public function getAllTags() {
        $queryFindTag = "SELECT * FROM tags";
        $stmtselectTag = $this->conn->prepare($queryFindTag);
        $stmtselectTag->execute();
        $tags = $stmtselectTag->fetchAll(PDO::FETCH_ASSOC);

        $tags_objects = [];
        foreach ($tags as $tag) {
            $tags_objects[] = new Tag($tag['id'], $tag['name']);
        }

        return $tags_objects;
    }
    
    public function saveTag($tag) {
        $name = $tag->getName();

        $querytag = "INSERT INTO tags (name) VALUES (:name)";
        $stmttag = $this->conn->prepare($querytag);
        $stmttag->bindParam(':name', $name);

        try {
            $stmttag->execute();
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function deleteTag($id) {
        $query = "DELETE FROM tags WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        try {
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function updateTag($tag) {
        $id = $tag->getId();
        $name = $tag->getName();

        $query = "UPDATE tags SET name = :name WHERE id = :id";
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
}