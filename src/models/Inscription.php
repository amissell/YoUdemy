<?php
require_once __DIR__ . '/../config/connection.php';

class Inscription
{
    protected $id;
    protected $id_etudiant;
    protected $id_cours;
    protected $date_inscription;

    public function __construct($id_etudiant = null, $id_cours = null)
    {
        $this->id_etudiant = $id_etudiant;
        $this->id_cours = $id_cours;
        $this->date_inscription = date('Y-m-d H:i:s');
    }

    public function inscriptionCours()
    {
        $db = Database::getInstance();
        $conn = $db->getConnection();

        try {
            $checkStmt = $conn->prepare("SELECT * FROM inscriptions WHERE id_etudiant = :id_etudiant AND id_cours = :id_cours");
            $checkStmt->bindParam(':id_etudiant', $this->id_etudiant);
            $checkStmt->bindParam(':id_cours', $this->id_cours);
            $checkStmt->execute();

            if ($checkStmt->fetch()) {
                return ['success' => false, 'message' => 'Vous êtes déjà inscrit à ce cours.'];
            }

            $stmt = $conn->prepare("INSERT INTO inscriptions (id_etudiant, id_cours, date_inscription) VALUES (:id_etudiant, :id_cours, :date_inscription)");
            $stmt->bindParam(':id_etudiant', $this->id_etudiant);
            $stmt->bindParam(':id_cours', $this->id_cours);
            $stmt->bindParam(':date_inscription', $this->date_inscription);
            $stmt->execute();

            return ['success' => true, 'message' => 'Inscription réussie!'];
        } catch (PDOException $e) {
            return ['success' => false, 'message' => 'Erreur lors de l\'inscription: ' . $e->getMessage()];
        }
    }

    public function getInscriptionsByCourse($id_cours)
    {
        $db = Database::getInstance();
        $conn = $db->getConnection();

        $stmt = $conn->prepare("SELECT * FROM inscriptions WHERE id_cours = :id_cours");
        $stmt->bindParam(':id_cours', $id_cours);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCoursesByStudent($id_etudiant)
    {
        $db = Database::getInstance();
        $conn = $db->getConnection();

        $stmt = $conn->prepare("SELECT c.* FROM inscriptions i JOIN cours c ON i.id_cours = c.id WHERE i.id_etudiant = :id_etudiant");
        $stmt->bindParam(':id_etudiant', $id_etudiant);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}