<?php
session_start();

require_once __DIR__ . '/../../config/connection.php';
require_once __DIR__ . '/../../models/Admin.php';
require_once __DIR__ . '/../../models/Course.php';
require_once __DIR__ . '/../../models/Category.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
  header('Location: ../auth/login.php');
  exit();
}

$message = '';
$messageType = '';

// Handle category form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
  switch ($_POST['action']) {
    case 'create':
      if (isset($_POST['nom']) && !empty($_POST['nom'])) {
        $category = new Category($_POST['nom']);
        $result = $category->create();
        if ($result['success']) {
          $message = "Catégorie créée avec succès";
          $messageType = 'success';
        } else {
          $message = $result['message'];
          $messageType = 'error';
        }
      }
      break;

    case 'update':
      if (isset($_POST['id']) && isset($_POST['nom']) && !empty($_POST['nom'])) {
        $result = Category::update($_POST['id'], $_POST['nom']);
        if ($result['success']) {
          $message = "Catégorie mise à jour avec succès";
          $messageType = 'success';
        } else {
          $message = $result['message'];
          $messageType = 'error';
        }
      }
      break;

    case 'delete':
      if (isset($_POST['id'])) {
        $result = Category::delete($_POST['id']);
        if ($result['success']) {
          $message = "Catégorie supprimée avec succès";
          $messageType = 'success';
        } else {
          $message = $result['message'];
          $messageType = 'error';
        }
      }
      break;
  }
}


  $admin = new Admin(
    $_SESSION['user']['nom'],
    $_SESSION['user']['email'],
    '',
    'admin',
    'actif'
  );

  $allUsers = $admin->getAllUsers();
  $totalStudents = count(array_filter($allUsers, function ($user) {
    return $user['role'] === 'etudiant';
  }));

  $totalTeachers = count(array_filter($allUsers, function ($user) {
    return $user['role'] === 'enseignant';
  }));

  $activeTeachers = count(array_filter($allUsers, function ($user) {
    return $user['role'] === 'enseignant' && $user['status'] === 'actif';
  }));

  $pendingTeachers = count(array_filter($allUsers, function ($user) {
    return $user['role'] === 'enseignant' && $user['status'] === 'en_attente';
  }));
  

  $pendingValidations = array_filter($allUsers, function ($user) {

    return $user['role'] === 'enseignant'   ;
  
  
  });
  ?>
  <!DOCTYPE html>
  <html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord Administrateur - Youdemy</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

    body {
      font-family: 'Poppins', sans-serif;
    }
  </style>
