<?php
session_start();
require_once __DIR__ . '/../../models/Enseignant.php';

// Vérification de l'authentification
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'enseignant') {
    header('Location: ../auth/login.php');
    exit();
}

// Récupérer l'ID du cours
$courseId = $_GET['id'] ?? null;
if (!$courseId) {
    header('Location: myCourses.php');
    exit();
}

// Initialiser le modèle Enseignant
$enseignant = new Enseignant($_SESSION['user']['id']);

// Récupérer les inscriptions pour ce cours
$enrollments = $enseignant->getEnrollmentsForCourse($courseId);
?>

<!DOCTYPE html>
<html lang="fr" class="h-full bg-gray-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscriptions - Youdemy</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="h-full">
    <div class="min-h-screen bg-gray-50 flex">
        <!-- Sidebar (identique à myCourses.php) -->
        <aside class="hidden lg:flex lg:flex-col lg:w-72 lg:fixed lg:inset-y-0 bg-white border-r border-gray-200">
            <!-- ... Votre code pour la barre latérale ... -->
        </aside>

        <!-- Main Content -->
        <div class="lg:pl-72 flex flex-col flex-1">
            <!-- Top Navigation (identique à myCourses.php) -->
            <header class="sticky top-0 z-10 bg-white border-b border-gray-200">
                <!-- ... Votre code pour le header ... -->
            </header>

            <!-- Page Content -->
            <main class="flex-1 p-6">
                <h1 class="text-2xl font-bold text-gray-900 mb-8">Inscriptions pour le cours</h1>

                <div class="bg-white p-6 rounded-xl shadow-sm">
                    <table class="min-w-full">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nom</th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date d'inscription</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php foreach ($enrollments as $enrollment): ?>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap"><?php echo htmlspecialchars($enrollment['nom']); ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap"><?php echo htmlspecialchars($enrollment['email']); ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap"><?php echo htmlspecialchars($enrollment['date_inscription']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </main>
        </div>
    </div>
</body>
</html>