<?php

namespace app\batabases;
use Dotenv\Dotenv;
use PDOException;
use PDO;

// require_once '../../vendor/autoload.php'; 

// Load .env file from the root of your project
$dotenv = Dotenv::createImmutable(dirname(__DIR__ . '/../../../'));
$dotenv->load();

// Connect to the database using PDO
class DBConnection {
    private $con;

    public function __construct() {
        try {
            $dsn = "mysql:host={$_ENV['DB_SERVER']};dbname={$_ENV['DB_NAME']};charset=utf8";
            $this->con = new PDO($dsn, $_ENV['DB_USERNAME'], $_ENV['DB_PASSWORD']);
            $this->con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            echo "Connected successfully";
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }

    public function getConnection() {
        return $this->con;
    }
}


?>