<body class="h-full">
  <div class="min-h-full">
    <!-- Navigation -->
    <nav class="bg-white border-b border-gray-200 fixed w-full z-30 top-0">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
          <!-- Logo et liens de navigation -->
          <div class="flex">
          
            <div class="hidden sm:ml-6 sm:flex sm:space-x-8">
              <a href="dashboard.php" class="border-indigo-500 text-gray-900 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                <i class="fas fa-chart-line mr-2"></i>
                Tableau de Bord
              </a>
            
            </div>
          </div>

          <!-- Section droite avec recherche, notifications et profil -->
          <div class="hidden sm:ml-6 sm:flex sm:items-center">
    

            <!-- Menu profil -->
            <div class="ml-3 relative">
              <div class="flex items-center">
                <button type="button" class="bg-white flex text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 items-center" id="user-menu-button" aria-expanded="false" aria-haspopup="true" onclick="toggleProfileDropdown()">
                  <span class="sr-only">Open user menu</span>
                  <img class="h-8 w-8 rounded-full object-cover border-2 border-gray-200" src="https://ui-avatars.com/api/?name=<?php echo urlencode($_SESSION['user']['nom']); ?>&background=random" alt="">
                  <span class="ml-2 text-gray-700 font-medium"><?php echo htmlspecialchars($_SESSION['user']['nom']); ?></span>
                  
                  

                </button>
                <a href="../auth/logout.php" class="block px-4 py-2 text-sm text-red-700 hover:bg-red-50" role="menuitem" onclick="return confirm('Êtes-vous sûr de vouloir vous déconnecter ?');">
                      <i class="fas fa-sign-out-alt mr-2"></i>
                      Déconnexion
                  </a>
              </div>
              <!-- Menu déroulant du profil -->
              <div id="profile-dropdown" class="hidden origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none" role="menu">
                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">
                  <i class="fas fa-user mr-2"></i>
                  Mon Profil
                </a>
                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">
                  <i class="fas fa-cog mr-2"></i>
                  Paramètres
                </a>
                <hr class="my-1">
                <a href="#" class="block px-4 py-2 text-sm text-red-700 hover:bg-red-50" role="menuitem">
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
          <a href="#" class="bg-indigo-50 border-indigo-500 text-indigo-700 block pl-3 pr-4 py-2 border-l-4 text-base font-medium">
            <i class="fas fa-chart-line mr-2"></i>
            Tableau de Bord
          </a>
          <a href="#" class="border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800 block pl-3 pr-4 py-2 border-l-4 text-base font-medium">
            <i class="fas fa-users mr-2"></i>
            Utilisateurs
          </a>
          <a href="#" class="border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800 block pl-3 pr-4 py-2 border-l-4 text-base font-medium">
            <i class="fas fa-graduation-cap mr-2"></i>
            Cours
          </a>
          <a href="#" class="border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800 block pl-3 pr-4 py-2 border-l-4 text-base font-medium">
            <i class="fas fa-folder mr-2"></i>
            Catégories
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
            <a href="#" class="block px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-800 hover:bg-gray-100">
              <i class="fas fa-user mr-2"></i>
              Mon Profil
            </a>
            <a href="#" class="block px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-800 hover:bg-gray-100">
              <i class="fas fa-cog mr-2"></i>
              Paramètres
            </a>
            <a href="#" class="block px-4 py-2 text-base font-medium text-red-600 hover:text-red-800 hover:bg-red-50">
              <i class="fas fa-sign-out-alt mr-2"></i>
              Déconnexion
            </a>
          </div>
        </div>
      </div>
    </nav>

  
  

    <!-- Contenu principal -->
    <main class="max-w-7xl mt-12 mx-auto py-6 sm:px-6 lg:px-8">
      <!-- Alert Message -->
      <?php if ($message): ?>
        <div class="mb-4 rounded-md p-4 <?php echo $messageType === 'success' ? 'bg-green-50 text-green-800' : 'bg-red-50 text-red-800'; ?>">
          <?php echo htmlspecialchars($message); ?>
        </div>
      <?php endif; ?>


  

      <!-- Section des validations en attente -->
      <div class="mt-8">
        <div class="bg-white shadow rounded-lg">
          <div class="px-4 py-5 sm:px-6 flex justify-between items-center">
            <div class="flex items-center">
              <i class="fas fa-user-clock text-yellow-500 text-xl mr-3"></i>
              <h3 class="text-lg leading-6 font-medium text-gray-900">Validations En Attente</h3>
            </div>
            <span class="inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
              <?php echo $pendingTeachers; ?>  en attente
            </span>
          </div>
          <div class="border-t border-gray-200">
            <div class="overflow-x-auto">
              <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                  <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Enseignant</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                  </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                  <?php foreach ($pendingValidations as $teacher): ?>
                    <tr class="hover:bg-gray-50">
                      <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                          <img class="h-10 w-10 rounded-full object-cover"
                            src="https://ui-avatars.com/api/?name=<?php echo urlencode($teacher['nom']); ?>&background=random"
                            alt="<?php echo htmlspecialchars($teacher['nom']); ?>">
                          <div class="ml-4">
                            <div class="text-sm font-medium text-gray-900">
                              <?php echo htmlspecialchars($teacher['nom']); ?>
                            </div>
                          </div>
                        </div>
                      </td>
                      <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900"><?php echo htmlspecialchars($teacher['email']); ?></div>
                      </td>
                      <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                        <?php echo $teacher['status']; ?>
                        </span>
                      </td>
                      <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <form method="POST" action="validate_teacher.php" class="inline-flex space-x-2">
                          <input type="hidden" name="teacher_id" value="<?php echo $teacher['id']; ?>">
                          <button type="submit" name="action" value="approve"
                            class="inline-flex items-center px-3 py-1 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                            <i class="fas fa-check mr-2"></i>
                            Approuver
                          </button>
                          <button type="submit" name="action" value="reject"
                            class="inline-flex items-center px-3 py-1 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                            <i  class="fas fa-times mr-2"></i>
                            Refuser
                          </button>
                        </form>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>

  

      <!-- Footer -->
    
</body>
  </html>