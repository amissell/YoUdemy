<?php
require_once __DIR__ . '/../config/connection.php';

class Category {
    protected $id;
    protected $nom;

    public function __construct($nom) {
        $this->nom = $nom;
    }

    // Add this method
    public static function getCategoryById($id) {
        $db = Database::getInstance();
        $conn = $db->getConnection();
        
        try {
            $stmt = $conn->prepare("SELECT id_categorie, nom FROM categories WHERE id_categorie = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return null;
        }
    }

    public static function getAllCategoriesWithStats() {
        $db = Database::getInstance();
        $conn = $db->getConnection();
        
        $query = "
            SELECT 
                c.id_categorie,
                c.nom,
                COUNT(DISTINCT co.id) as cours_count,
                COUNT(DISTINCT i.id_etudiant) as students_count
            FROM categories c
            LEFT JOIN cours co ON c.id_categorie = co.id_categorie
            LEFT JOIN inscriptions i ON co.id = i.id_cours
            GROUP BY c.id_categorie, c.nom
            ORDER BY c.nom ASC
        ";
        
        $stmt = $conn->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create() {
        $db = Database::getInstance();
        $conn = $db->getConnection();
        
        try {
            $stmt = $conn->prepare("INSERT INTO categories (nom) VALUES (:nom)");
            $stmt->bindParam(':nom', $this->nom);
            $stmt->execute();
            return [
                'success' => true,
                'id' => $conn->lastInsertId(),
                'message' => 'Catégorie créée avec succès'
            ];
        } catch (PDOException $e) {
            if ($e->getCode() == 23000) {
                return [
                    'success' => false,
                    'message' => 'Une catégorie avec ce nom existe déjà'
                ];
            }
            return [
                'success' => false,
                'message' => 'Erreur lors de la création de la catégorie'
            ];
        }
    }

    public static function update($id, $newName) {
        $db = Database::getInstance();
        $conn = $db->getConnection();
        
        try {
            $stmt = $conn->prepare("UPDATE categories SET nom = :newName WHERE id_categorie = :id");
            $stmt->bindParam(':newName', $newName);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            return [
                'success' => true,
                'message' => 'Catégorie mise à jour avec succès'
            ];
        } catch (PDOException $e) {
            if ($e->getCode() == 23000) {
                return [
                    'success' => false,
                    'message' => 'Une catégorie avec ce nom existe déjà'
                ];
            }
            return [
                'success' => false,
                'message' => 'Erreur lors de la mise à jour de la catégorie'
            ];
        }
    }

    public static function delete($id) {
        $db = Database::getInstance();
        $conn = $db->getConnection();
        
        try {
            $stmt = $conn->prepare("DELETE FROM categories WHERE id_categorie = :id");
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            return [
                'success' => true,
                'message' => 'Catégorie supprimée avec succès'
            ];
        } catch (PDOException $e) {
            return [
                'success' => false,
                'message' => 'Erreur lors de la suppression de la catégorie'
            ];
        }
    }
}