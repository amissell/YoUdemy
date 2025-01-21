<?php
require_once __DIR__ . '/../../models/Auth.php';

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$auth = new Auth();
$result = $auth->logout();

// Fix the redirect path (remove the dot before login.php)
header("Location: login.php");
exit();