<?php
require_once '../../models/Admin.php';

session_start();

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: ../auth/login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['teacher_id'])) {
    $admin = new Admin($_SESSION['user']['nom'], $_SESSION['user']['email'], '', 'admin', 'actif');
    $teacherId = $_POST['teacher_id'];

    if ($_POST['action'] === 'approve') {
        $admin->validateTeacher($teacherId);
    } else if ($_POST['action'] === 'reject') {
        $admin->suspendUser($teacherId);
    }
}

header('Location: allEnseignement.php');
exit();
