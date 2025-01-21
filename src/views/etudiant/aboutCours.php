<!DOCTYPE html>
<html lang="fr" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Développement Web Complet - Youdemy</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f4f6f9;
        }
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .progress-bar {
            background: linear-gradient(to right, #4338ca, #6366f1);
        }
    </style>
</head>
<body class="bg-gray-100 text-gray-900">
    <div class="min-h-screen flex flex-col">
        <!-- Top Navigation -->
        <header class="bg-white shadow-sm sticky top-0 z-10">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
                <div class="flex items-center justify-between">
                    <!-- Logo -->
                    <div class="flex items-center">
                        <div class="bg-indigo-600 p-2 rounded-lg mr-3">
                            <i class="fas fa-graduation-cap text-white"></i>
                        </div>
                        <span class="text-xl font-bold text-gray-900">Youdemy</span>
                    </div>

                    <!-- Navigation and Search -->
                    <div class="flex items-center space-x-6">
                        <nav class="hidden md:flex space-x-4">
                            <a href="#" class="text-gray-600 hover:text-indigo-600 transition-all">Cours</a>
                            <a href="#" class="text-gray-600 hover:text-indigo-600 transition-all">Catégories</a>
                            <a href="#" class="text-gray-600 hover:text-indigo-600 transition-all">Instructeurs</a>
                        </nav>

                        <div class="relative hidden md:block">
                            <input type="text" 
                                   placeholder="Rechercher des cours..." 
                                   class="pl-10 pr-4 py-2 border border-gray-300 rounded-full text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-search text-gray-400"></i>
                            </div>
                        </div>

                        <div class="flex items-center space-x-4">
                            <button class="text-gray-600 hover:text-indigo-600">
                                <i class="fas fa-shopping-cart"></i>
                            </button>
                            <button class="bg-indigo-600 text-white px-4 py-2 rounded-full text-sm hover:bg-indigo-700 transition-all">
                                Connexion
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="flex-grow max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 w-full">
            <div class="grid md:grid-cols-3 gap-8">
                <!-- Course Main Section -->
                <div class="md:col-span-2">
                    <!-- Course Header -->
                    <div class="bg-white rounded-xl shadow-soft p-6 mb-6">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center">
                                <div class="bg-indigo-100 p-3 rounded-lg mr-4">
                                    <i class="fas fa-code text-indigo-600 text-2xl"></i>
                                </div>
                                <div>
                                    <h1 class="text-2xl font-bold text-gray-900">Développement Web Complet</h1>
                                    <p class="text-gray-600 mt-1">Maîtrisez le développement web de A à Z</p>
                                </div>
                            </div>
                            <div class="text-2xl font-bold text-indigo-600">49,99 €</div>
                        </div>

                        <!-- Course Progress -->
                        <div class="mt-6">
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-sm font-medium text-gray-600">Progression</span>
                                <span class="text-sm font-bold text-indigo-600">65%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2.5">
                                <div class="progress-bar h-2.5 rounded-full" style="width: 65%"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Course Tabs -->
                    <div class="bg-white rounded-xl shadow-soft">
                        <div class="border-b border-gray-200">
                            <nav class="-mb-px flex" aria-label="Tabs">
                                <a href="#" class="w-1/3 py-4 text-center text-sm font-medium text-indigo-600 border-b-2 border-indigo-600">
                                    Contenu du Cours
                                </a>
                                <a href="#" class="w-1/3 py-4 text-center text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300">
                                    Description
                                </a>
                                <a href="#" class="w-1/3 py-4 text-center text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300">
                                    Instructeur
                                </a>
                            </nav>
                        </div>

                        <!-- Course Content -->
                        <div class="p-6">
                            <h2 class="text-xl font-bold text-gray-900 mb-4">Contenu du Cours</h2>
                            
                            <!-- Section Accordion -->
                            <div class="space-y-2">
                                <!-- Section 1 -->
                                <div class="border border-gray-200 rounded-lg">
                                    <div class="flex items-center justify-between p-4 cursor-pointer hover:bg-gray-50">
                                        <div class="flex items-center">
                                            <i class="fas fa-chevron-right text-gray-400 mr-4"></i>
                                            <span class="font-medium text-gray-900">Introduction au Développement Web</span>
                                        </div>
                                        <span class="text-sm text-gray-500">5 leçons • 45 min</span>
                                    </div>
                                </div>

                                <!-- Section 2 -->
                                <div class="border border-gray-200 rounded-lg">
                                    <div class="flex items-center justify-between p-4 cursor-pointer hover:bg-gray-50">
                                        <div class="flex items-center">
                                            <i class="fas fa-chevron-right text-gray-400 mr-4"></i>
                                            <span class="font-medium text-gray-900">HTML et CSS Avancés</span>
                                        </div>
                                        <span class="text-sm text-gray-500">8 leçons • 1h 20 min</span>
                                    </div>
                                </div>

                                <!-- Section 3 -->
                                <div class="border border-gray-200 rounded-lg">
                                    <div class="flex items-center justify-between p-4 cursor-pointer hover:bg-gray-50">
                                        <div class="flex items-center">
                                            <i class="fas fa-chevron-right text-gray-400 mr-4"></i>
                                            <span class="font-medium text-gray-900">JavaScript Fondamentaux</span>
                                        </div>
                                        <span class="text-sm text-gray-500">10 leçons • 2h</span>
                                    </div>
                                </div>

                                <!-- More sections... -->
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div>
                    <!-- Course Overview -->
                    <div class="bg-white rounded-xl shadow-soft p-6 mb-6">
                        <h2 class="text-xl font-bold text-gray-900 mb-4">Aperçu du Cours</h2>
                        <ul class="space-y-3">
                            <li class="flex items-center">
                                <i class="fas fa-clock text-indigo-600 mr-3"></i>
                                <span>Durée totale: 15h 30min</span>
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-video text-indigo-600 mr-3"></i>
                                <span>45 Vidéos</span>
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-file text-indigo-600 mr-3"></i>
                                <span>12 Ressources</span>
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-certificate text-indigo-600 mr-3"></i>
                                <span>Certificat de complétion</span>
                            </li>
                        </ul>
                    </div>

                    <!-- Call to Action -->
                    <div class="bg-white rounded-xl shadow-soft p-6">
                        <div class="text-center">
                            <button class="w-full bg-indigo-600 text-white py-3 rounded-lg text-lg font-bold hover:bg-indigo-700 transition-all mb-4">
                                Continuer le Cours
                            </button>
                            <p class="text-sm text-gray-600 mb-4">Ou</p>
                            <button class="w-full border border-indigo-600 text-indigo-600 py-3 rounded-lg text-lg font-bold hover:bg-indigo-50 transition-all">
                                Ajouter aux Favoris
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </main>

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
</body>
</html>