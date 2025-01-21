<?php
session_start();
require_once __DIR__ . '/../../models/Category.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: ../auth/login.php');
    exit();
}

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    
    switch ($action) {
        case 'create':
            if (isset($_POST['nom'])) {
                $category = new Category($_POST['nom']);
                $result = $category->create();
                echo json_encode($result);
            }
            break;
            
        case 'update':
            if (isset($_POST['id']) && isset($_POST['nom'])) {
                $result = Category::update($_POST['id'], $_POST['nom']);
                echo json_encode($result);
            }
            break;
            
        case 'delete':
            if (isset($_POST['id'])) {
                $result = Category::delete($_POST['id']);
                echo json_encode($result);
            }
            break;
            
        default:
            echo json_encode([
                'success' => false,
                'message' => 'Action non valide'
            ]);
    }
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Méthode non autorisée'
    ]);
}