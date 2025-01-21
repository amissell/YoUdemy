<?php
session_start();

require_once __DIR__ . '/../../config/connection.php';
require_once __DIR__ . '/../../models/Course.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: ../auth/login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update_status') {
    if (isset($_POST['course_id']) && isset($_POST['status'])) {
        $courseId = $_POST['course_id'];
        $status = $_POST['status'];

        $courseModel = new Course();

        try {
            $courseModel->updateCourseStatus($courseId, $status);
            $_SESSION['message'] = 'Statut du cours mis à jour avec succès';
            $_SESSION['messageType'] = 'success';
        } catch (Exception $e) {
            $_SESSION['message'] = 'Erreur lors de la mise à jour du cours: ' . $e->getMessage();
            $_SESSION['messageType'] = 'error';
        }
    } else {
        $_SESSION['message'] = 'Données manquantes pour la mise à jour du statut';
        $_SESSION['messageType'] = 'error';
    }

    header('Location: all_courses.php');
    exit();
}