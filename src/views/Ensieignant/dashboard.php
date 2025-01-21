<?php
session_start();
require_once __DIR__ . '/../../models/Course.php';
require_once __DIR__ . '/../../models/Enseignant.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'enseignant') {
    header('Location: ../auth/login.php');
    exit();
}

$enseignant = new Enseignant($_SESSION['user']['id']);
$enseignantId = $_SESSION['user']['id'];

// Fetch statistics
$totalStudents = $enseignant->getTotalStudents();
$activeCourses = $enseignant->getActiveCourses();
$draftCourses = $enseignant->getDraftCourses();
$coursePerformance = $enseignant->getCoursePerformance();
?>

<!DOCTYPE html>
<html lang="en" class="h-full bg-gray-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Youdemy Teacher Dashboard</title>
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
                        <a href="#" class="flex items-center px-3 py-2 text-sm font-medium rounded-lg bg-indigo-50 text-indigo-600">
                            <i class="fas fa-chart-line w-5 h-5"></i>
                            <span class="ml-3">Dashboard</span>
                        </a>
                        <a href="myCourses.php" class="flex items-center px-3 py-2 text-sm font-medium rounded-lg text-gray-600 hover:bg-gray-50">
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
            <header class="sticky top-0 z-10 bg-white border-b border-gray-200">
                <div class="px-4 sm:px-6 lg:px-8 py-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <button class="lg:hidden text-gray-500 hover:text-gray-600">
                                <i class="fas fa-bars text-xl"></i>
                            </button>
                          
                        </div>

                      
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
                <!-- Welcome Section -->
                <div class="mb-8">
                    <h1 class="text-2xl font-bold text-gray-900">Teacher Dashboard</h1>
                    <p class="mt-2 text-sm text-gray-600">Monitor your courses and student engagement.</p>
                </div>

                <!-- Stats Grid -->
                <div class="stats-grid mb-8">
                    <!-- Total Students -->
                    <div class="bg-white p-6 rounded-xl border border-gray-200 hover:shadow-lg transition-all">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center justify-center w-12 h-12 bg-indigo-50 text-indigo-600 rounded-lg">
                                <i class="fas fa-users text-xl"></i>
                            </div>
                          
                        </div>
                        <h3 class="text-gray-900 font-semibold">Total Students</h3>
                        <p class="text-3xl font-bold text-gray-900 mt-2"><?php echo $totalStudents; ?></p>
                        <p class="text-sm text-gray-500 mt-2">+56 this month</p>
                    </div>

                    <!-- Active Courses -->
                    <div class="bg-white p-6 rounded-xl border border-gray-200 hover:shadow-lg transition-all">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center justify-center w-12 h-12 bg-blue-50 text-blue-600 rounded-lg">
                                <i class="fas fa-book text-xl"></i>
                            </div>
                          
                        </div>
                        <h3 class="text-gray-900 font-semibold">Active Courses</h3>
                        <p class="text-3xl font-bold text-gray-900 mt-2"><?php echo $activeCourses; ?></p>
                        <p class="text-sm text-gray-500 mt-2"><?php echo $draftCourses; ?> in draft</p>
                    </div>
                    <!--  -->
                    <div class="bg-white rounded-xl shadow-sm hover:shadow-md transition-all duration-300 p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="flex items-center justify-center h-12 w-12 rounded-lg bg-green-50 text-green-600">
                                    <i class="fas fa-book-open text-xl"></i>
                                </div>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-sm font-medium text-gray-900">Cours en attente</h3>
                                <p class="mt-1 text-2xl font-semibold text-green-600"><?php echo $activeCourses; ?></p>
                            </div>
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