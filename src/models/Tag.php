<?php
require_once __DIR__ . '/../config/connection.php';

class Tag
{
    public $id;
    protected $nom;

    public function __construct($nom = null)
    {
        $this->nom = $nom;
    }

    public function create()
    {
        $db = Database::getInstance();
        $conn = $db->getConnection();

        try {
            $stmt = $conn->prepare("INSERT INTO tags (nom) VALUES (:nom)");
            $stmt->bindParam(':nom', $this->nom);
            $stmt->execute();
            return ['success' => true, 'id' => $conn->lastInsertId()];
        } catch (PDOException $e) {
            if ($e->getCode() == 23000) {
                return ['success' => false, 'message' => 'A tag with this name already exists'];
            }
            return ['success' => false, 'message' => 'Error creating tag'];
        }
    }

    public function getTagByName($nom)
    {
        $db = Database::getInstance();
        $conn = $db->getConnection();

        $stmt = $conn->prepare("SELECT * FROM tags WHERE nom = :nom");
        $stmt->bindParam(':nom', $nom);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getAllTags()
    {
        $db = Database::getInstance();
        $conn = $db->getConnection();

        $stmt = $conn->prepare("SELECT id_tag, nom FROM tags");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function update($id, $newName)
    {
        $db = Database::getInstance();
        $conn = $db->getConnection();

        try {
            $stmt = $conn->prepare("UPDATE tags SET nom = :newName WHERE id_tag = :id");
            $stmt->bindParam(':newName', $newName);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            return ['success' => true, 'message' => 'Tag updated successfully'];
        } catch (PDOException $e) {
            if ($e->getCode() == 23000) {
                return ['success' => false, 'message' => 'A tag with this name already exists'];
            }
            return ['success' => false, 'message' => 'Error updating tag'];
        }
    }

    public function delete($id)
    {
        $db = Database::getInstance();
        $conn = $db->getConnection();

        try {
            $stmt = $conn->prepare("DELETE FROM tags WHERE id_tag = :id");
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            return ['success' => true, 'message' => 'Tag deleted successfully'];
        } catch (PDOException $e) {
            return ['success' => false, 'message' => 'Error deleting tag'];
        }
    }
}
