<?php
session_start();
require_once __DIR__ . '/../../models/Course.php';
require_once __DIR__ . '/../../models/Category.php';
require_once __DIR__ . '/../../models/Tag.php';
require_once __DIR__ . '/../../models/Enseignant.php';

// Vérification de l'authentification
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'enseignant') {
    header('Location: ../auth/login.php');
    exit();
}

// Récupérer l'ID du cours à modifier
$courseId = $_GET['id'] ?? null;
if (!$courseId) {
    header('Location: myCourses.php');
    exit();
}

// Initialiser les modèles
$enseignant = new Enseignant($_SESSION['user']['id']);
$courseModel = new Course(null, null, null, null, null, null, null);
$categoryModel = new Category(null);
$tagModel = new Tag();

// Récupérer les détails du cours
$course = $enseignant->getCourseById($courseId);
if (!$course) {
    header('Location: myCourses.php');
    exit();
}

// Récupérer les tags du cours
$courseTags = $enseignant->getCourseTags($courseId);

// Récupérer toutes les catégories et tags pour le formulaire
$categories = $courseModel->getAllCategories();
$allTags = $tagModel->getAllTags();

// Traitement du formulaire de modification
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titre = trim($_POST['titre'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $type_contenu = trim($_POST['type_contenu'] ?? '');
    $id_categorie = filter_input(INPUT_POST, 'id_categorie', FILTER_VALIDATE_INT);
    $selectedTags = isset($_POST['tags']) ? (array)$_POST['tags'] : [];
    $youtube_url = trim($_POST['youtube_url'] ?? '');
    $drive_link = trim($_POST['drive_link'] ?? '');

    // Validation des données
    if (!$titre || !$description || !$type_contenu || !$id_categorie || empty($selectedTags)) {
        $error = 'Veuillez remplir tous les champs obligatoires.';
    } else {
        try {
            $contenu = '';
            
            if ($type_contenu === 'video') {
                if (empty($youtube_url)) {
                    throw new Exception('Le lien YouTube est requis pour les vidéos.');
                }
                // Extraire l'ID de la vidéo YouTube
                if (preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $youtube_url, $matches)) {
                    $contenu = $matches[1]; // Stocker uniquement l'ID de la vidéo
                } else {
                    throw new Exception('Le lien YouTube n\'est pas valide.');
                }
            } else if ($type_contenu === 'document') {
                if (empty($drive_link)) {
                    throw new Exception('Le lien Google Drive est requis pour les documents.');
                }
                $contenu = $drive_link;  // Stocker le lien Google Drive
            }

            // Mettre à jour le cours
            $enseignant->modifierCours(
                $courseId,
                $titre,
                $description,
                $contenu,
                $type_contenu,
                $id_categorie,
                $selectedTags
            );

            $_SESSION['success_message'] = 'Le cours a été modifié avec succès!';
            header('Location: myCourses.php');
            exit();
        } catch (Exception $e) {
            $error = 'Erreur: ' . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr" class="h-full bg-gray-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier un cours - Youdemy</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
</head>
<body class="h-full">
    <!-- Top Navigation -->
    <header class="sticky top-0 z-10 bg-white border-b border-gray-200">
        <div class="px-4 sm:px-6 lg:px-8 py-4">
            <div class="flex items-center justify-between">
                <!-- Dashboard Button -->
                <div class="flex items-center gap-4">
                    <a href="dashboard.php" class="flex items-center gap-2 p-2 rounded-lg hover:bg-gray-50">
                        <i class="fas fa-tachometer-alt text-gray-600"></i>
                        <span class="hidden sm:block font-medium text-sm text-gray-700">Dashboard</span>
                    </a>
                </div>

                <!-- Logout Button -->
                <div class="flex items-center gap-4">
                    <a href="../auth/logout.php" class="flex items-center gap-2 p-2 rounded-lg hover:bg-gray-50">
                        <i class="fas fa-sign-out-alt text-gray-600"></i>
                        <span class="hidden sm:block font-medium text-sm text-gray-700">Logout</span>
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <div class="lg:pl-72 flex flex-col flex-1">
        <!-- Page Content -->
        <main class="flex-1 p-6">
            <h1 class="text-2xl font-bold text-gray-900 mb-8">Modifier un cours</h1>

            <?php if (isset($error)): ?>
                <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>

            <form action="edit_course.php?id=<?php echo $courseId; ?>" method="POST" class="bg-white p-6 rounded-xl shadow-sm">
                <div class="space-y-6">
                    <!-- Titre -->
                    <div>
                        <label for="titre" class="block text-sm font-medium text-gray-700">Titre du cours</label>
                        <input type="text" id="titre" name="titre" required
                               value="<?php echo htmlspecialchars($course['titre']); ?>"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>

                    <!-- Description -->
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                        <textarea id="description" name="description" rows="4" required
                                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"><?php echo htmlspecialchars($course['description']); ?></textarea>
                    </div>

                    <!-- Type de contenu -->
                    <div>
                        <label for="type_contenu" class="block text-sm font-medium text-gray-700">Type de contenu</label>
                        <select id="type_contenu" name="type_contenu" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="video" <?php echo $course['type_contenu'] === 'video' ? 'selected' : ''; ?>>Vidéo</option>
                            <option value="document" <?php echo $course['type_contenu'] === 'document' ? 'selected' : ''; ?>>Document</option>
                        </select>
                    </div>

                    <!-- YouTube URL field -->
                    <div id="youtube_url_field" style="<?php echo $course['type_contenu'] === 'video' ? '' : 'display: none;'; ?>">
                        <label for="youtube_url" class="block text-sm font-medium text-gray-700">Lien YouTube</label>
                        <input type="url" id="youtube_url" name="youtube_url"
                               value="<?php echo $course['type_contenu'] === 'video' ? 'https://www.youtube.com/watch?v=' . htmlspecialchars($course['contenu']) : ''; ?>"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                               placeholder="https://www.youtube.com/watch?v=...">
                        <p class="mt-1 text-sm text-gray-500">Collez le lien de votre vidéo YouTube ici</p>
                    </div>

                    <!-- Google Drive link field -->
                    <div id="drive_link_field" style="<?php echo $course['type_contenu'] === 'document' ? '' : 'display: none;'; ?>">
                        <label for="drive_link" class="block text-sm font-medium text-gray-700">Lien Google Drive</label>
                        <input type="url" id="drive_link" name="drive_link"
                               value="<?php echo $course['type_contenu'] === 'document' ? htmlspecialchars($course['contenu']) : ''; ?>"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                               placeholder="https://drive.google.com/file/d/...">
                        <p class="mt-1 text-sm text-gray-500">Collez le lien de votre document Google Drive ici</p>
                    </div>

                    <!-- Catégorie -->
                    <div>
                        <label for="id_categorie" class="block text-sm font-medium text-gray-700">Catégorie</label>
                        <select id="id_categorie" name="id_categorie" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <?php foreach ($categories as $category): ?>
                                <option value="<?php echo htmlspecialchars($category['id_categorie']); ?>"
                                    <?php echo $category['id_categorie'] == $course['id_categorie'] ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($category['nom']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Tags -->
                    <div>
                        <label for="tags" class="block text-sm font-medium text-gray-700">Tags</label>
                        <select id="tags" name="tags[]" multiple required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <?php foreach ($allTags as $tag): ?>
                                <option value="<?php echo htmlspecialchars($tag['id_tag']); ?>"
                                    <?php echo in_array($tag['id_tag'], array_column($courseTags, 'id_tag')) ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($tag['nom']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Submit Button -->
                    <div>
                        <button type="submit"
                                class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Enregistrer les modifications
                        </button>
                    </div>
                </div>
            </form>
        </main>
    </div>

    <script>
        $(document).ready(function() {
            // Initialize Select2 for tags
            $('#tags').select2({
                placeholder: 'Sélectionnez les tags',
                allowClear: true
            });

            // Toggle fields based on content type
            $('#type_contenu').change(function() {
                const contentType = $(this).val();
                if (contentType === 'video') {
                    $('#youtube_url_field').show();
                    $('#drive_link_field').hide();
                    $('#drive_link').prop('required', false);
                    $('#youtube_url').prop('required', true);
                } else {
                    $('#youtube_url_field').hide();
                    $('#drive_link_field').show();
                    $('#drive_link').prop('required', true);
                    $('#youtube_url').prop('required', false);
                }
            });

            // Trigger change event to set initial state
            $('#type_contenu').trigger('change');
        });
    </script>
</body>
</html>