<?php
session_start();

require_once __DIR__ . '/../../config/connection.php';
require_once __DIR__ . '/../../models/Tag.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: ../auth/login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr" class="h-full bg-gray-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Tags - Youdemy</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        body {
            font-family: 'Poppins', sans-serif;
        }
        .tag-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 1.5rem;
        }
    </style>
</head>
<body class="h-full">
    <div class="min-h-full">
        <!-- Navigation -->
        <nav class="bg-white border-b border-gray-200 fixed w-full z-30 top-0">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <!-- Logo et liens de navigation -->
                    <div class="flex">
                        <div class="flex-shrink-0 flex items-center">
                            <h2 class="text-xl font-bold text-indigo-600">Youdemy</h2>
                        </div>
                        <div class="hidden sm:ml-6 sm:flex sm:space-x-8">
                            <a href="dashboard.php" class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium transition-colors duration-200">
                                <i class="fas fa-chart-line mr-2"></i>
                                Tableau de Bord
                            </a>
                            <a href="all_courses.php" class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium transition-colors duration-200">
                                <i class="fas fa-graduation-cap mr-2"></i>
                                Cours
                            </a>
                            <a href="#" class="border-indigo-500 text-gray-900 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                                <i class="fas fa-tags mr-2"></i>
                                Tags
                            </a>
                        </div>
                    </div>

                    <!-- Section droite avec profil -->
                    <div class="hidden sm:ml-6 sm:flex sm:items-center">
                        <!-- Menu profil -->
                        <div class="ml-3 relative">
                            <div class="flex items-center">
                                <button type="button" class="bg-white flex text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 items-center" id="user-menu-button" aria-expanded="false" aria-haspopup="true" onclick="toggleProfileDropdown()">
                                    <span class="sr-only">Open user menu</span>
                                    <img class="h-8 w-8 rounded-full object-cover border-2 border-gray-200" src="https://ui-avatars.com/api/?name=<?php echo urlencode($_SESSION['user']['nom']); ?>&background=random" alt="">
                                    <span class="ml-2 text-gray-700 font-medium"><?php echo htmlspecialchars($_SESSION['user']['nom']); ?></span>
                                    <i class="fas fa-chevron-down ml-2 text-gray-400"></i>
                                </button>
                            </div>
                            <!-- Menu déroulant du profil -->
                            <div id="profile-dropdown" class="hidden origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none" role="menu">
                                <hr class="my-1">
                                <a href="../auth/logout.php" class="block px-4 py-2 text-sm text-red-700 hover:bg-red-50" role="menuitem" onclick="return confirm('Êtes-vous sûr de vouloir vous déconnecter ?');">
                                    <i class="fas fa-sign-out-alt mr-2"></i>
                                    Déconnexion
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Bouton menu mobile -->
                    <div class="flex items-center sm:hidden">
                        <button type="button" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500" aria-controls="mobile-menu" aria-expanded="false" onclick="toggleMobileMenu()">
                            <span class="sr-only">Open main menu</span>
                            <i class="fas fa-bars text-xl"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Menu mobile -->
            <div class="sm:hidden hidden" id="mobile-menu">
                <div class="pt-2 pb-3 space-y-1">
                    <a href="dashboard.php" class="border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800 block pl-3 pr-4 py-2 border-l-4 text-base font-medium">
                        <i class="fas fa-chart-line mr-2"></i>
                        Tableau de Bord
                    </a>
                    <a href="all_courses.php" class="border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800 block pl-3 pr-4 py-2 border-l-4 text-base font-medium">
                        <i class="fas fa-graduation-cap mr-2"></i>
                        Cours
                    </a>
                    <a href="#" class="bg-indigo-50 border-indigo-500 text-indigo-700 block pl-3 pr-4 py-2 border-l-4 text-base font-medium">
                        <i class="fas fa-tags mr-2"></i>
                        Tags
                    </a>
                </div>
                <div class="pt-4 pb-3 border-t border-gray-200">
                    <div class="flex items-center px-4">
                        <div class="flex-shrink-0">
                            <img class="h-10 w-10 rounded-full" src="https://ui-avatars.com/api/?name=<?php echo urlencode($_SESSION['user']['nom']); ?>&background=random" alt="">
                        </div>
                        <div class="ml-3">
                            <div class="text-base font-medium text-gray-800"><?php echo htmlspecialchars($_SESSION['user']['nom']); ?></div>
                            <div class="text-sm font-medium text-gray-500"><?php echo htmlspecialchars($_SESSION['user']['email']); ?></div>
                        </div>
                    </div>
                    <div class="mt-3 space-y-1">
                        <a href="../auth/logout.php" class="block px-4 py-2 text-base font-medium text-red-600 hover:text-red-800 hover:bg-red-50" onclick="return confirm('Êtes-vous sûr de vouloir vous déconnecter ?');">
                            <i class="fas fa-sign-out-alt mr-2"></i>
                            Déconnexion
                        </a>
                    </div>
                </div>
            </div>
        </nav>

        <!-- En-tête -->
        <header class="bg-white shadow mt-16">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <div class="md:flex md:items-center md:justify-between">
                    <div class="flex-1 min-w-0">
                        <h1 class="text-3xl font-bold text-gray-900">Gestion des Tags</h1>
                    </div>
                    <div class="mt-4 flex md:mt-0 md:ml-4">
                        <div class="relative mr-4">
                            <input type="text" placeholder="Rechercher des tags..." class="w-64 pl-10 pr-4 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-search text-gray-400"></i>
                            </div>
                        </div>
                        <button onclick="openModal()" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <i class="fas fa-plus mr-2"></i>
                            Ajouter un Tag
                        </button>
                    </div>
                </div>
            </div>
        </header>

        <!-- Contenu principal -->
        <main class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
            <!-- Stats Overview -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
          

        

                <!-- Unused Tags -->
            
            </div>

            <!-- Tags Grid -->
            <div class="tag-grid">
                <?php
                $tag = new Tag();
                $tags = $tag->getAllTags();
                foreach ($tags as $tagData): ?>
                    <div class="bg-white rounded-xl border border-gray-200 p-6 hover:shadow-lg transition-all duration-300">
                        <div class="flex items-center justify-between mb-4">
                            <span class="px-3 py-1 rounded-full bg-indigo-50 text-indigo-600 text-sm font-medium">
                                <?php echo htmlspecialchars($tagData['nom']); ?>
                            </span>
                            <div class="flex items-center gap-2">
                                <button class="text-gray-400 hover:text-gray-500 transition-colors duration-200" 
                                        onclick="openEditModal(<?php echo $tagData['id_tag']; ?>, '<?php echo htmlspecialchars($tagData['nom']); ?>')">
                                    <i class="fas fa-pencil"></i>
                                </button>
                                <button class="text-gray-400 hover:text-red-500 transition-colors duration-200" 
                                        onclick="deleteTag(<?php echo $tagData['id_tag']; ?>)">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                        <h3 class="font-semibold text-gray-900"><?php echo htmlspecialchars($tagData['nom']); ?></h3>
                        <div class="mt-4">
                            <div class="flex items-center gap-4 text-sm text-gray-500">
                                <span class="flex items-center">
                                    <i class="fas fa-book mr-2"></i>
                                    X Cours
                                </span>
                                <span class="flex items-center">
                                    <i class="fas fa-users mr-2"></i>
                                    X Étudiants
                                </span>
                            </div>
                        </div>
                        </div>
                <?php endforeach; ?>
            </div>
        </main>
    </div>

    <!-- Add Tag Modal -->
    <div id="addTagModal" class="hidden fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full mx-4">
            <!-- Modal Header -->
            <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                <h3 class="text-lg font-medium text-gray-900">Ajouter un Nouveau Tag</h3>
                <button onclick="closeModal()" class="text-gray-400 hover:text-gray-500 transition-colors duration-200">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <!-- Modal Body -->
            <div class="px-6 py-4">
                <form id="tagForm" onsubmit="handleSubmit(event)">
                    <div class="mb-4">
                        <label for="tagName" class="block text-sm font-medium text-gray-700 mb-2">
                            Nom du Tag <span class="text-red-500">*</span>
                        </label>
                        <input type="text"
                               id="tagName"
                               name="tagName"
                               required
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                               placeholder="Entrez le nom du tag">
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-200">
                        <button type="button"
                                onclick="closeModal()"
                                class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200">
                            Annuler
                        </button>
                        <button type="submit"
                                class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200">
                            Ajouter
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Tag Modal -->
    <div id="editTagModal" class="hidden fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full mx-4">
            <!-- Modal Header -->
            <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                <h3 class="text-lg font-medium text-gray-900">Modifier le Tag</h3>
                <button onclick="closeEditModal()" class="text-gray-400 hover:text-gray-500 transition-colors duration-200">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <!-- Modal Body -->
            <div class="px-6 py-4">
                <form id="editTagForm" onsubmit="handleEditSubmit(event)">
                    <div class="mb-4">
                        <label for="editTagName" class="block text-sm font-medium text-gray-700 mb-2">
                            Nom du Tag <span class="text-red-500">*</span>
                        </label>
                        <input type="text"
                               id="editTagName"
                               name="editTagName"
                               required
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                               placeholder="Entrez le nom du tag">
                    </div>

                    <input type="hidden" id="editTagId" name="editTagId">

                    <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-200">
                        <button type="button"
                                onclick="closeEditModal()"
                                class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200">
                            Annuler
                        </button>
                        <button type="submit"
                                class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200">
                            Mettre à jour
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Fonctions pour le menu profil et mobile
        function toggleProfileDropdown() {
            const dropdown = document.getElementById('profile-dropdown');
            dropdown.classList.toggle('hidden');
        }

        function toggleMobileMenu() {
            const mobileMenu = document.getElementById('mobile-menu');
            mobileMenu.classList.toggle('hidden');
        }

        // Gestion des modals
        function openModal() {
            document.getElementById('addTagModal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('addTagModal').classList.add('hidden');
        }

        function openEditModal(tagId, tagName) {
            document.getElementById('editTagName').value = tagName;
            document.getElementById('editTagId').value = tagId;
            document.getElementById('editTagModal').classList.remove('hidden');
        }

        function closeEditModal() {
            document.getElementById('editTagModal').classList.add('hidden');
        }

        // Gestion des formulaires
        function handleSubmit(event) {
            event.preventDefault();
            const formData = new FormData(event.target);
            const tagName = formData.get('tagName');

            fetch('addTag.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ tagName }),
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Tag ajouté avec succès!');
                    closeModal();
                    location.reload();
                } else {
                    alert('Erreur lors de l\'ajout du tag: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Erreur:', error);
                alert('Une erreur est survenue lors de l\'ajout du tag');
            });
        }

        function handleEditSubmit(event) {
            event.preventDefault();
            const tagId = document.getElementById('editTagId').value;
            const newName = document.getElementById('editTagName').value;

            fetch('updateTag.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ tagId, newName }),
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Tag mis à jour avec succès!');
                    closeEditModal();
                    location.reload();
                } else {
                    alert('Erreur lors de la mise à jour du tag: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Erreur:', error);
                alert('Une erreur est survenue lors de la mise à jour du tag');
            });
        }

        function deleteTag(tagId) {
            if (confirm('Êtes-vous sûr de vouloir supprimer ce tag?')) {
                fetch('deleteTag.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ tagId }),
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Tag supprimé avec succès!');
                        location.reload();
                    } else {
                        alert('Erreur lors de la suppression du tag: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Erreur:', error);
                    alert('Une erreur est survenue lors de la suppression du tag');
                });
            }
        }

        // Fermer les dropdowns quand on clique en dehors
        document.addEventListener('click', function(event) {
            const profileDropdown = document.getElementById('profile-dropdown');
            const profileButton = document.getElementById('user-menu-button');

            if (!profileButton?.contains(event.target) && !profileDropdown?.contains(event.target)) {
                profileDropdown?.classList.add('hidden');
            }
        });

        // Fonctionnalité de recherche
        const searchInput = document.querySelector('input[placeholder="Rechercher des tags..."]');
        if (searchInput) {
            searchInput.addEventListener('input', function(e) {
                const searchTerm = e.target.value.toLowerCase();
                const tagCards = document.querySelectorAll('.tag-grid > div');

                tagCards.forEach(card => {
                    const tagName = card.querySelector('h3').textContent.toLowerCase();
                    if (tagName.includes(searchTerm)) {
                        card.style.display = '';
                    } else {
                        card.style.display = 'none';
                    }
                });
            });
        }
    </script>
</body>
</html>