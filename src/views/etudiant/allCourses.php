<?php
session_start();
require_once __DIR__ . '/../../models/Course.php';
require_once __DIR__ . '/../../models/User.php';

// تحقق من المصادقة
// if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'etudiant') {
//     header('Location: ../auth/login.php');
//     exit();
// }

// تحقق من وجود معرف الدورة
// if (!isset($_GET['id'])) {
//     header('Location: dashboard.php');
//     exit();
// }




$courseModel = new Course(null, null, null, null, null, null, null);
$courseDetails = $courseModel->getAllCours();

if (!$courseDetails) {
    die("Cours non trouvé.");
}


$userData = User::findById($_SESSION['user']['id']);
if (!$userData) {
    die("Utilisateur non trouvé.");
}
?>
<!DOCTYPE html>
<html lang="fr" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catalogue des Cours - Youdemy</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8fafc;
        }
        .custom-gradient {
            background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
        }
        .course-card {
            transition: all 0.3s ease;
            transform-origin: center;
        }
        .course-card:hover {
            transform: scale(1.03);
            box-shadow: 0 15px 30px -10px rgba(41, 41, 119, 0.2);
        }
        .badge-gradient {
            background: linear-gradient(to right, #6a11cb 0%, #2575fc 100%);
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-900">
    <div class="min-h-screen flex flex-col">
        <!-- Navigation -->
        <header class="sticky top-0 z-50 bg-white shadow-md">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
                <div class="flex items-center justify-between">
                    <!-- Logo -->
                    <div class="flex items-center">
                        <div class="custom-gradient text-white p-2.5 rounded-lg mr-3">
                            <i class="fas fa-graduation-cap text-xl"></i>
                        </div>
                        <span class="text-xl font-bold text-gray-900">Youdemy</span>
                    </div>

                    <!-- Navigation -->
                    <nav class="hidden md:flex items-center space-x-6">
                        <a href="#" class="text-gray-600 hover:text-indigo-600 transition-colors">Accueil</a>
                        <a href="#" class="text-indigo-600 font-semibold border-b-2 border-indigo-600">Cours</a>
                        <a href="#" class="text-gray-600 hover:text-indigo-600 transition-colors">Catégories</a>
                    </nav>

                    <!-- Actions -->
                    <div class="flex items-center space-x-4">
                        <div class="relative hidden md:block">
                            <input type="text" 
                                   placeholder="Rechercher des cours..." 
                                   class="pl-10 pr-4 py-2 w-64 border border-gray-300 rounded-full text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                        </div>
                        <button class="bg-indigo-600 text-white px-4 py-2 rounded-full text-sm hover:bg-indigo-700 transition-colors">
                            Connexion
                        </button>
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

                <p class="text-sm text-gray-500 mb-4">Catégorie: <?php echo htmlspecialchars($courseDetails['nom.categories']); ?></p>
                <p class="text-sm text-gray-500 mb-4">Tags: <?php echo htmlspecialchars($courseDetails['nom.tags']); ?></p>

                <!-- Display YouTube video or Google Drive link -->
                <?php if ($courseDetails['contenu'] === 'video'): ?>
                    <div class="mb-4">
                        <h2 class="text-lg font-bold text-gray-900 mb-2">Vidéo du Cours</h2>
                        <iframe width="560" height="315" src="https://www.youtube.com/<?php echo htmlspecialchars($courseDetails['contenu']); ?>" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                    </div>
                <?php elseif ($courseDetails['description'] === 'document'): ?>
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

        <!-- Footer -->
        <footer class="bg-white border-t border-gray-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                <div class="grid md:grid-cols-4 gap-8">
                    <div>
                        <h3 class="text-lg font-bold mb-4">Youdemy</h3>
                        <p class="text-gray-600">Plateforme d'apprentissage en ligne pour développer vos compétences.</p>
                    </div>
                    <div>
                        <h4 class="font-semibold mb-4">Liens Rapides</h4>
                        <ul class="space-y-2">
                            <li><a href="#" class="text-gray-600 hover:text-indigo-600">Cours</a></li>
                            <li><a href="#" class="text-gray-600 hover:text-indigo-600">Catégories</a></li>
                            <li><a href="#" class="text-gray-600 hover:text-indigo-600">Instructeurs</a></li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="font-semibold mb-4">Support</h4>
                        <ul class="space-y-2">
                            <li><a href="#" class="text-gray-600 hover:text-indigo-600">Contact</a></li>
                            <li><a href="#" class="text-gray-600 hover:text-indigo-600">FAQ</a></li>
                            <li><a href="#" class="text-gray-600 hover:text-indigo-600">Aide</a></li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="font-semibold mb-4">Suivez-nous</h4>
                        <div class="flex space-x-4">
                            <a href="#" class="text-gray-600 hover:text-indigo-600"><i class="fab fa-facebook"></i></a>
                            <a href="#" class="text-gray-600 hover:text-indigo-600"><i class="fab fa-twitter"></i></a>
                            <a href="#" class="text-gray-600 hover:text-indigo-600"><i class="fab fa-instagram"></i></a>
                            <a href="#" class="text-gray-600 hover:text-indigo-600"><i class="fab fa-linkedin"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    <script>
        // Simple mobile menu toggle (for demonstration)
        document.addEventListener('DOMContentLoaded', () => {
            const menuToggle = document.querySelector('.mobile-menu-toggle');
            const mobileMenu = document.querySelector('.mobile-menu');
            
            if (menuToggle && mobileMenu) {
                menuToggle.addEventListener('click', () => {
                    mobileMenu.classList.toggle('hidden');
                });
            }
        });
    </script>
</body>