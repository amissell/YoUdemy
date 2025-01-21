<?php
session_start();
require_once __DIR__ . '/../../models/Course.php';
require_once __DIR__ . '/../../models/Enseignant.php';

// Vérification de l'authentification
if (!isset($_SESSION['user'])) {
    header('Location: ../auth/login.php');
    exit();
}

// Récupérer l'ID du cours
$courseId = $_GET['id'] ?? null;
if (!$courseId) {
    header('Location: myCourses.php');
    exit();
}

// Initialiser les modèles
$enseignant = new Enseignant($_SESSION['user']['id']);
$courseModel = new Course(null, null, null, null, null, null, null);

// Récupérer les détails du cours
$course = $courseModel->getCourseWithDetails($courseId);
if (!$course) {
    header('Location: myCourses.php');
    exit();
}

// Récupérer les tags du cours
$courseTags = $enseignant->getCourseTags($courseId);
?>

<!DOCTYPE html>
<html lang="fr" class="h-full bg-gray-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails du cours - Youdemy</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        /* Style personnalisé pour le lecteur vidéo */
        .video-container {
            position: relative;
            padding-bottom: 56.25%; /* Ratio 16:9 */
            height: 0;
            overflow: hidden;
        }
        .video-container iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }
    </style>
</head>
<body class="h-full">
    <!-- Sidebar -->
    <aside class="hidden lg:flex lg:flex-col lg:w-72 lg:fixed lg:inset-y-0 bg-white border-r border-gray-200">
        <!-- Logo -->
        <div class="flex items-center h-16 px-6 border-b border-gray-200 bg-white">
            <div class="flex items-center gap-2">
                <div class="bg-indigo-600 p-2 rounded-lg">
                    <i class="fas fa-chalkboard-teacher text-white"></i>
                </div>
                <span class="text-xl font-bold text-gray-900">Youdemy</span>
            </div>
        </div>

        <!-- Navigation -->
        <nav class="flex-1 px-4 py-6 space-y-8 overflow-y-auto">
            <div>
                <h3 class="px-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Main</h3>
                <div class="mt-4 space-y-1">
                    <a href="dashboard.php" class="flex items-center px-3 py-2 text-sm font-medium rounded-lg text-gray-600 hover:bg-gray-50">
                        <i class="fas fa-chart-line w-5 h-5"></i>
                        <span class="ml-3">Dashboard</span>
                    </a>
                    <a href="myCourses.php" class="flex items-center px-3 py-2 text-sm font-medium rounded-lg bg-indigo-50 text-indigo-600">
                        <i class="fas fa-book w-5 h-5"></i>
                        <span class="ml-3">My Courses</span>
                    </a>
                    <a href="#" class="flex items-center px-3 py-2 text-sm font-medium rounded-lg text-gray-600 hover:bg-gray-50">
                        <i class="fas fa-users w-5 h-5"></i>
                        <span class="ml-3">Students</span>
                    </a>
                </div>
            </div>

            <div>
                <h3 class="px-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Content</h3>
                <div class="mt-4 space-y-1">
                    <a href="ajouterCours.php" class="flex items-center px-3 py-2 text-sm font-medium rounded-lg text-gray-600 hover:bg-gray-50">
                        <i class="fas fa-plus-circle w-5 h-5"></i>
                        <span class="ml-3">Create Course</span>
                    </a>
                </div>
            </div>
        </nav>
    </aside>

    <!-- Main Content -->
    <div class="lg:pl-72 flex flex-col flex-1">
        <!-- Top Navigation -->
        <header class="sticky top-0 z-10 bg-white border-b border-gray-200 shadow-sm">
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

        <!-- Page Content -->
        <main class="flex-1 p-6">
            <div class="max-w-4xl mx-auto">
                <!-- Titre du cours -->
                <h1 class="text-3xl font-bold text-gray-900 mb-4"><?php echo htmlspecialchars($course['titre']); ?></h1>

                <!-- Description du cours -->
                <p class="text-gray-600 text-lg mb-8"><?php echo htmlspecialchars($course['description']); ?></p>

                <!-- Vidéo YouTube ou Lien Google Drive -->
                <div class="mb-8">
                    <?php if ($course['type_contenu'] === 'video'): ?>
                        <div class="bg-gray-100 rounded-lg overflow-hidden shadow-md">
                            <div class="video-container">
                                <iframe src="https://www.youtube.com/embed/<?php echo htmlspecialchars($course['contenu']); ?>" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                            </div>
                        </div>
                    <?php elseif ($course['type_contenu'] === 'document'): ?>
                        <div class="bg-gray-100 p-6 rounded-lg shadow-md">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Lien Google Drive</label>
                            <a href="<?php echo htmlspecialchars($course['contenu']); ?>" target="_blank" class="text-indigo-600 hover:text-indigo-500 break-words">
                                <?php echo htmlspecialchars($course['contenu']); ?>
                            </a>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Détails supplémentaires -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <!-- Catégorie -->
                    <div class="bg-white p-6 rounded-lg shadow-md">
                        <span class="text-sm text-gray-500">Catégorie:</span>
                        <span class="text-lg font-semibold text-gray-900"><?php echo htmlspecialchars($course['category_name']); ?></span>
                    </div>

                    <!-- Nombre d'étudiants inscrits -->
                    <div class="bg-white p-6 rounded-lg shadow-md">
                        <span class="text-sm text-gray-500">Nombre d'étudiants inscrits:</span>
                        <span class="text-lg font-semibold text-gray-900"><?php echo htmlspecialchars($course['nombre_etudiants']); ?></span>
                    </div>
                </div>

                <!-- Tags -->
                <div class="bg-white p-6 rounded-lg shadow-md mb-8">
                    <span class="text-sm text-gray-500">Tags:</span>
                    <div class="flex flex-wrap gap-2 mt-2">
                        <?php foreach ($courseTags as $tag): ?>
                            <span class="bg-indigo-100 text-indigo-800 text-sm font-medium px-3 py-1 rounded-full">
                                <?php echo htmlspecialchars($tag['nom']); ?>
                            </span>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Bouton de retour -->
                <div class="text-center">
                    <a href="myCourses.php" class="inline-flex items-center justify-center px-6 py-3 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <i class="fas fa-arrow-left mr-2"></i> Retour à mes cours
                    </a>
                </div>
            </div>
        </main>
    </div>
</body>
</html>