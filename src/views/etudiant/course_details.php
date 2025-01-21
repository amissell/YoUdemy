<?php
session_start();
require_once __DIR__ . '/../../models/Course.php';
require_once __DIR__ . '/../../models/User.php';

// تحقق من المصادقة
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'etudiant') {
    header('Location: ../auth/login.php');
    exit();
}

// تحقق من وجود معرف الدورة
if (!isset($_GET['id'])) {
    header('Location: dashboard.php');
    exit();
}

$courseId = $_GET['id'];

// استرداد تفاصيل الدورة
$courseModel = new Course(null, null, null, null, null, null, null);
$courseDetails = $courseModel->getCourseWithDetails($courseId);

if (!$courseDetails) {
    die("Cours non trouvé.");
}

// استرداد بيانات المستخدم
$userData = User::findById($_SESSION['user']['id']);
if (!$userData) {
    die("Utilisateur non trouvé.");
}
?>

<!DOCTYPE html>
<html lang="fr" class="h-full bg-gray-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails du Cours - Youdemy</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
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
            <div class="bg-white p-6 rounded-xl shadow-sm">
                <h1 class="text-2xl font-bold text-gray-900 mb-4"><?php echo htmlspecialchars($courseDetails['titre']); ?></h1>
                <p class="text-sm text-gray-600 mb-4"><?php echo htmlspecialchars($courseDetails['description']); ?></p>
                <p class="text-sm text-gray-500 mb-4">Enseignant: <?php echo htmlspecialchars($courseDetails['enseignant_nom']); ?></p>
                <p class="text-sm text-gray-500 mb-4">Catégorie: <?php echo htmlspecialchars($courseDetails['category_name']); ?></p>
                <p class="text-sm text-gray-500 mb-4">Tags: <?php echo htmlspecialchars($courseDetails['tags']); ?></p>

                <!-- Display YouTube video or Google Drive link -->
                <?php if ($courseDetails['type_contenu'] === 'video'): ?>
                    <div class="mb-4">
                        <h2 class="text-lg font-bold text-gray-900 mb-2">Vidéo du Cours</h2>
                        <iframe width="560" height="315" src="https://www.youtube.com/embed/<?php echo htmlspecialchars($courseDetails['contenu']); ?>" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                    </div>
                <?php elseif ($courseDetails['type_contenu'] === 'document'): ?>
                    <div class="mb-4">
                        <h2 class="text-lg font-bold text-gray-900 mb-2">Document du Cours</h2>
                        <a href="<?php echo htmlspecialchars($courseDetails['contenu']); ?>" target="_blank" class="text-indigo-600 hover:text-indigo-700">
                            Lien Google Drive
                        </a>
                    </div>
                <?php endif; ?>

                <!-- Back to Dashboard -->
                <a href="dashboard.php" class="mt-4 inline-block bg-indigo-600 text-white py-2 px-4 rounded-lg hover:bg-indigo-700">
                    Retour au Dashboard
                </a>
            </div>
        </main>
    </div>
</body>
</html>