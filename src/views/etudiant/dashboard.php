<?php
session_start();
require_once __DIR__ . '/../../models/User.php';
require_once __DIR__ . '/../../models/Etudiant.php';
require_once __DIR__ . '/../../models/Course.php';
require_once __DIR__ . '/../../models/Inscription.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'etudiant') {
    header('Location: ../auth/login.php');
    exit();
}

$etudiantId = $_SESSION['user']['id'];

$userData = User::findById($etudiantId);

if (!$userData) {
    die("Utilisateur non trouvé.");
}

$etudiant = new Etudiant(
    $userData['nom'],
    $userData['email'],
    $userData['password'],
    $userData['role'],
    $userData['status']
);

$courseModel = new Course(null, null, null, null, null, null, null);

$search = isset($_GET['search']) ? $_GET['search'] : null;
$courses = $courseModel->getAllCoursesWithDetails(null, $search);

$mesCours = $etudiant->getMesCours();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['inscription'])) {
    $courseId = $_POST['course_id'];
    $result = $etudiant->inscriptionCours($courseId);

    if ($result['success']) {
        $_SESSION['success_message'] = $result['message'];
    } else {
        $_SESSION['error_message'] = $result['message'];
    }

    header('Location: dashboard.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en" class="h-full bg-gray-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Youdemy Student Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        ::-webkit-scrollbar { width: 5px; height: 5px; }
        ::-webkit-scrollbar-track { background: #f8fafc; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 5px; }
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 1.5rem;
        }
    </style>
</head>
<body class="h-full">
    <div class="min-h-screen bg-gray-50 flex">
        <!-- Sidebar -->
        <aside class="hidden lg:flex lg:flex-col lg:w-72 lg:fixed lg:inset-y-0 bg-white border-r border-gray-200">
            <!-- Logo -->
            <div class="flex items-center h-16 px-6 border-b border-gray-200 bg-white">
                <div class="flex items-center gap-2">
                    <div class="bg-indigo-600 p-2 rounded-lg">
                        <i class="fas fa-user-graduate text-white"></i>
                    </div>
                    <span class="text-xl font-bold text-gray-900">Youdemy</span>
                </div>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 px-4 py-6 space-y-8 overflow-y-auto">
                <div>
                    <h3 class="px-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Main</h3>
                    <div class="mt-4 space-y-1">
                        <a href="#" class="flex items-center px-3 py-2 text-sm font-medium rounded-lg bg-indigo-50 text-indigo-600">
                            <i class="fas fa-chart-line w-5 h-5"></i>
                            <span class="ml-3">Dashboard</span>
                        </a>
                        <a href="course_details.php" class="flex items-center px-3 py-2 text-sm font-medium rounded-lg text-gray-600 hover:bg-gray-50">
                            <i class="fas fa-book w-5 h-5"></i>
                            <span class="ml-3">Mes Cours</span>
                        </a>
                    </div>
                </div>

                <!-- Logout Button -->
                <div>
                    <h3 class="px-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Account</h3>
                    <div class="mt-4 space-y-1">
                        <a href="../auth/logout.php" class="flex items-center px-3 py-2 text-sm font-medium rounded-lg text-gray-600 hover:bg-gray-50">
                            <i class="fas fa-sign-out-alt w-5 h-5"></i>
                            <span class="ml-3">Logout</span>
                        </a>
                    </div>
                </div>
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="lg:pl-72 flex flex-col flex-1">
            <!-- Top Navigation -->
            <header class="sticky top-0 z-10 bg-white border-b border-gray-200">
                <div class="px-4 sm:px-6 lg:px-8 py-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <button class="lg:hidden text-gray-500 hover:text-gray-600">
                                <i class="fas fa-bars text-xl"></i>
                            </button>
                            <div class="hidden sm:block">
                                <form action="dashboard.php" method="GET">
                                    <input type="text"
                                           name="search"
                                           placeholder="Search your courses..."
                                           class="w-64 pl-10 pr-4 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                    <button type="submit" class="hidden">Search</button>
                                </form>
                            </div>
                        </div>

                        <div class="flex items-center gap-4">
                            <!-- Logout Button -->
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
                <!-- Welcome Section -->
                <div class="mb-8">
                    <h1 class="text-2xl font-bold text-gray-900">Student Dashboard</h1>
                    <p class="mt-2 text-sm text-gray-600">Explore courses and manage your learning journey.</p>
                </div>

                <!-- Display success or error messages -->
                <?php if (isset($_SESSION['success_message'])): ?>
                    <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
                        <?php echo htmlspecialchars($_SESSION['success_message']); ?>
                        <?php unset($_SESSION['success_message']); ?>
                    </div>
                <?php endif; ?>

                <?php if (isset($_SESSION['error_message'])): ?>
                    <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
                        <?php echo htmlspecialchars($_SESSION['error_message']); ?>
                        <?php unset($_SESSION['error_message']); ?>
                    </div>
                <?php endif; ?>

                <!-- Catalogue des Cours -->
                <div class="mb-8">
                    <h2 class="text-xl font-bold text-gray-900 mb-4">Catalogue des Cours</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <?php foreach ($courses as $course): ?>
                            <div class="bg-white p-6 rounded-xl border border-gray-200 hover:shadow-lg transition-all">
                                <h3 class="text-lg font-bold text-gray-900"><?php echo htmlspecialchars($course['titre']); ?></h3>
                                <p class="text-sm text-gray-600 mt-2"><?php echo htmlspecialchars($course['description']); ?></p>
                                <p class="text-sm text-gray-500 mt-2">Enseignant: <?php echo htmlspecialchars($course['enseignant_nom']); ?></p>
                                <p class="text-sm text-gray-500 mt-2">Étudiants inscrits: <?php echo htmlspecialchars($course['nombre_etudiants']); ?></p>
                                <form action="dashboard.php" method="POST" class="mt-4">
                                    <input type="hidden" name="course_id" value="<?php echo htmlspecialchars($course['id']); ?>">
                                    <button type="submit" name="inscription" class="w-full bg-indigo-600 text-white py-2 px-4 rounded-lg hover:bg-indigo-700">
                                        S'inscrire
                                    </button>
                                </form>
                                <a href="course_details.php?id=<?php echo htmlspecialchars($course['id']); ?>" class="mt-4 inline-block w-full bg-indigo-600 text-white py-2 px-4 rounded-lg hover:bg-indigo-700 text-center">
                                    Voir les détails
                                </a>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Mes Cours -->
                <div id="mes-cours" class="mb-8">
                    <h2 class="text-xl font-bold text-gray-900 mb-4">Mes Cours</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <?php foreach ($mesCours as $course): ?>
                            <div class="bg-white p-6 rounded-xl border border-gray-200 hover:shadow-lg transition-all">
                                <h3 class="text-lg font-bold text-gray-900"><?php echo htmlspecialchars($course['titre']); ?></h3>
                                <p class="text-sm text-gray-600 mt-2"><?php echo htmlspecialchars($course['description']); ?></p>
                                <p class="text-sm text-gray-500 mt-2">Enseignant: <?php echo htmlspecialchars($course['enseignant_nom']); ?></p>
                                <!-- Add a button to view course details -->
                                <a href="course_details.php?id=<?php echo htmlspecialchars($course['id']); ?>" class="mt-4 inline-block w-full bg-indigo-600 text-white py-2 px-4 rounded-lg hover:bg-indigo-700 text-center">
                                    Voir les détails
                                </a>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script>
        // Mobile menu toggle
        const menuButton = document.querySelector('button');
        const sidebar = document.querySelector('aside');

        menuButton.addEventListener('click', () => {
            sidebar.classList.toggle('hidden');
        });

        // Close mobile menu when clicking outside
        document.addEventListener('click', (e) => {
            if (!sidebar.contains(e.target) && !menuButton.contains(e.target)) {
                sidebar.classList.add('hidden');
            }
        });
    </script>
</body>
</html>