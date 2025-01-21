<?php
session_start();

require_once __DIR__ . '/../../config/connection.php';
require_once __DIR__ . '/../../models/Category.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: ../auth/login.php');
    exit();
}

$categoryId = isset($_GET['id']) ? (int)$_GET['id'] : null;
$message = '';
$messageType = '';
$category = null;

// Get category data
if ($categoryId) {
    $category = Category::getCategoryById($categoryId);
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update') {
    $newName = trim($_POST['nom']);
    if (!empty($newName) && isset($_POST['id'])) {
        $result = Category::update($_POST['id'], $newName);
        if ($result['success']) {
            $_SESSION['message'] = "Catégorie mise à jour avec succès";
            $_SESSION['messageType'] = 'success';
            header('Location: dashboard.php');
            exit();
        } else {
            $message = $result['message'];
            $messageType = 'error';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr" class="h-full bg-gray-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier la catégorie - Youdemy</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="h-full">
    <div class="min-h-full">
        <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
            <div class="px-4 py-6 sm:px-0">
                <div class="bg-white shadow rounded-lg p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h1 class="text-2xl font-bold text-gray-900">Modifier la catégorie</h1>
                        <a href="dashboard.php" class="text-gray-500 hover:text-gray-700">
                            <i class="fas fa-times"></i>
                        </a>
                    </div>

                    <?php if ($message): ?>
                        <div class="mb-4 rounded-md p-4 <?php echo $messageType === 'success' ? 'bg-green-50 text-green-800' : 'bg-red-50 text-red-800'; ?>">
                            <?php echo htmlspecialchars($message); ?>
                        </div>
                    <?php endif; ?>

                    <?php if ($category): ?>
                        <form method="POST" class="space-y-6">
                            <input type="hidden" name="action" value="update">
                            <input type="hidden" name="id" value="<?php echo $category['id_categorie']; ?>">
                            
                            <div>
                                <label for="nom" class="block text-sm font-medium text-gray-700">Nom de la catégorie</label>
                                <div class="mt-1">
                                    <input type="text" name="nom" id="nom" 
                                           value="<?php echo htmlspecialchars($category['nom']); ?>" 
                                           required 
                                           class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                </div>
                            </div>

                            <div class="flex justify-end space-x-3">
                                <a href="dashboard.php" 
                                   class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Annuler
                                </a>
                                <button type="submit" 
                                        class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Enregistrer les modifications
                                </button>
                            </div>
                        </form>
                    <?php else: ?>
                        <div class="text-center py-12">
                            <p class="text-gray-500">Catégorie non trouvée.</p>
                            <a href="dashboard.php" class="mt-4 inline-flex items-center text-indigo-600 hover:text-indigo-500">
                                <i class="fas fa-arrow-left mr-2"></i>
                                Retour au tableau de bord
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>