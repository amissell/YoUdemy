<?php
require_once __DIR__ . '/../config/Connection.php';
require_once __DIR__ . '/Category.php';
require_once __DIR__ . '/User.php';
require_once __DIR__ . '/Course.php';
require_once __DIR__ . '/Tag.php';

class Enseignant extends User
{
    protected $id;

    public function __construct($id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }

    // إضافة دالة للحصول على قائمة الدورات الخاصة بالمدرس
    public function getMyCourses()
    {
        $db = Database::getInstance();
        $conn = $db->getConnection();

        $query = "SELECT c.*, cat.nom as category_name, 
                 COUNT(DISTINCT i.id_etudiant) as student_count,
                 GROUP_CONCAT(t.nom) as tags
                 FROM cours c
                 LEFT JOIN categories cat ON c.id_categorie = cat.id_categorie
                 LEFT JOIN cours_tags ct ON c.id = ct.id_cours
                 LEFT JOIN tags t ON ct.id_tag = t.id_tag
                 LEFT JOIN inscriptions i ON c.id = i.id_cours
                 WHERE c.id_enseignant = :id_enseignant
                 GROUP BY c.id
                 ORDER BY c.id DESC";

        $stmt = $conn->prepare($query);
        $stmt->bindParam(':id_enseignant', $this->id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTotalStudents()
    {
        $db = Database::getInstance();
        $conn = $db->getConnection();

        $stmt = $conn->prepare("SELECT COUNT(DISTINCT i.id_etudiant) AS total_students
                               FROM inscriptions i
                               JOIN cours c ON i.id_cours = c.id
                               WHERE c.id_enseignant = :id");
        $stmt->bindParam(':id', $this->id);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total_students'] ?? 0;
    }

    public function getActiveCourses()
    {
        $db = Database::getInstance();
        $conn = $db->getConnection();

        $stmt = $conn->prepare("SELECT COUNT(*) AS active_courses
                               FROM cours
                               WHERE id_enseignant = :id 
                               AND statut = 'actif'");
        $stmt->bindParam(':id', $this->id);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['active_courses'] ?? 0;
    }

    public function getDraftCourses()
    {
        $db = Database::getInstance();
        $conn = $db->getConnection();

        $stmt = $conn->prepare("SELECT COUNT(*) AS draft_courses
                               FROM cours
                               WHERE id_enseignant = :id 
                               AND statut = 'brouillon'");
        $stmt->bindParam(':id', $this->id);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['draft_courses'] ?? 0;
    }

  

    private function ajouterTagACours($idCours, $idTag)
    {
        $db = Database::getInstance();
        $conn = $db->getConnection();

        $stmt = $conn->prepare("INSERT INTO cours_tags (id_cours, id_tag) 
                              VALUES (:id_cours, :id_tag)
                              ON DUPLICATE KEY UPDATE id_cours = id_cours");
        $stmt->bindParam(':id_cours', $idCours);
        $stmt->bindParam(':id_tag', $idTag);
        $stmt->execute();
    }

    public function modifierCours($idCours, $titre, $description, $contenu, $type_contenu, $id_categorie, $tags)
    {
        try {
            $db = Database::getInstance();
            $conn = $db->getConnection();
            
            $conn->beginTransaction();

            // Update course details
            $stmt = $conn->prepare("UPDATE cours 
                                  SET titre = :titre, 
                                      description = :description, 
                                      contenu = :contenu, 
                                      type_contenu = :type_contenu, 
                                      id_categorie = :id_categorie 
                                  WHERE id = :id 
                                  AND id_enseignant = :id_enseignant");
            
            $stmt->execute([
                ':titre' => $titre,
                ':description' => $description,
                ':contenu' => $contenu,
                ':type_contenu' => $type_contenu,
                ':id_categorie' => $id_categorie,
                ':id' => $idCours,
                ':id_enseignant' => $this->id
            ]);

            // Update tags
            $this->supprimerTagsDeCours($idCours);
            foreach ($tags as $tagName) {
                $tag = new Tag($tagName);
                $tagResult = $tag->getTagByName($tagName);
                
                if (!$tagResult) {
                    $createResult = $tag->create();
                    if ($createResult['success']) {
                        $this->ajouterTagACours($idCours, $createResult['id']);
                    }
                } else {
                    $this->ajouterTagACours($idCours, $tagResult['id_tag']);
                }
            }

            $conn->commit();
            return ['success' => true];
        } catch (Exception $e) {
            $conn->rollBack();
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    private function supprimerTagsDeCours($idCours)
    {
        $db = Database::getInstance();
        $conn = $db->getConnection();

        $stmt = $conn->prepare("DELETE FROM cours_tags 
                              WHERE id_cours = :id_cours");
        $stmt->bindParam(':id_cours', $idCours);
        $stmt->execute();
    }

    public function supprimerCours($idCours)
    {
        try {
            $db = Database::getInstance();
            $conn = $db->getConnection();

            $conn->beginTransaction();

            // Verify course belongs to teacher
            $stmt = $conn->prepare("SELECT id FROM cours 
                                  WHERE id = :id 
                                  AND id_enseignant = :id_enseignant");
            $stmt->execute([
                ':id' => $idCours,
                ':id_enseignant' => $this->id
            ]);

            if (!$stmt->fetch()) {
                throw new Exception('Cours non trouvé ou non autorisé');
            }

            // Delete related records
            $this->supprimerTagsDeCours($idCours);
            
            $stmt = $conn->prepare("DELETE FROM inscriptions 
                                  WHERE id_cours = :id_cours");
            $stmt->bindParam(':id_cours', $idCours);
            $stmt->execute();

            $stmt = $conn->prepare("DELETE FROM cours 
                                  WHERE id = :id 
                                  AND id_enseignant = :id_enseignant");
            $stmt->execute([
                ':id' => $idCours,
                ':id_enseignant' => $this->id
            ]);

            $conn->commit();
            return ['success' => true];
        } catch (Exception $e) {
            $conn->rollBack();
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }
// إضافة هذه الدوال في فئة Enseignant

public function getCourseById($courseId)
{
    try {
        $db = Database::getInstance();
        $conn = $db->getConnection();

        $stmt = $conn->prepare("SELECT c.*, cat.nom as category_name 
                               FROM cours c
                               LEFT JOIN categories cat ON c.id_categorie = cat.id_categorie
                               WHERE c.id = :id 
                               AND c.id_enseignant = :id_enseignant");
        
        $stmt->execute([
            ':id' => $courseId,
            ':id_enseignant' => $this->id
        ]);
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        return null;
    }
}

public function getCourseTagsById($courseId)
{
    try {
        $db = Database::getInstance();
        $conn = $db->getConnection();

        $stmt = $conn->prepare("SELECT t.id_tag, t.nom
                               FROM tags t
                               JOIN cours_tags ct ON t.id_tag = ct.id_tag
                               WHERE ct.id_cours = :id_cours");
        
        $stmt->bindParam(':id_cours', $courseId);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        return [];
    }
}
    public function getCoursePerformance()
    {
        $db = Database::getInstance();
        $conn = $db->getConnection();

        $stmt = $conn->prepare("SELECT c.titre, 
                                     COUNT(DISTINCT i.id_etudiant) AS nombre_etudiants
                               FROM cours c
                               LEFT JOIN inscriptions i ON c.id = i.id_cours
                               WHERE c.id_enseignant = :id_enseignant
                               GROUP BY c.id, c.titre");
        $stmt->bindParam(':id_enseignant', $this->id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getMesCours()
{
    $db = Database::getInstance();
    $conn = $db->getConnection();

    $query = "SELECT c.*, cat.nom as category_name, 
              COUNT(DISTINCT i.id_etudiant) as student_count,
              GROUP_CONCAT(t.nom) as tags
              FROM cours c
              LEFT JOIN categories cat ON c.id_categorie = cat.id_categorie
              LEFT JOIN cours_tags ct ON c.id = ct.id_cours
              LEFT JOIN tags t ON ct.id_tag = t.id_tag
              LEFT JOIN inscriptions i ON c.id = i.id_cours
              WHERE c.id_enseignant = :id_enseignant
              GROUP BY c.id
              ORDER BY c.id DESC";

    $stmt = $conn->prepare($query);
    $stmt->bindParam(':id_enseignant', $this->id);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
public function getCourseTags($courseId)
{
    try {
        $db = Database::getInstance();
        $conn = $db->getConnection();

        $stmt = $conn->prepare("
            SELECT t.id_tag, t.nom
            FROM tags t
            JOIN cours_tags ct ON t.id_tag = ct.id_tag
            WHERE ct.id_cours = :id_cours
        ");
        $stmt->bindParam(':id_cours', $courseId);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        // En cas d'erreur, retourner un tableau vide
        error_log('Error fetching course tags: ' . $e->getMessage());
        return [];
    }
}






public function getEnrollmentsForCourse($courseId)
{
    try {
        $db = Database::getInstance();
        $conn = $db->getConnection();

        $stmt = $conn->prepare("
            SELECT u.nom, u.email, i.date_inscription
            FROM inscriptions i
            JOIN utilisateurs u ON i.id_etudiant = u.id
            WHERE i.id_cours = :id_cours
        ");
        $stmt->bindParam(':id_cours', $courseId);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log('Error fetching enrollments: ' . $e->getMessage());
        return [];
    }
}
public function ajouterCours($titre, $description, $contenu, $type_contenu, $id_categorie, $tags)
{
    try {
        $db = Database::getInstance();
        $conn = $db->getConnection();
        
        // Begin transaction
        $conn->beginTransaction();

        // Create the course with status 'en_attente'
        $cours = new Course($titre, $description, $contenu, $type_contenu, $id_categorie, $this->id, 'en_attente');
        $coursId = $cours->create();

        // Add tags
        if (!empty($tags)) {
            foreach ($tags as $tagName) {
                $tag = new Tag($tagName);
                $tagResult = $tag->getTagByName($tagName);
                
                if (!$tagResult) {
                    $createResult = $tag->create();
                    if ($createResult['success']) {
                        $tagId = $createResult['id'];
                    } else {
                        throw new Exception($createResult['message']);
                    }
                } else {
                    $tagId = $tagResult['id_tag'];
                }

                $this->ajouterTagACours($coursId, $tagId);
            }
        }

        $conn->commit();
        return ['success' => true, 'id' => $coursId];
    } catch (Exception $e) {
        $conn->rollBack();
        return ['success' => false, 'message' => $e->getMessage()];
    }
}
}