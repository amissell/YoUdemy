<?php
use app\batabases\DBConnection;

session_start();
require_once __DIR__ . '/../../vendor/autoload.php';



if ($_SERVER['REQUEST_METHOD'] === 'POST')
{
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $role = $_POST['role'];

    if (empty($username) || empty($email) || empty($password) || empty($confirm_password)) {
        echo "All fields are required.";
        exit;
}
}

$checK = "SELECT * FROM users WHERE email = :email OR username = :username";
    $stmt = $db_connection->prepare($checK);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':username', $username);
    $stmt->execute();

    

    $password_has = password_hash($password);
    $insert_query = "INSERT INTO users (username, email, password) VALUES (:username, :email, :password)";
    $stmt = $db_connection->prepare($insert_query);
    $stmt->bindParam($username);
    $stmt->bindParam($email);
    $stmt->bindParam($password_has);

    if ($stmt->execute()) {
        echo "User registered successfully.";
        $_SESSION['user_id'] = $db_connection->lastInsertId();
        $_SESSION['username'] = $username;
        $_SESSION['email'] = $email;
        header('Location: ../public/login.php'); // Or wherever you want the user to go after successful registration
    } else {
        echo "Error registering user.";
    }



?>
